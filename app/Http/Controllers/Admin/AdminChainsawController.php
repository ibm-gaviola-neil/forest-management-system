<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\NotificationController;
use App\Http\Domains\BloodTypeDomain;
use App\Http\Domains\NotificationDomain;
use App\Http\Services\ChainsawService;
use App\Models\ChainsawRequest;
use Illuminate\Http\Request;
use App\Http\Services\NotificationService;

class AdminChainsawController extends Controller
{
    private $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    public function index() 
    {
        $data['pageTitle'] = 'Registered Chainsaw';
        $data['pageSubTitle'] = 'Manage registered chainsaw in the system';
        return view('Pages.Admin.chainsaw.index', $data);
    }

    public function list(ChainsawService $chainsawService, Request $request) 
    {
        $role = auth()->user()->role;
        $data = $chainsawService->getChainsawData($role, $request);

        return response()->json($data);
    }

    public function show(ChainsawRequest $chainsaw)
    {
        $data['pageTitle'] = 'Chainsaw Information';
        $data['chainsaw'] = $chainsaw;
        $data['rejectionReasons'] = BloodTypeDomain::REASONS_FOR_CHAINSAW_REJECT;
        $data['requirements'] = $chainsaw->requirements;
        return view('Pages.Admin.chainsaw.view', $data);
    }

    public function reject(ChainsawRequest $chainsaw, Request $request)
    {
        try {
            $chainsaw->reject($request->reason);
            $this->notificationService->saveNotification([
                'type' => NotificationDomain::CHAINSAW_APPLICANT,
                'message' => 'Chainsaw Registration Rejected.',
                'related_id' => $chainsaw->id,
                'related_table' => NotificationDomain::RELATED_TABLES[NotificationDomain::CHAINSAW_APPLICANT],
                'is_read' => false,
                'created_by' => auth()->user()->id,
                'reciever_id' => $chainsaw->user_id,
            ]);
            return response()->json([
                'status' => 200,
                'message' => 'Chainsaw registration data rejected successfully.',
                'data' => $chainsaw,
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

    public function approve(ChainsawRequest $chainsaw)
    {
        try {
            $chainsaw->approve();
            $this->notificationService->saveNotification([
                'type' => NotificationDomain::CHAINSAW_APPLICANT,
                'message' => 'Chainsaw Registration Approved.',
                'related_id' => $chainsaw->id,
                'related_table' => NotificationDomain::RELATED_TABLES[NotificationDomain::CHAINSAW_APPLICANT],
                'is_read' => false,
                'created_by' => auth()->user()->id,
                'reciever_id' => $chainsaw->user_id,
            ]);
            return response()->json([
                'status' => 200,
                'message' => 'Chainsaw registration application data approved successfully.',
                'data' => $chainsaw
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
