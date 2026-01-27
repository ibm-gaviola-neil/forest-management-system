<?php

namespace App\Http\Services;

use App\Http\Repositories\DashboardRepository;
use App\Http\Repositories\EventRepository;
use App\Http\Repositories\InventoryRepository;

class DashboardService {
    protected $inventory_repository;
    protected $dashboard_repository;
    protected $event_repository;
    protected $inventory_service;
    protected $donor_service;

    public function __construct(
        InventoryRepository $inventory_repository, 
        DonorService $donor_service,
        InventoryService $inventory_service,
        DashboardRepository $dashboardRepository,
        EventRepository $event_repository
    ) {   
        $this->donor_service = $donor_service;
        $this->inventory_repository = $inventory_repository;
        $this->inventory_service = $inventory_service;
        $this->dashboard_repository = $dashboardRepository;
        $this->event_repository = $event_repository;
    }

    public function setDashboardData($request){
        return [
            'blood_types' => $this->inventory_service
                ->getBloodTypeCount($request, $this->donor_service->getDonorRequestAddress($request)),
            'counts' => $this->dashboard_repository->counts(),
            'events' => $this->event_repository->getEvents(),
            'pageTitle' => 'Dashboard',
            'pageSubTitle' => 'Data Requests and Overview'
        ];
    }

    public function getTotalDonors() {
        return [
            'total_donors' => $this->dashboard_repository->numberOfDonors()
        ];
    }
}