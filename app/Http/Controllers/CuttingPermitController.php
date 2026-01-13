<?php

namespace App\Http\Controllers;

use App\Http\Services\CuttingPermitService;
use Illuminate\Http\Request;

class CuttingPermitController extends Controller
{
    private $cuttingPermitService;

    public function __construct(CuttingPermitService $cuttingPermitService)
    {
        $this->cuttingPermitService = $cuttingPermitService;
    }

    public function index()
    {
        return view('Pages.Applicant.cutting-permit.index');
    }

    public function create()
    {
        $data['selectableData'] = $this->cuttingPermitService->getSelectableData();
        return view('Pages.Applicant.cutting-permit.create', $data);
    }
}
