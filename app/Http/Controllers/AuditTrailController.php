<?php

namespace App\Http\Controllers;

use App\Http\Services\AuditTrailService;
use Illuminate\Http\Request;

class AuditTrailController extends Controller
{
    protected $auditTrailService;

    public function __construct(AuditTrailService $auditTrailService){
        $this->auditTrailService = $auditTrailService;
    }

    public function index(Request $request){
        $data = $this->auditTrailService->setAuditTrail($request);
        return view('Pages.Admin.audit-trail.index', $data);
    }
}
