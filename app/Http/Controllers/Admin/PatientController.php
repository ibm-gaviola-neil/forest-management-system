<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Domains\BloodTypeDomain;
use App\Http\Domains\TraitAdmin;
use App\Http\Requests\PatientRequest;
use App\Http\Services\DonorService;
use App\Http\Services\PatientService;
use App\Models\City;
use App\Models\Patient;
use App\Models\Province;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PatientController extends Controller
{
    use TraitAdmin;
    protected $donor_service;
    protected $patient_service;
    public function __construct(DonorService $donor_service, PatientService $patient_service){
        $this->donor_service = $donor_service;
        $this->patient_service = $patient_service;
    }
    public function index(Request $request){
        $data['patients'] = $this->patient_service->getPatients($request);
        $data['request'] = $request;
        $data['provinces']= Province::orderBy('provDesc', 'ASC')->get();
        $data['address'] = $this->donor_service->getDonorRequestAddress($request);
        return view('Pages.Admin.patients.index', $data);
    }

    public function create(){
        $data['provinces'] = Province::orderBy('provDesc', 'ASC')->get();
        $data['suffix'] = BloodTypeDomain::SUFFIX;
        return view('Pages.Admin.patients.create', $data);
    }

    public function edit(Patient $patient, Request $request){
        $data['provinces'] = Province::orderBy('provDesc', 'ASC')->get();
        $data['patient'] = $patient;
        $data['suffix'] = BloodTypeDomain::SUFFIX;
        return view('Pages.Admin.patients.edit', $data);
    }

    public function store(PatientRequest $request){
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

    public function show(Patient $patient){
        return response()->json($patient);
    }

    public function confirm(Request $request){
        $payload = $request->except('_token', 'patient');
        $payload['user_id'] = auth()->user()->id;
        $patient_id = $request->get('patient');

        $province_name = Province::where('provCode', $request->province)->first();
        $city_name = City::where('citymunCode', $request->city)->first();
        $payload['province'] = $province_name->provDesc;
        $payload['city'] = $city_name->citymunDesc;

        if(!isset($patient_id)){
            $save = DB::transaction(function() use ($payload){
                $isSave = Patient::create($payload);
                $this->storeAuditTrails('create', 'patient', 'patients/'.$isSave->id.'/edit', 'Newly registered patient');
                return $isSave;
            });
        }else{
            $save = DB::transaction(function() use ($payload, $patient_id){
                $isSave = Patient::where('id', $patient_id)->update($payload);
                $this->storeAuditTrails('update', 'patient', 'patients/'.$patient_id.'/edit', 'Profile updated');
                return $isSave;
            });
        }

        if(!$save){
            return response()->json([
                'status' => 500,
                'data' => $payload,
                'message' => 'Unable to save Patient!'
            ]); 
        }

        return response()->json([
            'status' => 200,
            'data' => $payload
        ]);
    }

    public function delete(Patient $patient){
        $patient_name = $patient->last_name . ' ' .$patient->first_name;
        $delete = $patient->delete();

        if($delete){
            $this->storeAuditTrails('delete', 'patient', null, $patient_name.' was deleted');
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
