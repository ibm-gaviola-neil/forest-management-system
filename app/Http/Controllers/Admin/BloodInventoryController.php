<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Services\DonorService;
use App\Http\Services\InventoryService;
use Illuminate\Http\Request;

class BloodInventoryController extends Controller
{
    protected $donor_service;
    protected $inventory_service;

    public function __construct(
        DonorService $donor_service,
        InventoryService $inventory_service
    ){
        $this->donor_service = $donor_service;
        $this->inventory_service = $inventory_service;
    }
    public function index(Request $request){
        $inventoryData = $this->inventory_service->getInventoryData($request);
        return view('Pages.Admin.inventory', $inventoryData);
    }
}
