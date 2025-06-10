<?php

namespace App\Http\Domains;

use App\Models\Barangay;
use App\Models\City;
use App\Models\Province;
use Carbon\Carbon;
use DateTime;

trait TraitAdmin {
    public function expirationDays(int $number_of_days){
        $date = new DateTime();
        $date->modify("$number_of_days days");

        return $date->format("y-m-d");
    }

    public function setExpirationDate($payload){
        if((int)$payload['expiration_setting_type'] == 1){  
            return $this->formatDate($payload['expiration_date']);
        }else{
            return $this->expirationDays($payload['expiration_days']);
        }
    }

    public function formatDate($date){
        $dateFormatted = Carbon::parse($date);
        return $dateFormatted->format('Y-m-d');
    }

    public function getAddress($request){
        if(isset($request->city)){
            $address['city'] =  $address['city'] =  City::where('citymunCode', $request->city)->first()->citymunDesc;
        }

        if(isset($request->province)){
            $address['province'] = Province::where('provCode', $request->province)->first()->provDesc;
        }

        if(isset($request->barangay)){
            $address['barangay'] = $request->barangay;
        }

        return $address ?? [];
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