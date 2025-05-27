<?php

namespace App\Http\Services;

use App\Http\Domains\TraitAdmin;
use App\Http\Interfaces\DonorRepositoryInterface;
use App\Http\Repositories\DonorRepository;
use App\Models\Barangay;
use App\Models\City;
use App\Models\Province;
use Illuminate\Support\Collection;

class DonorService {
    use TraitAdmin;
    protected $donor_repository;

    public function __construct(
        DonorRepositoryInterface $donor_repository = new DonorRepository()
    ){
        $this->donor_repository = $donor_repository;
    }

    public function getDonors(object $request) : Collection{
        $address = $this->getAddress($request);
        return $this->donor_repository->index($request, $address);
    }

    public function getDonorRequestAddress(object $request){
        $address = array();

        if(isset($request->city)){
            $address['city'] =  City::where('citymunCode', $request->city)->first();
            $address['barangays'] = Barangay::where('citymunCode', $request->city)->get();
        }

        if(isset($request->province)){
            $address['province'] = Province::where('provCode', $request->province)->first();
            $address['cities'] = City::where('provCode', $request->province)->get();
        }

        return $address;
    }
}