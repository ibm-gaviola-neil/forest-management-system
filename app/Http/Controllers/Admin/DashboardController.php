<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Services\DashboardService;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    protected $dashboard_service;

    public function __construct(DashboardService $dashboard_service){
        $this->dashboard_service = $dashboard_service;
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
}
