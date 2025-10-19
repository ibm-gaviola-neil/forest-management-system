<?php

namespace App\Http\Repositories;

use App\Http\Interfaces\DonorRepositoryInterface;
use Illuminate\Support\Collection;
use App\Models\Donor;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class DonorRepository implements DonorRepositoryInterface{
    public function index(object $request, $address = array(), $is_approved = 0): Collection {
        $query = Donor::query();

        $query->when(isset($request->last_name), function ($q) use ($request) {
            $q->where('donors.last_name', $request->last_name);
        });

        $query->when(isset($request->first_name), function ($q) use ($request) {
            $q->where('donors.first_name', $request->first_name);
        });

        $query->when(isset($address['city']), function ($q) use ($address) {
            $q->where('donors.city', $address['city']);
        });

        $query->when(isset($address['barangay']), function ($q) use ($address) {
            $q->where('donors.barangay', $address['barangay']);
        });

        $query->when(isset($address['province']), function ($q) use ($address) {
            $q->where('donors.province', $address['province']);
        });

        $query->when(isset($request->blood_type), function ($q) use ($request) {
            $q->where('donors.blood_type', $request->blood_type);
        });

        return $query->leftJoin('users', 'donors.user_id', '=', 'users.id')
        ->select('donors.*', 'users.last_name as a_last_name', 'users.first_name as a_first_name')
        ->where('donors.is_approved', $is_approved)
        ->orderBy('last_name', 'ASC')
        ->get();
    }
}