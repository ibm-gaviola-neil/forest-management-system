<?php

namespace App\Http\Repositories;

use App\Models\ChainsawRequest;
use App\Models\CuttingPermit;
use App\Models\Donor;
use App\Models\Event;
use App\Models\Incident;
use App\Models\Tree;
use App\Models\User;
use DB;
use Illuminate\Support\Facades\DB as FacadesDB;

class DashboardRepository {
    public function counts(){
        return [
            'trees' => Tree::where('status', 1)->count(),
            'incidents' => Incident::count(),
            'permits' => CuttingPermit::where('status', 1)->count(),
            'chainsaw' => ChainsawRequest::where('status', 1)->count()
        ];
    }

    public function numberOfDonors(){
        $data = Donor::join('donation_histories', 'donors.id', '=', 'donation_histories.donor_id')
            ->select(FacadesDB::raw('COUNT(DISTINCT donors.id) as total_donors'), 'donors.barangay')
            ->groupBy('donors.barangay')
            ->get();
        
        return $data;
    }
}