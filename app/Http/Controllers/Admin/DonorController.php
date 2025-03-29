<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\DonateRequest;
use App\Http\Requests\DonorRequest;
use App\Http\Services\DonationService;
use App\Http\Services\DonorService;
use App\Models\Barangay;
use App\Models\City;
use App\Models\DonationHistory;
use App\Models\Donor;
use App\Models\Province;
use App\Models\User;
use Illuminate\Http\Request;

class DonorController extends Controller
{
    protected $donor_service;
    protected $donation_service;

    public function __construct(DonorService $donor_service, DonationService $donation_service){
        $this->donor_service = $donor_service;
        $this->donation_service = $donation_service;
    }

    public function index(Request $request) {
        $donors = $this->donor_service->getDonors($request);
        $provinces = Province::orderBy('provDesc', 'ASC')->get();
        $address = $this->donor_service->getDonorRequestAddress($request);
        return view('pages.admin.donors', compact('donors', 'provinces', 'request', 'address'));
    }

    public function addDonor(){
        $provinces = Province::orderBy('provDesc', 'ASC')->get();
        return view('pages.forms.add-donor', compact('provinces'));
    }

    /**
     * Summary of store
     * @return void
     */
    public function store(\App\Http\Requests\DonorRequest $request){
        $payload = $request->validated();

        $province_name = Province::where('provCode', $request->province)->first();
        $city_name = City::where('citymunCode', $request->city)->first();
        $payload['province'] = $province_name->provDesc;
        $payload['city'] = $city_name->citymunDesc;
        return response()->json([
            'status' => 200,
            'data' => $payload
        ]);
    }

    public function editConfirm(Donor $donor, Request $request){
        $payload = $request->validate([
            "first_name" => 'required',
            "last_name" => 'required',
            "middle_name" => 'nullable',
            "suffix" => 'nullable',
            "email" => 'required|email|unique:donors,email,'.$donor->id,
            "contact_number" => ['required','regex:/^(09|\+639)\d{9}$/', 'min:11'],
            "birth_date" => 'required',
            "gender" => 'required',
            "civil_status" => 'required',
            "province" => 'required',
            "city" => 'required',
            "barangay" => 'required',
        ]);

        $province_name = Province::where('provCode', $request->province)->first();
        $city_name = City::where('citymunCode', $request->city)->first();
        $payload['province'] = $province_name->provDesc;
        $payload['city'] = $city_name->citymunDesc;
        return response()->json([
            'status' => 200,
            'data' => $payload
        ]);
    }

    public function update(Request $request, Donor $donor){
        $payload = $request->except('_token');

        $province_name = Province::where('provCode', $request->province)->first();
        $city_name = City::where('citymunCode', $request->city)->first();
        $payload['province'] = $province_name->provDesc;
        $payload['city'] = $city_name->citymunDesc;

        $save = $donor->update($payload);

        if(!$save){
            return response()->json([
                'status' => 500,
                'data' => $payload,
                'message' => 'Unable to save donor!'
            ]); 
        }

        return response()->json([
            'status' => 200,
            'data' => $payload
        ]);
    }

    public function confirm(Request $request){
        $payload = $request->except('_token');
        $payload['user_id'] = auth()->user()->id;

        $province_name = Province::where('provCode', $request->province)->first();
        $city_name = City::where('citymunCode', $request->city)->first();
        $payload['province'] = $province_name->provDesc;
        $payload['city'] = $city_name->citymunDesc;

        $save = Donor::create($payload);

        if(!$save){
            return response()->json([
                'status' => 500,
                'data' => $payload,
                'message' => 'Unable to save donor!'
            ]); 
        }

        return response()->json([
            'status' => 200,
            'data' => $payload
        ]);
    }

    public function donor(Donor $donor){
        $histories = array();
        $provinces = Province::orderBy('provDesc', 'ASC')->get();
        $staffs = User::where('role', 'staff')->orderBy('last_name', 'ASC')->get();
        $histories = $this->donation_service->getDonationHistories((int)$donor->id);
        $donor_id = $donor->id;
        return view('pages.admin.donor', compact('histories', 'provinces', 'donor_id', 'staffs', 'donor'));
    }

    public function edit(Donor $donor){
        $provinces = Province::orderBy('provDesc', 'ASC')->get();
        $donor_id = $donor->id;
        $province = Province::where('provDesc', $donor->province)->first();

        $city_default = City::where('citymunDesc', $donor->city)->first();
        $cities = City::where('provCode', $province->provCode)->orderBy('citymunDesc', 'ASC')->get();
        
        $barangays = Barangay::where('citymunCode', $city_default->citymunCode)->orderBy('brgyDesc', 'ASC')->get();
        $barangay_default = Barangay::where('brgyDesc', $donor->barangay)->first();
        return view('pages.admin.donor-edit', compact('provinces', 'donor_id', 'donor', 'cities', 'barangays', 'city_default', 'barangay_default', 'province'));
    }

    public function confirmContent(){
        return view('components.modals.confirm-donate');
    }

    public function confirmDondate(Donor $donor, DonateRequest $request){
        $payload = $request->validated();
        $payload['user_id'] = auth()->user()->id; 
        $payload['donor_id'] = $donor->id; 

        $province_name = Province::where('provCode', $request->province)->first();
        $city_name = City::where('citymunCode', $request->city)->first();
        $payload['province'] = $province_name->provDesc;
        $payload['city'] = $city_name->citymunDesc;

        $save = DonationHistory::create($payload);
        if($save){
            return response()->json([
                'status' => 200,
                'message' => 'Success'
            ]);
        }else{
            return response()->json([
                'status' => 500,
                'message' => 'Server Error!'
            ]);
        }
    }

    public function delete(Donor $donor){
        $delete = $donor->delete();

        if($delete){
            return response()->json([
                'status' => 200,
                'message' => 'Success'
            ]);
        }else{
            return response()->json([
                'status' => 500,
                'message' => 'Server Error!'
            ]);
        }
    }
}
