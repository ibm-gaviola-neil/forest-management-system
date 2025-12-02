<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChainsawRequest;
use App\Http\Requests\TreeRequest;
use App\Models\Tree;
use Illuminate\Http\Request;

class TreeController extends Controller
{
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
}
