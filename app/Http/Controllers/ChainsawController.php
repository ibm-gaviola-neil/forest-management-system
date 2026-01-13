<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChainsawRequest;
use App\Http\Services\ChainsawService;
use App\Models\ChainsawRequest as ModelsChainsawRequest;
use Illuminate\Http\Request;

class ChainsawController extends Controller
{
    public function index() 
    {
        return view('Pages.Applicant.chainsaw-registration.index');
    }

    public function list(ChainsawService $chainsawService, Request $request) 
    {
        $role = auth()->user()->role;
        $data = $chainsawService->getChainsawData($role, $request);

        return response()->json($data);
    }

    public function create()
    {
        return view('Pages.Applicant.chainsaw-registration.create');
    }

    public function store(ChainsawRequest $request)
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

    public function show(ModelsChainsawRequest $chainsaw)
    {
        $data['chainsaw'] = $chainsaw;
        return view('Pages.Applicant.chainsaw-registration.view', $data);
    }

    public function edit(ModelsChainsawRequest $chainsaw)
    {
        if($chainsaw->status !== 0) {
            abort(404);
        }

        $data['chainsaw'] = $chainsaw;
        $data['editFlg'] = true;
        return view('Pages.Applicant.chainsaw-registration.edit', $data);
    }

    public function update(ModelsChainsawRequest $chainsaw, ChainsawRequest $request)
    {
        $payload = $request->validated();
        
        $save = $chainsaw->update($payload);
        
        if ($save) {
            return response()->json([
                'status' => 'success',
                'message' => 'Chainsaw data saved successfully.',
                'data' => $save
            ], 201);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to save Chainsaw data. Please try again.'
            ], 500);
        }
    }

    public function cancel(ModelsChainsawRequest $chainsaw)
    {
        if ($chainsaw->status === 3) {
            return response()->json([
                'status' => 'error',
                'message' => 'Chainsaw registration already cancelled, please reload the page!',
            ], 200);
        }

        try {
            $chainsaw->status = 3;
            $chainsaw->save();

            return response()->json([
                'status' => 200,
                'message' => 'Chainsaw data cancelled successfully.',
                'data' => $chainsaw
            ], 201);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to cancel chainsaw registration. Please try again.',
                'log' => $th->getMessage()
            ], 500);
        }
    }
}
