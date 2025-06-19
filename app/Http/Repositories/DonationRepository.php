<?php

namespace App\Http\Repositories;

use App\Http\Interfaces\DonationRepositoryInterface;
use App\Models\DonationHistory;
use App\Models\Donor;
use Date;
use Illuminate\Support\Collection;

class DonationRepository implements DonationRepositoryInterface{
    public function index(int $donor): Collection {
        $query = DonationHistory::query();

        $query->select('users.last_name as userlname', 'users.first_name as userfname', 'donors.last_name', 'donors.first_name', 'donation_histories.*')
        ->join('users', 'users.id', '=', 'donation_histories.staff_id')
        ->join('donors', 'donors.id', '=', 'donation_histories.donor_id');

        return $query->where('donation_histories.donor_id', $donor)
            ->orderBy('donation_histories.created_at', 'DESC')->get();
    }

    public function get(int $donation_id){
        $query = DonationHistory::query();

        $query->select('users.last_name as userlname', 'users.first_name as userfname', 'donors.last_name', 'donors.first_name', 'donation_histories.*')
        ->join('users', 'users.id', '=', 'donation_histories.staff_id')
        ->join('donors', 'donors.id', '=', 'donation_histories.donor_id');

        return $query->where('donation_histories.id', $donation_id)
            ->orderBy('donation_histories.created_at', 'DESC')->first();
    }

    public function getDonorByBloodType($request)
    {
        $today = now()->toDateString();
        $query = DonationHistory::query();

        $query->when(filled($request->blood_type), function ($q) use ($request) {
            $q->where('donors.blood_type', $request->blood_type);
        });

        $query->when(filled($request->blood_bag_id), function ($q) use ($request) {
            $q->where('donation_histories.blood_bag_id', $request->blood_bag_id);
        });

        return $query->select(
                'donors.last_name',
                'donors.first_name',
                'donors.blood_type',
                'donors.id as donor_id',
                'donation_histories.blood_bag_id',
                'donation_histories.expiration_date',
                'donation_histories.date_process'
            )
            ->join('donors', 'donors.id', '=', 'donation_histories.donor_id')
            ->where('donation_histories.count', 1)
            ->whereDate('donation_histories.expiration_date', '>=', $today)
            ->orderBy('donation_histories.expiration_date', 'asc')
            ->get();
    }

    public function getDonorByModal($request)
    {
        $today = now()->toDateString();
        $query = DonationHistory::query();

        $query->when(filled($request->blood_type), function ($q) use ($request) {
            $q->where('donors.blood_type', $request->blood_type);
        });

        $query->when(filled($request->blood_bag_id), function ($q) use ($request) {
            $q->where('donation_histories.blood_bag_id', $request->blood_bag_id);
        });

        return $query->select(
                'donors.last_name',
                'donors.first_name',
                'donors.blood_type',
                'donors.id as donor_id',
                'donation_histories.blood_bag_id',
                'donation_histories.expiration_date',
                'donation_histories.date_process'
            )
            ->join('donors', 'donors.id', '=', 'donation_histories.donor_id')
            ->whereDate('donation_histories.expiration_date', '>=', $today)
            ->orderBy('donation_histories.expiration_date', 'asc')
            ->get();
    }

}