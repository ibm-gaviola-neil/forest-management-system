<?php

namespace App\Http\Repositories;

use App\Models\BloodIssuance;
use App\Models\DonationInventory;
use DB;

class InventoryRepository {
    public function getData($request, $address){
        $query = DonationInventory::query()
            ->join('donation_histories', 'donation_inventories.donation_id', '=', 'donation_histories.id')
            ->join('donors', 'donation_histories.donor_id', '=', 'donors.id');

        $query->when(filled($request->start_date) && filled($request->end_date) && !filled($request->month) && !filled($request->year), function ($q) use ($request) {
            $q->whereBetween('donation_histories.date_process', [$request->start_date, $request->end_date]);
        });
        
        $query->when(filled($request->start_date) && !filled($request->end_date) && !filled($request->month) && !filled($request->year), function ($q) use ($request) {
            $q->whereDate('donation_histories.date_process', '>=', $request->start_date);
        });
        
        $query->when(filled($request->end_date) && !filled($request->start_date) && !filled($request->month) && !filled($request->year), function ($q) use ($request) {
            $q->whereDate('donation_histories.date_process', '<=', $request->end_date);
        });
        
        $query->when(filled($request->month), function ($q) use ($request) {
            $q->whereMonth('donation_histories.date_process', $request->month);
        });
        
        $query->when(filled($request->year), function ($q) use ($request) {
            $q->whereYear('donation_histories.date_process', $request->year);
        });   
            
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
                'donors.id as donor_id',
                'donation_histories.blood_bag_id', 
                DB::raw("CONCAT(donors.last_name, ', ', donors.first_name) as donor_name"),
                'donors.email',
                'donors.contact_number',
                'donors.blood_type',
                'donation_histories.expiration_date',
                'donors.province',
                'donors.city', 
                'donors.barangay',
                'donation_histories.date_process',
                'donation_histories.created_at'
            )
            ->orderBy('donation_histories.date_process', 'desc')
            ->get();
    }
    

    public function getInventoryCount($request, $blood_type_name, $address, $withCount = null){
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

        if(isset($request->start_date) && isset($request->end_date)){
            $query->whereBetween('donation_histories.created_at', [$request->start_date, $request->end_date]);
        }

        if($withCount){
            $query->where('donation_histories.count', 1);
        }

        return $query->join('donation_histories', 'donation_inventories.donation_id', '=', 'donation_histories.id')
        ->join('donors', 'donation_histories.donor_id', '=', 'donors.id')
        ->where('donors.blood_type', $blood_type_name)
        ->groupBy('donors.blood_type')       
        ->count();
    }

    public function getIssuanceCount($request, $blood_type_name, $address){
        $query = BloodIssuance::query();

        $query->when(isset($address['city']), function ($q) use ($address) {
            $q->where('patients.city', $address['city']->citymunDesc);
        });
    
        $query->when(isset($address['barangay']), function ($q) use ($address) {
            $q->where('patients.barangay', $address['barangay']);
        });
    
        $query->when(isset($address['province']), function ($q) use ($address) {
            $q->where('patients.province', $address['province']->provDesc);
        });

        if(isset($request->start_date) && isset($request->end_date)){
            $query->whereBetween('blood_issuances.release_date', [$request->start_date, $request->end_date]);
        }

        return $query->join('patients', 'patients.id', '=', 'blood_issuances.patient_id')
        ->where('blood_issuances.blood_type', $blood_type_name)
        ->groupBy('blood_issuances.blood_type')       
        ->count();
    }
}