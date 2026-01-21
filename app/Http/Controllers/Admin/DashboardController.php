<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Services\CuttingPermitService;
use App\Http\Services\DashboardService;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    protected $dashboard_service;
    private $cuttingPermitService;

    public function __construct(DashboardService $dashboard_service, CuttingPermitService $cuttingPermitService){
        $this->dashboard_service = $dashboard_service;
        $this->cuttingPermitService = $cuttingPermitService;
    }

    public function index(Request $request){
        $data = $this->dashboard_service->setDashboardData($request);
        return view('Pages.Admin.index', $data);
    }

    public function getNumberOfDonors(){
        return response()->json(
            $this->dashboard_service->getTotalDonors()
        );
    }

    public function pendingCuttingPermit(Request $request)
    {
        $role = auth()->user()->role;
        $data = $this->cuttingPermitService->getCuttingPermitData($role, $request, 0);

        return response()->json($data);
    }
}
