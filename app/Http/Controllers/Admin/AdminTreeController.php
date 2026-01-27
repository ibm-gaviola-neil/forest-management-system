<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Domains\BloodTypeDomain;
use App\Http\Domains\NotificationDomain;
use App\Http\Services\NotificationService;
use App\Http\Services\TreesService;
use App\Models\Tree;
use Illuminate\Http\Request;

class AdminTreeController extends Controller
{
    private $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    public function index() 
    {
        $data['pageTitle'] = 'Registered Trees';
        $data['pageSubTitle'] = 'Manage registered trees in the system';
        return view('Pages.Admin.trees.index', $data);
    }

    public function treesList(TreesService $treesService, Request $request) 
    {
        $role = auth()->user()->role;
        $data = $treesService->getTreeData($role, $request);

        return response()->json($data);
    }

    public function coordinates(TreesService $treesService, Request $request) 
    {
        $role = auth()->user()->role;
        $data = $treesService->getTreeCoordinates($role, $request);

        return response()->json($data);
    }

    public function show(Tree $tree)
    {
        $data['tree'] = $tree;
        $data['rejectionReasons'] = BloodTypeDomain::REASONS_FOR_REJECTION;
        $data['pageTitle'] = 'Tree Information';
        $data['pageSubTitle'] = 'Manage registered trees in the system';
        return view('Pages.Admin.trees.view', $data);
    }

    public function reject(Tree $tree, Request $request)
    {
        try {
            $tree->reject($request->reason);
            $this->notificationService->saveNotification([
                'type' => NotificationDomain::TREES_APPLICANT,
                'message' => 'Tree registration rejected.',
                'related_id' => $tree->id,
                'related_table' => NotificationDomain::RELATED_TABLES[NotificationDomain::TREES_APPLICANT],
                'is_read' => false,
                'created_by' => auth()->user()->id,
                'reciever_id' => $tree->user_id,
            ]);
            return response()->json([
                'status' => 200,
                'message' => 'Tree registration data rejected successfully.',
                'data' => $tree,
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

    public function approve(Tree $tree)
    {
        try {
            $tree->approve();
            $this->notificationService->saveNotification([
                'type' => NotificationDomain::TREES_APPLICANT,
                'message' => 'Tree registration approved!.',
                'related_id' => $tree->id,
                'related_table' => NotificationDomain::RELATED_TABLES[NotificationDomain::TREES_APPLICANT],
                'is_read' => false,
                'created_by' => auth()->user()->id,
                'reciever_id' => $tree->user_id,
            ]);
            return response()->json([
                'status' => 200,
                'message' => 'Tree registration application data approved successfully.',
                'data' => $tree
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
