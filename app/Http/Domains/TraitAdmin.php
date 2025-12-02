<?php

namespace App\Http\Domains;

use App\Events\AuditStored;
use App\Mail\SystemNotificationEmail;
use App\Models\Barangay;
use App\Models\City;
use App\Models\Province;
use Carbon\Carbon;
use DateTime;
use Illuminate\Support\Facades\Mail;

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

    public function storeAuditTrails(string $action, string $type, string $url = null, string $message = null, int $blood_issuance_id = null){
        $data = [
            'action' => $action,
            'type' => $type,
            'url' => $url ?? null,
            'message' => $message ?? null,
            'blood_issuance_id' => $blood_issuance_id ?? null
        ];
        event(new AuditStored($data));
    }

    public function sendEmailNotification(string $to_email, string $subject, string $body)
    {
        $systemSettings = \App\Models\SystemSettings::first();

        if (!$systemSettings || !$systemSettings->email_address || !$systemSettings->email_password) {
            // Handle error
            return false;
        }

        // Dynamically configure mail sender
        config([
            'mail.mailers.smtp.transport' => 'smtp', // MAIL_MAILER
            'mail.mailers.smtp.host' => 'smtp.gmail.com', // MAIL_HOST
            'mail.mailers.smtp.port' => 587, // MAIL_PORT
            'mail.mailers.smtp.username' => $systemSettings->email_address, // MAIL_USERNAME
            'mail.mailers.smtp.password' => $systemSettings->email_password, // MAIL_PASSWORD
            'mail.mailers.smtp.encryption' => 'tls', // MAIL_ENCRYPTION
            'mail.from.address' => $systemSettings->email_address, // MAIL_FROM_ADDRESS
            'mail.from.name' => 'Biliran Blood Registry System', // MAIL_FROM_NAME
        ]);

        $body = nl2br($body);

        // Send the email
        Mail::to($to_email)->send(new SystemNotificationEmail($subject, $body));

        return true;
    }
}