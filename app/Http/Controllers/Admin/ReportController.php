<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ReportRequest;
use App\Http\Services\ReportService;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    protected $reportService;

    public function __construct(ReportService $reportService){
        $this->reportService = $reportService;
    }
    public function index(Request $request){
        $data = $this->reportService->getReportData($request);
        return view('Pages.Admin.reports.index', $data);
    }

    public function export(Request $request){
        return $this->reportService->exportReport($request);
    }
}
