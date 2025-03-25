<?php

namespace App\Http\Controllers;

use App\Models\Barangay;
use App\Models\City;
use App\Models\Province;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    public function province(){
        return response(Province::orderBy('provDesc', 'ASC')->get());
    }

    public function city(Request $request){
        return response(City::orderBy('citymunDesc', 'ASC')->where('provCode', $request->province_code)->get());
    }

    public function barangay(Request $request){
        return response(Barangay::orderBy('brgyDesc', 'ASC')->where('citymunCode', $request->city_code)->get());
    }
}
