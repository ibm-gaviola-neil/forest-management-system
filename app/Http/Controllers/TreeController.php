<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChainsawRequest;
use App\Http\Requests\TreeRequest;
use App\Http\Services\TreesService;
use App\Models\Tree;
use Illuminate\Http\Request;

class TreeController extends Controller
{

    public function index() 
    {
        return view('Pages.Applicant.tree-registration.index');
    }

    public function treesList(TreesService $treesService, Request $request) 
    {
        $role = auth()->user()->role;
        $data = $treesService->getTreeData($role, $request);

        return response()->json($data);
    }

    public function store(TreeRequest $request)
    {
        $payload = $request->validated();
        $payload['user_id'] = auth()->user()->id;
        
        $save = Tree::create($payload);
        
        if ($save) {
            return response()->json([
                'status' => 'success',
                'message' => 'Tree data saved successfully.',
                'data' => $save
            ], 201);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to save tree data. Please try again.'
            ], 500);
        }
    }

    public function storeChainsaw(ChainsawRequest $request)
    {
        $payload = $request->validated();
        $payload['user_id'] = auth()->user()->id;
        // Status is default in migration, but you can specify if you want
        // $payload['status'] = 'pending';

        // Save using ChainsawRequest MODEL (not request class)
        $save = \App\Models\ChainsawRequest::create($payload);

        if ($save) {
            return response()->json([
                'status' => 'success',
                'message' => 'Chainsaw request saved successfully.',
                'data' => $save
            ], 201);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to save chainsaw request. Please try again.'
            ], 500);
        }
    }

    public function show(Tree $tree)
    {
        $data['tree'] = $tree;
        return view('Pages.Applicant.tree-registration.view', $data);
    }

    public function edit(Tree $tree)
    {
        if($tree->status !== 0) {
            abort(404);
        }

        $data['tree'] = $tree;
        $data['editFlg'] = true;
        return view('Pages.Applicant.tree-registration.edit', $data);
    }

    public function update(Tree $tree, TreeRequest $request)
    {
        $payload = $request->validated();
        
        $save = $tree->update($payload);
        
        if ($save) {
            return response()->json([
                'status' => 'success',
                'message' => 'Tree data saved successfully.',
                'data' => $save
            ], 201);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to save tree data. Please try again.'
            ], 500);
        }
    }

    public function cancel(Tree $tree)
    {
        if ($tree->status === 3) {
            return response()->json([
                'status' => 'error',
                'message' => 'Tree registration already cancelled, please reload the page!',
            ], 200);
        }

        try {
            $tree->status = 3;
            $tree->save();

            return response()->json([
                'status' => 200,
                'message' => 'Tree data cancelled successfully.',
                'data' => $tree
            ], 201);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to cancel tree registration. Please try again.',
                'log' => $th->getMessage()
            ], 500);
        }
    }
}
