<?php

namespace App\Http\Domains;

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
}