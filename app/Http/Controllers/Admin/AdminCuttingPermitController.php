<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CuttingPermit;
use Illuminate\Http\Request;

class AdminCuttingPermitController extends Controller
{
    public function show(CuttingPermit $cuttingPermit) 
    {
        $data['cutting_permit'] = $cuttingPermit;
        $data['requirements'] = $cuttingPermit->requirements;
        return view('Pages.Admin.cutting-permit.view', $data);
    }
}
