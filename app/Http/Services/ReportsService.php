<?php

namespace App\Http\Services;

use App\Models\Tree;
use App\Models\CuttingPermit;
use App\Models\ChainsawRequest;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ReportsService
{
    /**
     * Get dashboard report data
     * 
     * @param array $filters
     * @return array
     */
    public function getDashboardData(array $filters = [])
    {
        // Process date filters
        $dateRange = $this->processDateFilters($filters);
        
        return [
            'summary' => [
                'trees' => $this->getTreeSummary($dateRange),
                'permits' => $this->getCuttingPermitSummary($dateRange),
                'chainsaws' => $this->getChainsawSummary($dateRange)
            ],
            'charts' => [
                'comparison' => $this->getMonthlyComparisonData($dateRange['year'])
            ]
        ];
    }
    
    /**
     * Process date filters and return standardized date range
     * 
     * @param array $filters
     * @return array
     */
    private function processDateFilters(array $filters): array
    {
        $dateRange = $filters['date_range'] ?? 'this_month';
        $now = Carbon::now();
        
        switch ($dateRange) {
            case 'this_month':
                $startDate = $now->copy()->startOfMonth();
                $endDate = $now->copy()->endOfMonth();
                break;
            case 'last_month':
                $startDate = $now->copy()->subMonth()->startOfMonth();
                $endDate = $now->copy()->subMonth()->endOfMonth();
                break;
            case 'last_3_months':
                $startDate = $now->copy()->subMonths(3)->startOfMonth();
                $endDate = $now->copy()->endOfMonth();
                break;
            case 'last_6_months':
                $startDate = $now->copy()->subMonths(6)->startOfMonth();
                $endDate = $now->copy()->endOfMonth();
                break;
            case 'this_year':
                $startDate = $now->copy()->startOfYear();
                $endDate = $now->copy()->endOfYear();
                break;
            case 'custom':
                $startDate = isset($filters['start_date']) 
                    ? Carbon::parse($filters['start_date']) 
                    : $now->copy()->subMonth();
                $endDate = isset($filters['end_date'])
                    ? Carbon::parse($filters['end_date'])
                    : $now;
                break;
            default:
                $startDate = $now->copy()->startOfMonth();
                $endDate = $now->copy()->endOfMonth();
        }
        
        return [
            'start_date' => $startDate,
            'end_date' => $endDate,
            'year' => $now->year,
            'type' => $dateRange
        ];
    }
    
    /**
     * Get tree registration summary
     * 
     * @param array $dateRange
     * @return array
     */
    public function getTreeSummary(array $dateRange): array
    {
        // Total registered trees
        $totalTrees = Tree::whereBetween('created_at', [
            $dateRange['start_date'],
            $dateRange['end_date']
        ])->where('status', 1)->count();
        
        // Trees registered in the current period
        $currentPeriodTrees = Tree::whereBetween('created_at', [
            $dateRange['start_date'],
            $dateRange['end_date']
        ])->where('status', 1)->count();
        
        // Trees registered in the previous period (for comparison)
        $previousStartDate = $dateRange['start_date']->copy()->subDays($dateRange['start_date']->diffInDays($dateRange['end_date']));
        $previousEndDate = $dateRange['start_date']->copy()->subDay();
        
        $previousPeriodTrees = Tree::whereBetween('created_at', [
            $previousStartDate,
            $previousEndDate
        ])->where('status', 1)->count();
        
        // Calculate percentage change
        $percentageChange = 0;
        if ($previousPeriodTrees > 0) {
            $percentageChange = (($currentPeriodTrees - $previousPeriodTrees) / $previousPeriodTrees) * 100;
        }
        
        return [
            'total' => $totalTrees,
            'current_period' => $currentPeriodTrees,
            'previous_period' => $previousPeriodTrees,
            'percentage_change' => round($percentageChange, 1),
            'is_increase' => $percentageChange >= 0
        ];
    }
    
    /**
     * Get cutting permit summary
     * 
     * @param array $dateRange
     * @return array
     */
    public function getCuttingPermitSummary(array $dateRange): array
    {
        // Total cutting permits
        $totalPermits = CuttingPermit::whereBetween('created_at', [
            $dateRange['start_date'],
            $dateRange['end_date']
        ])->where('status', 1)->count();
        
        // Permits in the current period
        $currentPeriodPermits = CuttingPermit::whereBetween('created_at', [
            $dateRange['start_date'],
            $dateRange['end_date']
        ])->where('status', 1)->count();
        
        // Permits in the previous period (for comparison)
        $previousStartDate = $dateRange['start_date']->copy()->subDays($dateRange['start_date']->diffInDays($dateRange['end_date']));
        $previousEndDate = $dateRange['start_date']->copy()->subDay();
        
        $previousPeriodPermits = CuttingPermit::whereBetween('created_at', [
            $previousStartDate,
            $previousEndDate
        ])->where('status', 1)->count();
        
        // Calculate percentage change
        $percentageChange = 0;
        if ($previousPeriodPermits > 0) {
            $percentageChange = (($currentPeriodPermits - $previousPeriodPermits) / $previousPeriodPermits) * 100;
        }
        
        return [
            'total' => $totalPermits,
            'current_period' => $currentPeriodPermits,
            'previous_period' => $previousPeriodPermits,
            'percentage_change' => round($percentageChange, 1),
            'is_increase' => $percentageChange >= 0
        ];
    }
    
    /**
     * Get chainsaw registration summary
     * 
     * @param array $dateRange
     * @return array
     */
    public function getChainsawSummary(array $dateRange): array
    {
        // Total registered chainsaws
        $totalChainsaws = ChainsawRequest::whereBetween('created_at', [
            $dateRange['start_date'],
            $dateRange['end_date']
        ])->where('status', 1)->count();
        
        // Chainsaws registered in the current period
        $currentPeriodChainsaws = ChainsawRequest::whereBetween('created_at', [
            $dateRange['start_date'],
            $dateRange['end_date']
        ])->where('status', 1)->count();
        
        // Chainsaws registered in the previous period (for comparison)
        $previousStartDate = $dateRange['start_date']->copy()->subDays($dateRange['start_date']->diffInDays($dateRange['end_date']));
        $previousEndDate = $dateRange['start_date']->copy()->subDay();
        
        $previousPeriodChainsaws = ChainsawRequest::whereBetween('created_at', [
            $previousStartDate,
            $previousEndDate
        ])->where('status', 1)->count();
        
        // Calculate percentage change
        $percentageChange = 0;
        if ($previousPeriodChainsaws > 0) {
            $percentageChange = (($currentPeriodChainsaws - $previousPeriodChainsaws) / $previousPeriodChainsaws) * 100;
        }
        
        return [
            'total' => $totalChainsaws,
            'current_period' => $currentPeriodChainsaws,
            'previous_period' => $previousPeriodChainsaws,
            'percentage_change' => round($percentageChange, 1),
            'is_increase' => $percentageChange >= 0
        ];
    }
    
    /**
     * Get monthly comparison data for charts
     * 
     * @param int $year
     * @return array
     */
    public function getMonthlyComparisonData(int $year): array
    {
        // Get monthly tree registrations
        $treeData = $this->getMonthlyData(Tree::class, $year);
        
        // Get monthly cutting permits
        $permitData = $this->getMonthlyData(CuttingPermit::class, $year);
        
        // Get monthly chainsaw registrations
        $chainsawData = $this->getMonthlyData(ChainsawRequest::class, $year);
        
        return [
            'months' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            'trees' => $treeData,
            'permits' => $permitData,
            'chainsaws' => $chainsawData
        ];
    }
    
    /**
     * Get monthly data for a specific model
     * 
     * @param string $model
     * @param int $year
     * @return array
     */
    private function getMonthlyData(string $model, int $year): array
    {
        $monthlyData = DB::table((new $model)->getTable())
            ->select(DB::raw('MONTH(created_at) as month, COUNT(*) as count'))
            ->whereYear('created_at', $year)
            ->groupBy(DB::raw('MONTH(created_at)'))
            ->orderBy(DB::raw('MONTH(created_at)'))
            ->get()
            ->pluck('count', 'month')
            ->toArray();
        
        // Fill in missing months with zeros
        $result = [];
        for ($month = 1; $month <= 12; $month++) {
            $result[] = $monthlyData[$month] ?? 0;
        }
        
        return $result;
    }
}