<?php

namespace App\Http\Services;

use App\Models\ChainsawRequest;

class ChainsawService {
    public function getChainsawData($role = 'applicant', $request)
    {
        $data = [];

        $query = ChainsawRequest::query();

        $query->when(filled($request->search), function ($q) use ($request) {
            $keyword = $request->search;
            $q->where(function($sub) use ($keyword) {
                $sub->where('serial_number', 'LIKE', "%{$keyword}%")
                    ->orWhere('model', 'LIKE', "%{$keyword}%")
                    ->orWhere('brand', 'LIKE', "%{$keyword}%");
            });
        });

        $query->when(filled($request->status), function ($q) use ($request) {
            $status = $request->status;
            $q->where('status', $status);
        });

        if ($role === 'applicant') {
            $data = $query->where('user_id', auth()->user()->id)->orderBy('serial_number', 'DESC')->paginate(20);
        } 

        return $data;
    }
}