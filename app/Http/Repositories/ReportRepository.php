<?php

namespace App\Http\Repositories;

use App\Models\BloodIssuance;
use DB;

class ReportRepository{
    public function getBloodIssuanceReportData($request){
        $query = BloodIssuance::query();

        $query->when(filled($request->start_date) && filled($request->end_date) && !filled($request->month) && !filled($request->year), function ($q) use ($request) {
            $q->whereBetween('release_date', [$request->start_date, $request->end_date]);
        });
        
        $query->when(filled($request->start_date) && !filled(   $request->end_date) && !filled($request->month) && !filled($request->year), function ($q) use ($request) {
            $q->whereDate('release_date', '>=', $request->start_date);
        });
        
        $query->when(filled($request->end_date) && !filled($request->start_date) && !filled($request->month) && !filled($request->year), function ($q) use ($request) {
            $q->whereDate('release_date', '<=', $request->end_date);
        });
        
        $query->when(filled($request->month), function ($q) use ($request) {
            $q->whereMonth('release_date', $request->month);
        });
        
        $query->when(filled($request->year), function ($q) use ($request) {
            $q->whereYear('release_date', $request->year);
        });   
        

        $query->when(filled($request->blood_type), function ($q) use ($request) {
            $q->where('blood_type', $request->blood_type);
        });
        
        return $query->select(
                'blood_issuances.blood_bag_id',
                'patients.first_name',
                'patients.last_name',
                'patients.email',
                'patients.contact_number',
                DB::raw('concat(users.last_name, " ", users.first_name ) as requestor'),
                'blood_issuances.blood_type',
                'blood_issuances.date_of_crossmatch',
                'blood_issuances.time_of_crossmatch',
                'blood_issuances.release_date',
                'blood_issuances.created_at',
            )
            ->join('patients', 'patients.id', '=', 'blood_issuances.patient_id')
            ->join('users', 'users.id', '=', 'blood_issuances.requestor_id')
            ->orderBy('blood_issuances.release_date', 'desc')
            ->get();
    }
}