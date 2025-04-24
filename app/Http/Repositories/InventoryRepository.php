<?php

namespace App\Http\Repositories;

use App\Models\DonationInventory;
use DB;

class InventoryRepository {
    public function getData($request, $address){
        $query = DonationInventory::query()
            ->join('donation_histories', 'donation_inventories.donation_id', '=', 'donation_histories.id')
            ->join('donors', 'donation_histories.donor_id', '=', 'donors.id');
    
        $query->when(isset($address['city']), function ($q) use ($address) {
            $q->where('donors.city', $address['city']->citymunDesc);
        });
    
        $query->when(isset($address['barangay']), function ($q) use ($address) {
            $q->where('donors.barangay', $address['barangay']);
        });
    
        $query->when(isset($address['province']), function ($q) use ($address) {
            $q->where('donors.province', $address['province']->provDesc);
        });
    
        $query->when(isset($request->blood_type), function ($q) use ($request) {
            $q->where('donors.blood_type', $request->blood_type);
        });
    
        return $query->select(
                'donation_histories.*', 
                'donation_inventories.*',
                'donors.blood_type',
                DB::raw("CONCAT(donors.last_name, ', ', donors.first_name) as donor_name"),
                DB::raw("CONCAT(donors.barangay, ', ', donors.city, ', ', donors.province) as address"),
                'donors.email',
                'donors.contact_number'
            )
            ->get();
    }
    

    public function getInventoryCount($request, $blood_type_name, $address){
        $query = DonationInventory::query();

        $query->when(isset($address['city']), function ($q) use ($address) {
            $q->where('donors.city', $address['city']->citymunDesc);
        });
    
        $query->when(isset($address['barangay']), function ($q) use ($address) {
            $q->where('donors.barangay', $address['barangay']);
        });
    
        $query->when(isset($address['province']), function ($q) use ($address) {
            $q->where('donors.province', $address['province']->provDesc);
        });
    
        $query->when(isset($request->blood_type), function ($q) use ($request) {
            $q->where('donors.blood_type', $request->blood_type);
        });

        return $query->join('donation_histories', 'donation_inventories.donation_id', '=', 'donation_histories.id')
        ->join('donors', 'donation_histories.donor_id', '=', 'donors.id')
        ->where('donors.blood_type', $blood_type_name)
        ->groupBy('donors.blood_type')       
        ->count();
    }
}