<?php

namespace App\Http\Repositories;

use App\Http\Interfaces\DonationRepositoryInterface;
use App\Models\DonationHistory;
use App\Models\Donor;
use Illuminate\Support\Collection;

class DonationRepository implements DonationRepositoryInterface{
    public function index(int $donor): Collection {
        $query = DonationHistory::query();

        $query->select('users.last_name as userlname', 'users.first_name as userfname', 'donors.last_name', 'donors.first_name', 'donation_histories.*')
        ->join('users', 'users.id', '=', 'donation_histories.staff_id')
        ->join('donors', 'donors.id', '=', 'donation_histories.donor_id');

        return $query->where('donor_id', $donor)
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
}