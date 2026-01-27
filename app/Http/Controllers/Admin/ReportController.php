<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Services\ReportsService;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    protected $reportsService;

    public function __construct(ReportsService $reportsService)
    {
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

        $activityPage = $request->input('page', 1);

        $reportData = $this->reportsService->getDashboardData($filters, $activityPage);

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

    /**
     * Get activity data only (for pagination)
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getActivityData(Request $request)
    {
        $filters = [
            'date_range' => $request->input('date_range', 'this_month'),
            'start_date' => $request->input('start_date'),
            'end_date' => $request->input('end_date'),
        ];

        $page = $request->input('page', 1);

        $dateRange = $this->reportsService->processDateFilters($filters);
        $activities = $this->reportsService->getRecentActivity($dateRange, $page);

        return response()->json($activities);
    }

    /**
     * Export report data as Excel or CSV file
     * 
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse|\Illuminate\Http\Response
     */
    public function exportReport(Request $request)
    {
        $filters = [
            'date_range' => $request->input('date_range', 'this_month'),
            'start_date' => $request->input('start_date'),
            'end_date' => $request->input('end_date'),
        ];

        // Determine the export format (xlsx is the default)
        $format = $request->input('format', 'xlsx');

        // Generate and return the export file
        return $this->reportsService->exportReport($filters, $format);
    }
}
