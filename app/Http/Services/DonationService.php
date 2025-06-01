<?php

namespace App\Http\Services;

use App\Http\Interfaces\DonationRepositoryInterface;
use App\Http\Repositories\DonationRepository;
use App\Models\DonationHistory;
use Carbon\Carbon;

class DonationService {
    protected $donation_repository;
    public function __construct(
        DonationRepositoryInterface $donation_repository = new DonationRepository()
    ){
        $this->donation_repository = $donation_repository;
    }

    public function getDonationHistories(int $donor){
        return $this->donation_repository->index($donor);
    }

    public function getDonation(int $donation_id){
        return $this->donation_repository->get($donation_id);
    }

    public function storeDonation(array $payload){
        $data = array();
        for ($i=0; $i < (int)$payload['qnty']; $i++) { 
            $data[] = [
                'blood_bag_id' => $payload["blood_bag_id"][$i],
                'donor_id' => $payload['donor_id'],
                'user_id' => auth()->user()->id,
                'province' => $payload['province'],
                'qnty' => $payload['qnty'],
                'city' => $payload['city'],
                'barangay' => $payload['barangay'],
                'staff_id' => $payload['staff_id'],
                'date_process' => $payload['date_process'],
                'donation_type' => $payload['donation_type'],
                'expiration_date' => $payload['expiration_date'],
                'number_of_days' => $payload['expiration_days'] ?? 0,
                'expiration_setting_type' => $payload['expiration_setting_type'],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'count' => 1
            ];
        }
        DonationHistory::insert($data);

        $saved_data = DonationHistory::orderBy('id','desc')
        ->limit((int)$payload['qnty'])->get();

        return $saved_data;
    }
}