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
            ->where('issue_to', 'patient')
            ->orderBy('blood_issuances.created_at', 'desc')
            ->get();
    }

    public function getBloodIssuanceOfficeData(){
        $query = BloodIssuance::query();

        return $query->select(
                'departments.department_name',
                'departments.email',
                'departments.department_head',
                DB::raw('concat(users.last_name, " ", users.first_name ) as requestor'),
                'blood_issuances.*'
            )
            ->join('departments', 'departments.id', '=', 'blood_issuances.department_id')
            ->join('users', 'users.id', '=', 'blood_issuances.requestor_id')
            ->where('issue_to', 'office')
            ->orderBy('blood_issuances.created_at', 'desc')
            ->get();
    }
}