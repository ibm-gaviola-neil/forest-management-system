<?php

namespace App\Http\Controllers;

use App\Models\EmailAddress;
use App\Models\SystemSettings;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PHPUnit\Event\Telemetry\System;
use Symfony\Component\Mime\Email;

class SettingsController extends Controller
{
    public function index()
    {
        $data = [];
        $user_id = auth()->user()->id;
        $data['user_data'] = User::where('id', $user_id)->first();
        $data['settings'] = SystemSettings::first();
        $data['emails'] = DB::table('email_addresses')
            ->join('users', 'email_addresses.user_id', '=', 'users.id')
            ->orderBy('email_addresses.created_at', 'desc')
            ->select('email_addresses.*', 'users.last_name', 'users.first_name')
            ->get();

        return view('Pages.Admin.settings.index', $data);
    }

    public function update(Request $request){
        $targetSettings = SystemSettings::first();
        $prevTargetSettings = null;
        if ($targetSettings) {
            $prevTargetSettings = clone $targetSettings;
        }
        $payload = array();

        $validator = Validator::make($request->all(), [
            "is_enable"          => "required",
            "display_start_date" => "required_if:is_enable,3",
            "display_end_date"   => "required_if:is_enable,3",
            "navbar_logo" => isset($targetSettings)
                    ? "nullable|image|mimetypes:image/jpeg,image/png"
                    : "nullable|image|mimetypes:image/jpeg,image/png",
                "logo" => isset($targetSettings)
                    ? "nullable|image|mimetypes:image/jpeg,image/png"
                    : "nullable|image|mimetypes:image/jpeg,image/png",
            "email_address" => "required|email|unique:system_settings,email_address,". $targetSettings?->id,
            "email_password" => "required",
        ],
        [
            'is_enable.required' => 'The enable field is required.',

            'display_start_date.required_if' => 'Start date is required when enabled by date.',
            'display_end_date.required_if'   => 'End date is required when enabled by date.',

            'navbar_logo.required' => 'Please upload a navigation bar logo.',
            'navbar_logo.mimes'    => 'The navigation bar logo must be a file of type: png, jpg, jpeg.',

            'logo.required' => 'Please upload a logo.',
            'logo.mimes'    => 'The logo must be a file of type: png, jpg, jpeg.',
        ]
        );
        
        $validator->after(function ($validator) use ($request) {
            if ($request->input('is_enable') == 3) {
                $start = $request->input('display_start_date');
                $end = $request->input('display_end_date');
        
                if ($start && $end) {
                    if (strtotime($start) > strtotime($end)) {
                        $validator->errors()->add('display_start_date', 'The start date must not be greater than the end date.');
                        $validator->errors()->add('display_end_date', 'The end date must not be less than the start date.');
                    }                  
                }
            }
        });
        
        $payload = $validator->validate();

        if($request->hasFile('logo')){
            $logoImageFile = $request->file('logo')->store('images', 'public');
            $payload['logo'] = $logoImageFile;
        }

        if($request->hasFile('navbar_logo')){
            $navBarLogoFile = $request->file('navbar_logo')->store('images', 'public');
            $payload['navbar_logo'] = $navBarLogoFile;
        }

        if($payload['is_enable'] != 3){
            $payload['display_start_date'] = null;
            $payload['display_end_date'] = null;
        }

        if(!$targetSettings){
            SystemSettings::create($payload);
        }else{
            $targetSettings?->update($payload);
        }

        $this->storeEmail($payload, $prevTargetSettings);

        return redirect()->back();
    }

    private function storeEmail($payload, $targetSettings): bool
    {
        if (
            isset($payload['email_address'], $payload['email_password']) &&
            $targetSettings &&
            (
                $payload['email_address'] !== $targetSettings->email_address ||
                $payload['email_password'] !== $targetSettings->email_password
            )
        ) {
            $toStore = [
                'email_address'      => $payload['email_address'],
                'email_password'     => $payload['email_password'],
                'system_settings_id' => $targetSettings->id,
                'user_id'            => auth()->user()->id,
            ];

            EmailAddress::create($toStore);
            return true;
        } else {
            $newSettings = SystemSettings::first();
            $toStore = [
                'email_address'      => $payload['email_address'],
                'email_password'     => $payload['email_password'],
                'system_settings_id' => $newSettings->id,
                'user_id'            => auth()->user()->id,
            ];

            EmailAddress::create($toStore);
            return true;
        }
        // No change, no history entry
        return false;
    }
}
