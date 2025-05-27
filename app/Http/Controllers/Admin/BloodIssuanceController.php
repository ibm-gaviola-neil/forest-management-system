<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Province;
use App\Models\User;
use Illuminate\Http\Request;

class BloodIssuanceController extends Controller
{
    public function index(){
        $provinces = Province::orderBy('provDesc', 'ASC')->get();
        return view('Pages.Admin.blood-issuance.index', [
            'provinces'=> $provinces,
            'staffs' =>   User::where('role', 'staff')->orderBy('last_name', 'ASC')->get()
        ]);
    }
}
