<?php

namespace App\Http\Repositories;

use App\Http\Interfaces\DonorRepositoryInterface;
use App\Models\Patient;
use Illuminate\Support\Collection;
use App\Models\Donor;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class PatientRepository implements DonorRepositoryInterface{
    public function index(object $request, $address = array(), $is_approved = 0): Collection {
        $query = Patient::query();

        $query->when(isset($request->last_name), function ($q) use ($request) {
            $q->where('patients.last_name', $request->last_name);
        });

        $query->when(isset($request->first_name), function ($q) use ($request) {
            $q->where('patients.first_name', $request->first_name);
        });

        $query->when(isset($address['city']), function ($q) use ($address) {
            $q->where('patients.city', $address['city']);
        });

        $query->when(isset($address['barangay']), function ($q) use ($address) {
            $q->where('patients.barangay', $address['barangay']);
        });

        $query->when(isset($address['province']), function ($q) use ($address) {
            $q->where('patients.province', $address['province']);
        });

        return $query->join('users', 'patients.user_id', '=', 'users.id')
        ->select('patients.*', 'users.last_name as a_last_name', 'users.first_name as a_first_name')
        ->orderBy('last_name', 'ASC')
        ->get();
    }
}