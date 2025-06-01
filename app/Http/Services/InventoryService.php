<?php

namespace App\Http\Services;

use App\Http\Domains\BloodTypeDomain;
use App\Http\Repositories\InventoryRepository;
use App\Models\DonationInventory;
use App\Models\Donor;
use App\Models\Province;
use Date;

class InventoryService {
    protected $inventory_repository;
    protected $donor_service;
    public function __construct(
        InventoryRepository $inventoryRepository, 
        DonorService $donorService
    ){
        $this->inventory_repository = $inventoryRepository; 
        $this->donor_service = $donorService;
    }

    private function inventoryData($data, $donations): array{
        $donor = Donor::where("id", $data["donor_id"])->first();
        $inventoryData = [];
    
        foreach ($donations as $donation) {
            $inventoryData []= [
                'donation_id' => $donation->id,
                'blood_type' => $donor->blood_type,
                'date_donated' => $donation->date_process,
                'status' => 'available',
                'created_at' => Date::now(),
                'updated_at' => Date::now()
            ];
        }

        return $inventoryData;
    }

    public function saveInventoryData($payload, $donation): bool{
        $data = $this->inventoryData($payload, $donation);
        $save = DonationInventory::insert($data);

        if(!$save){
            return false;
        }
        return true;
    }

    public function getInventoryData($request){
        return [
            'provinces' => Province::orderBy('provDesc', 'ASC')->get(),
            'inventoryData' => $this->inventory_repository->getData($request, $this->donor_service->getDonorRequestAddress($request)),
            'address' => $this->donor_service->getDonorRequestAddress($request),
            'blood_types' => $this->getBloodTypeCount($request, $this->donor_service->getDonorRequestAddress($request)),
            'donors' => [],
            'request' => $request
        ];
    }

    public function getBloodTypeCount($request, $address){
        $blood_types = BloodTypeDomain::BLOOD_TYPES;
        $types = [];
        foreach ($blood_types as $key => $value) {
            $types[$key] = $this->inventory_repository->getInventoryCount($request, $value, $address);
        }
        return $types;
    }
}