<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Donor;
use App\Models\Province;
use Illuminate\Http\Request;

class DonorController extends Controller
{
    public function index(){
        $donors = Donor::join('users', 'donors.user_id', '=', 'users.id')
        ->select('donors.*', 'users.last_name as a_last_name', 'users.first_name as a_first_name')
        ->orderBy('last_name', 'ASC')
        ->get();

        $provinces = Province::orderBy('provDesc', 'ASC')->get();
        
        return view('pages.admin.donors', compact('donors', 'provinces'));
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
}
