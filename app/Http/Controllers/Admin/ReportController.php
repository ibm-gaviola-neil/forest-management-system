<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Services\ReportsService;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    protected $reportsService;

    public function __construct(ReportsService $reportsService){
        $this->reportsService = $reportsService;
    }
    
    /**
     * Display the reports page with initial data.
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $filters = [
            'date_range' => $request->input('date_range', 'this_month'),
            'start_date' => $request->input('start_date'),
            'end_date' => $request->input('end_date'),
        ];
        
        $reportData = $this->reportsService->getDashboardData($filters);

        // dd($reportData);
        
        return view('Pages.Admin.reports.index', compact('reportData', 'filters'));
    }

    /**
     * Get report data via AJAX request
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getReportData(Request $request)
    {
        $filters = [
            'date_range' => $request->input('date_range', 'this_month'),
            'start_date' => $request->input('start_date'),
            'end_date' => $request->input('end_date'),
        ];
        
        $reportData = $this->reportsService->getDashboardData($filters);
        
        return response()->json($reportData);
    }

    // public function export(Request $request){
    //     return $this->reportService->exportReport($request);
    // }
}
