<?php

namespace App\Http\Repositories;

use App\Models\Donor;
use App\Models\Event;
use App\Models\User;
use DB;

class DashboardRepository {
    public function counts(){
        return [
            'users' => User::whereNot('role', 'general_admin')->count(),
            'donors' => Donor::count(),
            'events' => Event::count()
        ];
    }

    public function numberOfDonors(){
        $data = Donor::join('donation_histories', 'donors.id', '=', 'donation_histories.donor_id')
            ->select(DB::raw('COUNT(DISTINCT donors.id) as total_donors'), 'donors.barangay')
            ->groupBy('donors.barangay')
            ->get();
        
        return $data;
    }
}