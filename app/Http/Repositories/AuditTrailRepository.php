<?php

namespace App\Http\Repositories;

use App\Models\AuditTrail;

class   AuditTrailRepository{
    public function getAuditrailData($request){
        $query = AuditTrail::query();

        $query->select('audit_trails.*', 'users.last_name', 'users.first_name', 'blood_issuances.blood_bag_id')
                ->join('users', 'audit_trails.user_id', '=', 'users.id')
                ->leftJoin('blood_issuances', 'blood_issuances.id', '=', 'audit_trails.blood_issuance_id');

        $query->when(filled($request->start_date) && filled($request->end_date), function ($q) use ($request) {
            $q->whereBetween('audit_trails.created_at', [$request->start_date, $request->end_date]);
        });
        
        $query->when(filled($request->start_date) && !filled(   $request->end_date), function ($q) use ($request) {
            $q->whereDate('audit_trails.created_at', '>=', $request->start_date);
        });
        
        $query->when(filled($request->end_date) && !filled($request->start_date), function ($q) use ($request) {
            $q->whereDate('audit_trails.created_at', '<=', $request->end_date);
        });

        return $query->where('type', $request->tab ?? 'donor')
                ->orderBy('audit_trails.created_at', 'DESC')->get();
    }
}