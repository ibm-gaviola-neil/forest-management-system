<?php

namespace App\Http\Services;

use App\Models\Tree;
use App\Models\CuttingPermit;
use App\Models\ChainsawRequest;
use App\Models\Incident;
use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Illuminate\Support\Facades\Response;

class ReportsService
{
    /**
     * Get dashboard report data
     * 
     * @param array $filters
     * @return array
     */
    public function getDashboardData(array $filters = [], int $activityPage = 1)
    {
        // Process date filters
        $dateRange = $this->processDateFilters($filters);
        // Get activity data with pagination
        $recentActivity = $this->getRecentActivity($dateRange, $activityPage);

        return [
            'summary' => [
                'trees' => $this->getTreeSummary($dateRange),
                'permits' => $this->getCuttingPermitSummary($dateRange),
                'chainsaws' => $this->getChainsawSummary($dateRange),
                'incidents' => $this->getIncidentsSummary($dateRange),
            ],
            'charts' => [
                'comparison' => $this->getMonthlyComparisonData($dateRange['year']),
                'incidents' => $this->getMonthlyIncidentsData($dateRange['year'])
            ],
            'activities' => $recentActivity
        ];
    }

    /**
     * Process date filters and return standardized date range
     * 
     * @param array $filters
     * @return array
     */
    public function processDateFilters(array $filters): array
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

