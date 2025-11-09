<?php

namespace App\Http\Services;

use App\Http\Repositories\BloodIssuanceRepository;
use App\Http\Repositories\DonationRepository;
use App\Models\Department;
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

        $data['issue_to'] = $request['issue_to'];
        $data['patient'] = Patient::select('last_name', 'first_name')->where('id', $request['patient_id'])->first();
        $data['department'] = isset($request['department_id']) ? Department::select('department_name')->where('id', $request['department_id'])->first() : null;
        $data['requestor'] = User::select('last_name', 'first_name')->where('id', $request['requestor_id'])->first();
        $data['blood_type'] = $request['blood_type'];
        $data['serial_number'] = $request['blood_bag_id'];
        $data['expiration_date'] = $request['expiration_date'];
        $data['date_of_crossmatch'] = $request['date_of_crossmatch'];
        $data['time_of_crossmatch'] = $request['time_of_crossmatch'];
        $data['release_date'] = $request['release_date'];
        $data['release_by'] = User::select('last_name', 'first_name')->where('id', $request['release_by'])->first();
        $data['taken_by'] = User::select('last_name', 'first_name')->where('id', $request['taken_by'])->first();

        if ($data['issue_to'] == 'office') {
            $data['patient'] = null;
            $data['date_of_crossmatch'] = null;
            $data['time_of_crossmatch'] = null;
        } 

        if ($data['issue_to'] == 'patient') {
            $data['department'] = null;
        }

        return ['data' => $data, 'payload' => $request];
    }

    public function bloodIssuanceHistory(){
        return $this->bloodIssuanceRepository->getBloodIssuanceData();
    }

    public function bloodIssuanceOfficeHistory(){
        return $this->bloodIssuanceRepository->getBloodIssuanceOfficeData();
    }
}