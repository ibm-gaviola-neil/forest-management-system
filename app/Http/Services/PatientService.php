<?php

namespace App\Http\Services;

use App\Http\Domains\TraitAdmin;
use App\Http\Repositories\PatientRepository;
use App\Models\City;
use App\Models\Province;

class PatientService{
    use TraitAdmin;
    protected $patient_repository;

    public function __construct(PatientRepository $patientRepository){
        $this->patient_repository = $patientRepository;
    }

    public function getPatients(object $request){
        $address = $this->getAddress($request);
        return $this->patient_repository->index($request, $address);
    }
}