    public function getIncidentsSummary(array $dateRange): array
    {
        // Total registered trees
        $totalTrees = Incident::whereBetween('incident_date', [
            $dateRange['start_date'],
            $dateRange['end_date']
        ])->count();

        // Trees registered in the current period
        $currentPeriodTrees = Incident::whereBetween('incident_date', [
            $dateRange['start_date'],
            $dateRange['end_date']
        ])->count();

        // Trees registered in the previous period (for comparison)
        $previousStartDate = $dateRange['start_date']->copy()->subDays($dateRange['start_date']->diffInDays($dateRange['end_date']));
        $previousEndDate = $dateRange['start_date']->copy()->subDay();

        $previousPeriodTrees = Incident::whereBetween('incident_date', [
            $previousStartDate,
            $previousEndDate
        ])->count();

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

    public function getMonthlyIncidentsData(int $year): array
    {
        // Get monthly tree registrations
        $incidentData = $this->getMonthlyIncidents(Incident::class, $year);

        return [
            'months' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            'incidents' => $incidentData,
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


    /**
     * Get monthly data for a specific model
     * 
     * @param string $model
     * @param int $year
     * @return array
     */
    private function getMonthlyIncidents(string $model, int $year): array
    {
        $monthlyData = DB::table((new $model)->getTable())
            ->select(DB::raw('MONTH(incident_date) as month, COUNT(*) as count'))
            ->whereYear('created_at', $year)
            ->groupBy(DB::raw('MONTH(incident_date)'))
            ->orderBy(DB::raw('MONTH(incident_date)'))
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

    /**
     * Get recent activity data from multiple tables
     * 
     * @param array $dateRange
     * @param int $page
     * @param int $perPage
     * @return array
     */
    public function getRecentActivity(array $dateRange, int $page = 1, int $perPage = 10): array
    {
        // Get data from Trees table
        $trees = Tree::with('user')
            ->whereBetween('created_at', [$dateRange['start_date'], $dateRange['end_date']])
            ->get()
            ->map(function ($item) {
                return [
                    'id' => 'TR-' . str_pad($item->id, 6, '0', STR_PAD_LEFT),
                    'type' => 'tree',
                    'type_name' => 'Tree Registration',
                    'description' => $item->treeType . ' tree registration' . ($item->location ? ' in ' . $item->location : ''),
                    'user_name' => optional($item->user)->first_name . ' ' . optional($item->user)->last_name,
                    'user_id' => $item->user_id,
                    'date' => $item->created_at,
                    'status' => $item->status,
                    'status_name' => $this->getStatusName('tree', $item->status),
                    'data' => $item,
                ];
            });

        // Get data from CuttingPermit table
        $permits = CuttingPermit::with(['user', 'tree'])
            ->whereBetween('created_at', [$dateRange['start_date'], $dateRange['end_date']])
            ->get()
            ->map(function ($item) {
                $description = 'Cutting permit request';
                if ($item->tree) {
                    $description .= ' for ' . optional($item->tree)->treeType . ' tree';
                }
                if ($item->reason) {
                    $plainReason = strip_tags($item->reason);
                    if (strlen($plainReason) > 60) {
                        $plainReason = substr($plainReason, 0, 60) . '...';
                    }
                    $description .= ': ' . $plainReason;
                }

                return [
                    'id' => 'CP-' . str_pad($item->id, 6, '0', STR_PAD_LEFT),
                    'type' => 'permit',
                    'type_name' => 'Cutting Permit',
                    'description' => $description,
                    'user_name' => optional($item->user)->first_name . ' ' . optional($item->user)->last_name,
                    'user_id' => $item->user_id,
                    'date' => $item->created_at,
                    'status' => $item->status,
                    'status_name' => $this->getStatusName('permit', $item->status),
                    'data' => $item,
                ];
            });

        // Get data from ChainsawRequest table
        $chainsaws = ChainsawRequest::with('user')
            ->whereBetween('created_at', [$dateRange['start_date'], $dateRange['end_date']])
            ->get()
            ->map(function ($item) {
                return [
                    'id' => 'CS-' . str_pad($item->id, 6, '0', STR_PAD_LEFT),
                    'type' => 'chainsaw',
                    'type_name' => 'Chainsaw Registration',
                    'description' => $item->brand . ' ' . $item->model . ' chainsaw registration',
                    'user_name' => optional($item->user)->first_name . ' ' . optional($item->user)->last_name,
                    'user_id' => $item->user_id,
                    'date' => $item->created_at,
                    'status' => $item->status,
                    'status_name' => $this->getStatusName('chainsaw', $item->status),
                    'data' => $item,
                ];
            });

        // Combine all activities
        $allActivities = $trees->concat($permits)->concat($chainsaws);

        // Sort by date (most recent first)
        $sortedActivities = $allActivities->sortByDesc('date')->values();

        // Manual pagination
        $total = $sortedActivities->count();
        $items = $sortedActivities->forPage($page, $perPage)->values();

        // Create a length-aware paginator
        $paginator = new LengthAwarePaginator(
            $items,
            $total,
            $perPage,
            $page,
            ['path' => Paginator::resolveCurrentPath()]
        );

        return [
            'data' => $paginator->items(),
            'pagination' => [
                'total' => $paginator->total(),
                'per_page' => $paginator->perPage(),
                'current_page' => $paginator->currentPage(),
                'last_page' => $paginator->lastPage(),
                'from' => $paginator->firstItem(),
                'to' => $paginator->lastItem()
            ]
        ];
    }

    /**
     * Get human-readable status name based on status code
     *
     * @param string $type
     * @param int $status
     * @return string
     */
    private function getStatusName(string $type, int $status): string
    {
        $statuses = [
            'tree' => [
                0 => 'Pending',
                1 => 'Approved',
                2 => 'Rejected',
                3 => 'Cancelled',
                4 => 'For Cutting'
            ],
            'permit' => [
                0 => 'Pending',
                1 => 'Approved',
                2 => 'Rejected',
                3 => 'Cancelled'
            ],
            'chainsaw' => [
                0 => 'Pending',
                1 => 'Approved',
                2 => 'Rejected',
                3 => 'Cancelled'
            ]
        ];

        return $statuses[$type][$status] ?? 'Unknown';
    }

    /**
     * Generate and export report data to Excel/CSV
     * 
     * @param array $filters
     * @param string $format
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function exportReport(array $filters, string $format = 'xlsx')
    {
        // Process date filters
        $dateRange = $this->processDateFilters($filters);

        // Get all activities for the period (without pagination)
        $activities = $this->getAllActivitiesForExport($dateRange);

        // Get summary data
        $treeSummary = $this->getTreeSummary($dateRange);
        $permitSummary = $this->getCuttingPermitSummary($dateRange);
        $chainsawSummary = $this->getChainsawSummary($dateRange);

        // Get monthly data
        $monthlyData = $this->getMonthlyComparisonData($dateRange['year']);

        // Generate file name
        $fileName = 'forest_monitoring_report_' . Carbon::now()->format('Y-m-d_His');

        // Determine the export format
        if ($format === 'csv') {
            return $this->generateCsv($fileName, $activities, $treeSummary, $permitSummary, $chainsawSummary);
        } else {
            return $this->generateExcel($fileName, $activities, $treeSummary, $permitSummary, $chainsawSummary, $monthlyData, $dateRange);
        }
    }

    /**
     * Get all activities without pagination for export
     * 
     * @param array $dateRange
     * @return array
     */
    private function getAllActivitiesForExport(array $dateRange): array
    {
        // Get data from Trees table
        $trees = Tree::with('user')
            ->whereBetween('created_at', [$dateRange['start_date'], $dateRange['end_date']])
            ->get()
            ->map(function ($item) {
                return [
                    'id' => 'TR-' . str_pad($item->id, 6, '0', STR_PAD_LEFT),
                    'type' => 'Tree Registration',
                    'description' => $item->treeType . ' tree registration' . ($item->location ? ' in ' . $item->location : ''),
                    'user_name' => optional($item->user)->first_name . ' ' . optional($item->user)->last_name,
                    'date' => $item->created_at->format('Y-m-d H:i:s'),
                    'status' => $this->getStatusName('tree', $item->status),
                    'height' => $item->height,
                    'diameter' => $item->diameter,
                    'location' => $item->location,
                ];
            });

        // Get data from CuttingPermit table
        $permits = CuttingPermit::with(['user', 'tree'])
            ->whereBetween('created_at', [$dateRange['start_date'], $dateRange['end_date']])
            ->get()
            ->map(function ($item) {
                $description = 'Cutting permit request';
                if ($item->tree) {
                    $description .= ' for ' . optional($item->tree)->treeType . ' tree';
                }
                if ($item->reason) {
                    $plainReason = strip_tags($item->reason);
                    if (strlen($plainReason) > 60) {
                        $plainReason = substr($plainReason, 0, 60) . '...';
                    }
                    $description .= ': ' . $plainReason;
                }

                return [
                    'id' => 'CP-' . str_pad($item->id, 6, '0', STR_PAD_LEFT),
                    'type' => 'Cutting Permit',
                    'description' => $description,
                    'user_name' => optional($item->user)->first_name . ' ' . optional($item->user)->last_name,
                    'date' => $item->created_at->format('Y-m-d H:i:s'),
                    'status' => $this->getStatusName('permit', $item->status),
                    'tree_id' => optional($item->tree)->treeId,
                    'reason' => strip_tags($item->reason ?? ''),
                ];
            });

        // Get data from ChainsawRequest table
        $chainsaws = ChainsawRequest::with('user')
            ->whereBetween('created_at', [$dateRange['start_date'], $dateRange['end_date']])
            ->get()
            ->map(function ($item) {
                return [
                    'id' => 'CS-' . str_pad($item->id, 6, '0', STR_PAD_LEFT),
                    'type' => 'Chainsaw Registration',
                    'description' => $item->brand . ' ' . $item->model . ' chainsaw registration',
                    'user_name' => optional($item->user)->first_name . ' ' . optional($item->user)->last_name,
                    'date' => $item->created_at->format('Y-m-d H:i:s'),
                    'status' => $this->getStatusName('chainsaw', $item->status),
                    'brand' => $item->brand,
                    'model' => $item->model,
                    'serial_number' => $item->serial_number,
                ];
            });

        // Combine all activities and sort by date (most recent first)
        return $trees->concat($permits)->concat($chainsaws)->sortByDesc('date')->values()->toArray();
    }

    /**
     * Generate Excel file
     * 
     * @param string $fileName
     * @param array $activities
     * @param array $treeSummary
     * @param array $permitSummary
     * @param array $chainsawSummary
     * @param array $monthlyData
     * @param array $dateRange
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    private function generateExcel(string $fileName, array $activities, array $treeSummary, array $permitSummary, array $chainsawSummary, array $monthlyData, array $dateRange)
    {
        // Create a new spreadsheet
        $spreadsheet = new Spreadsheet();

        // Set document properties
        $spreadsheet->getProperties()
            ->setCreator('Forest Monitoring System')
            ->setLastModifiedBy('Forest Monitoring System')
            ->setTitle('Forest Monitoring Report')
            ->setSubject('Forest Monitoring Report')
            ->setDescription('Report generated from the Forest Monitoring System')
            ->setKeywords('forest monitoring trees chainsaws permits')
            ->setCategory('Reports');

        // Create the summary sheet
        $summarySheet = $spreadsheet->getActiveSheet();
        $summarySheet->setTitle('Summary');

        // Add report title and date range
        $summarySheet->setCellValue('A1', 'Forest Monitoring Report');
        $summarySheet->setCellValue('A2', 'Period: ' . $dateRange['start_date']->format('M d, Y') . ' to ' . $dateRange['end_date']->format('M d, Y'));
        $summarySheet->setCellValue('A3', 'Generated on: ' . Carbon::now()->format('M d, Y H:i'));

        // Style the title
        $summarySheet->getStyle('A1')->getFont()->setBold(true)->setSize(16);
        $summarySheet->getStyle('A2:A3')->getFont()->setSize(12);

        // Add summary data
        $summarySheet->setCellValue('A5', 'Summary Statistics');
        $summarySheet->getStyle('A5')->getFont()->setBold(true)->setSize(14);

        // Tree summary
        $summarySheet->setCellValue('A7', 'Registered Trees');
        $summarySheet->setCellValue('B7', 'Total');
        $summarySheet->setCellValue('C7', 'Current Period');
        $summarySheet->setCellValue('D7', 'Previous Period');
        $summarySheet->setCellValue('E7', 'Change (%)');

        $summarySheet->setCellValue('A8', '');
        $summarySheet->setCellValue('B8', $treeSummary['total']);
        $summarySheet->setCellValue('C8', $treeSummary['current_period']);
        $summarySheet->setCellValue('D8', $treeSummary['previous_period']);
        $summarySheet->setCellValue('E8', $treeSummary['percentage_change'] . '%');

        // Cutting permit summary
        $summarySheet->setCellValue('A10', 'Cutting Permits');
        $summarySheet->setCellValue('B10', 'Total');
        $summarySheet->setCellValue('C10', 'Current Period');
        $summarySheet->setCellValue('D10', 'Previous Period');
        $summarySheet->setCellValue('E10', 'Change (%)');

        $summarySheet->setCellValue('A11', '');
        $summarySheet->setCellValue('B11', $permitSummary['total']);
        $summarySheet->setCellValue('C11', $permitSummary['current_period']);
        $summarySheet->setCellValue('D11', $permitSummary['previous_period']);
        $summarySheet->setCellValue('E11', $permitSummary['percentage_change'] . '%');

        // Chainsaw summary
        $summarySheet->setCellValue('A13', 'Chainsaw Registrations');
        $summarySheet->setCellValue('B13', 'Total');
        $summarySheet->setCellValue('C13', 'Current Period');
        $summarySheet->setCellValue('D13', 'Previous Period');
        $summarySheet->setCellValue('E13', 'Change (%)');

        $summarySheet->setCellValue('A14', '');
        $summarySheet->setCellValue('B14', $chainsawSummary['total']);
        $summarySheet->setCellValue('C14', $chainsawSummary['current_period']);
        $summarySheet->setCellValue('D14', $chainsawSummary['previous_period']);
        $summarySheet->setCellValue('E14', $chainsawSummary['percentage_change'] . '%');

        // Add monthly data
        $summarySheet->setCellValue('A16', 'Monthly Trends - ' . $dateRange['year']);
        $summarySheet->getStyle('A16')->getFont()->setBold(true)->setSize(14);

        // Headers
        $summarySheet->setCellValue('A18', 'Month');
        $summarySheet->setCellValue('B18', 'Tree Registrations');
        $summarySheet->setCellValue('C18', 'Cutting Permits');
        $summarySheet->setCellValue('D18', 'Chainsaw Registrations');

        // Monthly data
        for ($i = 0; $i < 12; $i++) {
            $summarySheet->setCellValue('A' . (19 + $i), $monthlyData['months'][$i]);
            $summarySheet->setCellValue('B' . (19 + $i), $monthlyData['trees'][$i]);
            $summarySheet->setCellValue('C' . (19 + $i), $monthlyData['permits'][$i]);
            $summarySheet->setCellValue('D' . (19 + $i), $monthlyData['chainsaws'][$i]);
        }

        // Auto-size columns
        foreach (range('A', 'E') as $col) {
            $summarySheet->getColumnDimension($col)->setAutoSize(true);
        }

        // Create the activities sheet
        $activitiesSheet = $spreadsheet->createSheet();
        $activitiesSheet->setTitle('Activities');

        // Add headers
        $activitiesSheet->setCellValue('A1', 'ID');
        $activitiesSheet->setCellValue('B1', 'Type');
        $activitiesSheet->setCellValue('C1', 'Description');
        $activitiesSheet->setCellValue('D1', 'User');
        $activitiesSheet->setCellValue('E1', 'Date');
        $activitiesSheet->setCellValue('F1', 'Status');

        // Style the headers
        $activitiesSheet->getStyle('A1:F1')->getFont()->setBold(true);

        // Add activities data
        $row = 2;
        foreach ($activities as $activity) {
            $activitiesSheet->setCellValue('A' . $row, $activity['id']);
            $activitiesSheet->setCellValue('B' . $row, $activity['type']);
            $activitiesSheet->setCellValue('C' . $row, $activity['description']);
            $activitiesSheet->setCellValue('D' . $row, $activity['user_name']);
            $activitiesSheet->setCellValue('E' . $row, $activity['date']);
            $activitiesSheet->setCellValue('F' . $row, $activity['status']);
            $row++;
        }

        // Auto-size columns
        foreach (range('A', 'F') as $col) {
            $activitiesSheet->getColumnDimension($col)->setAutoSize(true);
        }

        // Write the file
        $writer = new Xlsx($spreadsheet);
        $filePath = storage_path('app/public/' . $fileName . '.xlsx');
        $writer->save($filePath);

        // Return download response
        return response()->download($filePath, $fileName . '.xlsx', [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ])->deleteFileAfterSend(true);
    }

    /**
     * Generate CSV file
     * 
     * @param string $fileName
     * @param array $activities
     * @param array $treeSummary
     * @param array $permitSummary
     * @param array $chainsawSummary
     * @return \Symfony\Component\HttpFoundation\Response
     */
    private function generateCsv(string $fileName, array $activities, array $treeSummary, array $permitSummary, array $chainsawSummary)
    {
        // Create CSV content
        $headers = ['ID', 'Type', 'Description', 'User', 'Date', 'Status'];

        // Use PHP's native CSV functions for proper escaping
        $output = fopen('php://temp', 'r+');

        // Add report header info
        fputcsv($output, ['Forest Monitoring Report']);
        fputcsv($output, ['Generated on: ' . Carbon::now()->format('Y-m-d H:i:s')]);
        fputcsv($output, []); // Empty line

        // Add summary data
        fputcsv($output, ['Summary Statistics']);
        fputcsv($output, []); // Empty line

        // Tree summary
        fputcsv($output, ['Registered Trees']);
        fputcsv($output, ['Total', 'Current Period', 'Previous Period', 'Change (%)']);
        fputcsv($output, [
            $treeSummary['total'],
            $treeSummary['current_period'],
            $treeSummary['previous_period'],
            $treeSummary['percentage_change'] . '%'
        ]);
        fputcsv($output, []); // Empty line

        // Cutting permit summary
        fputcsv($output, ['Cutting Permits']);
        fputcsv($output, ['Total', 'Current Period', 'Previous Period', 'Change (%)']);
        fputcsv($output, [
            $permitSummary['total'],
            $permitSummary['current_period'],
            $permitSummary['previous_period'],
            $permitSummary['percentage_change'] . '%'
        ]);
        fputcsv($output, []); // Empty line

        // Chainsaw summary
        fputcsv($output, ['Chainsaw Registrations']);
        fputcsv($output, ['Total', 'Current Period', 'Previous Period', 'Change (%)']);
        fputcsv($output, [
            $chainsawSummary['total'],
            $chainsawSummary['current_period'],
            $chainsawSummary['previous_period'],
            $chainsawSummary['percentage_change'] . '%'
        ]);
        fputcsv($output, []); // Empty line

        // Activities section
        fputcsv($output, ['Activity Log']);
        fputcsv($output, []); // Empty line

        // Column headers
        fputcsv($output, $headers);

        // Add activity data
        foreach ($activities as $activity) {
            fputcsv($output, [
                $activity['id'],
                $activity['type'],
                $activity['description'],
                $activity['user_name'],
                $activity['date'],
                $activity['status']
            ]);
        }

        // Reset file pointer
        rewind($output);

        // Get the content
        $content = stream_get_contents($output);
        fclose($output);

        // Create response with CSV file
        $response = Response::make($content, 200);
        $response->header('Content-Type', 'text/csv');
        $response->header('Content-Disposition', 'attachment; filename="' . $fileName . '.csv"');

        return $response;
    }
}
