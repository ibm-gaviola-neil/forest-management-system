<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Domains\BloodTypeDomain;
use App\Http\Domains\PermitIdGenerator;
use App\Http\Services\CuttingPermitService;
use App\Models\CuttingPermit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminCuttingPermitController extends Controller
{
    private $cuttingPermitService;
    private $permitIdGenerator;

    public function __construct(CuttingPermitService $cuttingPermitService, PermitIdGenerator $permitIdGenerator)
    {
        $this->cuttingPermitService = $cuttingPermitService;
        $this->permitIdGenerator = $permitIdGenerator;
    }

    public function index() 
    {
        $data['pageTitle'] = 'Cutting Trees Permits';
        $data['pageSubTitle'] = 'Manage Cutting Trees Permits';
        return view('Pages.Admin.cutting-permit.index', $data);
    }

    public function show(CuttingPermit $cuttingPermit) 
    {
        $data['cutting_permit'] = $cuttingPermit;
        $data['requirements'] = $cuttingPermit->requirements;
        $data['rejectionReasons'] = BloodTypeDomain::REASONS_FOR_REJECTION;
        return view('Pages.Admin.cutting-permit.view', $data);
    }

    public function reject(CuttingPermit $cuttingPermit, Request $request)
    {
        try {
            $approvedBy = auth()->id();
            $cuttingPermit->reject($approvedBy, $request->reason);
            return response()->json([
                'status' => 200,
                'message' => 'Cutting permit application data rejected successfully.',
                'data' => $cuttingPermit,
                'rejection_reason' => $request->reason
            ], 201);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed. Please try again.',
                'log' => $th->getMessage()
            ], 500);
        }
    }

    public function approve(CuttingPermit $cuttingPermit)
    {
        try {
            $permitId = $this->permitIdGenerator->generate('CP');
            $approvedBy = auth()->id();
            DB::transaction(function() use ($cuttingPermit, $approvedBy, $permitId) {
                $cuttingPermit->approve($approvedBy, $permitId);
                // Fix: Access the tree relationship as a property, not a method
                $tree = $cuttingPermit->tree;
                
                // Check if the tree exists before attempting to mark it as cut
                if ($tree) {
                    $tree->markAsCut();
                }
            });
            return response()->json([
                'status' => 200,
                'message' => 'Cutting permit application data approved successfully.',
                'data' => $cuttingPermit
            ], 201);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed. Please try again.',
                'log' => $th->getMessage()
            ], 500);
        }
    }
}
