<?php

namespace App\Http\Services;

use App\Models\User;

class ApplicantServices {
    public function getApplicant($request, $role = ['applicant'])
    {
        $data = [];

        $query = User::query();

        $query->when(filled($request->search), function ($q) use ($request) {
            $keyword = $request->search;
            $q->where(function($sub) use ($keyword) {
                $sub->where('last_name', 'LIKE', "%{$keyword}%")
                    ->orWhere('first_name', 'LIKE', "%{$keyword}%")
                    ->orWhere('address', 'LIKE', "%{$keyword}%");
            });
        });

        $data = $query->whereIn('role', $role)->orderBy('created_at', 'DESC')
            ->paginate(20);

        return $data;
    }
}