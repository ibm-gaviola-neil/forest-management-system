<?php

namespace App\Http\Repositories;

use App\Models\BloodIssuance;
use Illuminate\Support\Facades\DB;

class BloodIssuanceRepository {
    public function getBloodIssuanceData(){
        $query = BloodIssuance::query();

        return $query->select(
                'patients.last_name',
                'patients.email',
                'patients.contact_number',
                'patients.first_name',
                DB::raw('concat(users.last_name, " ", users.first_name ) as requestor'),
                'blood_issuances.*'
            )
            ->join('patients', 'patients.id', '=', 'blood_issuances.patient_id')
            ->join('users', 'users.id', '=', 'blood_issuances.requestor_id')
            ->orderBy('blood_issuances.created_at', 'desc')
            ->get();
    }
}