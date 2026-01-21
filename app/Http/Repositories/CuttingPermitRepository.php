<?php

namespace App\Http\Repositories;

use App\Models\CuttingPermit;

class CuttingPermitRepository {
    public function getCuttingPermitData($role = 'applicant', $request, $status = null)
    {
        $data = [];

        $query = CuttingPermit::query();

        $query->when(filled($request->search), function ($q) use ($request) {
            $keyword = $request->search;
            $q->whereHas('tree', function ($q) use ($keyword) {
                $q->where('treeId', 'LIKE',  "%{$keyword}%");
            });
        });

        $query->when(filled($request->status), function ($q) use ($request) {
            $status = $request->status;
            $q->where('status', $status);
        });

        if ($role === 'applicant') {
            $query->where('user_id', auth()->user()->id);
        } 
        
        if ($status) {
            $query->where('status', $status);
        } 

        $data = $query->with('tree')
            ->orderBy('created_at', 'DESC')
            ->paginate(20);

        return $data;
    }
}