<?php

namespace App\Http\Services;

use App\Http\Repositories\BloodIssuanceRepository;
use App\Http\Repositories\DonationRepository;
use App\Models\Patient;
use App\Models\User;

class BloodIssuanceService {
    protected $donationRepository;
    protected $bloodIssuanceRepository;

    public function __construct(DonationRepository $donationRepository, BloodIssuanceRepository $bloodIssuanceRepository){
        $this->donationRepository = $donationRepository;
        $this->bloodIssuanceRepository = $bloodIssuanceRepository;
    }

    public function getBloodBagData($request){
        if(isset($request->modal)){
            return $this->donationRepository->getDonorByModal($request);
        }
        return $this->donationRepository->getDonorByBloodType($request);
    }

    public function setConfirmBloodIssuance($request){
        $data = [];

        $data['patient'] = Patient::select('last_name', 'first_name')->where('id', $request['patient_id'])->first();
        $data['requestor'] = User::select('last_name', 'first_name')->where('id', $request['requestor_id'])->first();
        $data['blood_type'] = $request['blood_type'];
        $data['serial_number'] = $request['blood_bag_id'];
        $data['expiration_date'] = $request['expiration_date'];
        $data['date_of_crossmatch'] = $request['date_of_crossmatch'];
        $data['time_of_crossmatch'] = $request['time_of_crossmatch'];
        $data['release_date'] = $request['release_date'];
        $data['release_by'] = User::select('last_name', 'first_name')->where('id', $request['release_by'])->first();
        $data['taken_by'] = User::select('last_name', 'first_name')->where('id', $request['taken_by'])->first();

        return ['data' => $data, 'payload' => $request];
    }

    public function bloodIssuanceHistory(){
        return $this->bloodIssuanceRepository->getBloodIssuanceData();
    }
}