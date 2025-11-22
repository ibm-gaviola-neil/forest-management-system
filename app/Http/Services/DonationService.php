<?php

namespace App\Http\Services;

use App\Http\Interfaces\DonationRepositoryInterface;
use App\Http\Repositories\DonationRepository;
use App\Models\DonationHistory;
use App\Models\User;
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

    public function donorNotifMessage(array $payload)
    {
        $staff = User::where('id', $payload['staff_id'])->first();
        $message = "Dear Blood Donor,\n\n";
        $message .= "We sincerely appreciate your generous gift of blood. Your donation plays a vital role in saving lives and supporting patients in need. Below are the details of your recent donation:\n\n";
        $message .= "Number of Blood Bags: " . $payload['qnty'] . "\n\n";
        foreach ($payload['blood_bag_id'] as $idx => $bag) {
            $message .= "Blood Bag " . ($idx + 1) . ":\n";
            $message .= "  - Serial Number: " . $payload['blood_bag_id'][$idx] . "\n";
        }
        $message .= "Date Processed: " . $payload['date_process'] . "\n";
        if ($payload['expiration_setting_type'] === 'date') {
            $message .= "Expiration Date: " . $payload['expiration_date'] . "\n";
        } else {
            $message .= "Expiration (Days): " . $payload['expiration_days'] . " days\n";
        }
        $message .= "Location: " . $payload['barangay'] . ", " . $payload['city'] . ", " . $payload['province'] . "\n";
        $message .= "Processed by: " . ucwords($staff->first_name . " " . $staff->last_name) . "\n";
        $message .= "Donation Type: " . $payload['donation_type'] . "\n\n";
        $message .= "We appreciate your life-saving contribution!\n";
        $message .= "Best regards,\n";
        $message .= "Blood Bank Team";

        return $message;
    }
}