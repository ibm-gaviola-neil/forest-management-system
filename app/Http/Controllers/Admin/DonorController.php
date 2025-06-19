<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\DonateRequest;
use App\Http\Services\DonationService;
use App\Http\Services\DonorService;
use App\Http\Services\InventoryService;
use App\Models\Barangay;
use App\Models\City;
use App\Models\Donor;
use App\Models\Province;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Domains\TraitAdmin;

class DonorController extends Controller
{
    use TraitAdmin;
    protected $donor_service;
    protected $donation_service;
    protected $inventory_service;

    public function __construct(DonorService $donor_service, DonationService $donation_service, InventoryService $inventoryService){
        $this->donor_service = $donor_service;
        $this->donation_service = $donation_service;
        $this->inventory_service = $inventoryService;
    }

    public function index(Request $request) {
        $donors = $this->donor_service->getDonors($request);
        $provinces = Province::orderBy('provDesc', 'ASC')->get();
        $address = $this->donor_service->getDonorRequestAddress($request);
        return view('Pages.Admin.donors', compact('donors', 'provinces', 'request', 'address'));
    }

    public function addDonor(){
        $provinces = Province::orderBy('provDesc', 'ASC')->get();
        return view('Pages.Forms.add-donor', compact('provinces'));
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

        $this->storeAuditTrails('update', 'donor', 'donors/'.$donor->id.'/view', 'Profile updated');
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

        $this->storeAuditTrails('create', 'donor', 'donors/'.$save->id.'/view', 'Newly registered donor');
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
        return view('Pages.Admin.donor', compact('histories', 'provinces', 'donor_id', 'staffs', 'donor'));
    }

    public function donorUser(){
        $donor = Donor::where('id', auth()->user()->donor_id)->first();
        $histories = array();
        $provinces = Province::orderBy('provDesc', 'ASC')->get();
        $staffs = User::where('role', 'staff')->orderBy('last_name', 'ASC')->get();
        $histories = $this->donation_service->getDonationHistories((int)$donor->id);
        $donor_id = $donor->id;
        $events = $this->donor_service->getEvents();
        return view('Pages.Admin.donor', compact('histories', 'provinces', 'donor_id', 'staffs', 'donor', 'events'));
    }

    public function show(Donor $donor){
        return response()->json($donor);
    }

    public function getDonationHistory($donation_id){
        return response()->json($this->donation_service->getDonation($donation_id));
    }

    public function edit(Donor $donor){
        $provinces = Province::orderBy('provDesc', 'ASC')->get();
        $donor_id = $donor->id;
        $province = Province::where('provDesc', $donor->province)->first();

        $city_default = City::where('citymunDesc', $donor->city)->first();
        $cities = City::where('provCode', $province->provCode)->orderBy('citymunDesc', 'ASC')->get();
        
        $barangays = Barangay::where('citymunCode', $city_default->citymunCode)->orderBy('brgyDesc', 'ASC')->get();
        $barangay_default = Barangay::where('brgyDesc', $donor->barangay)->first();
        return view('Pages.Admin.donor-edit', compact('provinces', 'donor_id', 'donor', 'cities', 'barangays', 'city_default', 'barangay_default', 'province'));
    }

    public function donatePage(Donor $donor){
        $provinces = Province::orderBy('provDesc', 'ASC')->get();
        $donor_id = $donor->id;
        $province = Province::where('provDesc', $donor->province)->first();

        $city_default = City::where('citymunDesc', $donor->city)->first();
        $cities = City::where('provCode', $province->provCode)->orderBy('citymunDesc', 'ASC')->get();
        
        $barangays = Barangay::where('citymunCode', $city_default->citymunCode)->orderBy('brgyDesc', 'ASC')->get();
        $barangay_default = Barangay::where('brgyDesc', $donor->barangay)->first();
        $staffs = User::where('role', 'staff')->orderBy('last_name', 'ASC')->get();
        return view('Pages.Admin.donor-donate', compact('provinces', 'donor_id', 'staffs', 'donor', 'cities', 'barangays', 'city_default', 'barangay_default', 'province'));
    }

    public function confirmContent(){
        return view('components.Modals.confirm-donate');
    }

    public function confirmDondate(Donor $donor, DonateRequest $request){
        $payload = $request->validated();
        $payload['user_id'] = auth()->user()->id; 
        $payload['donor_id'] = $donor->id; 
        $save = false;

        $province_name = Province::where('provCode', $request->province)->first();
        $city_name = City::where('citymunCode', $request->city)->first();
        $payload['province'] = $province_name->provDesc;
        $payload['city'] = $city_name->citymunDesc;
        $payload['expiration_date'] = $this->setExpirationDate($payload);
        // dd($payload);
        DB::transaction(function () use ($donor, $payload, &$save){
            // dd($payload);
            $donation = $this->donation_service->storeDonation($payload);
            $save = $this->inventory_service->saveInventoryData($payload, $donation);
            $this->storeAuditTrails('donate', 'donor', 'donors/'.$donor->id.'/view', 'Blood donation');
        });

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
        $donor_name = $donor->last_name . ' ' .$donor->first_name;
        $delete = $donor->delete();

        if($delete){
            $this->storeAuditTrails('delete', 'donor', null, $donor_name.' was deleted');
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
