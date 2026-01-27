<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\EditApplicantRequest;
use App\Http\Requests\ProfileSettingRequest;
use App\Http\Services\ApplicantServices;
use App\Models\User;
use Illuminate\Http\Request;

class AdminApplicantController extends Controller
{
    public function index() 
    {
        $data['pageTitle'] = 'Registered Applicants';
        $data['pageSubTitle'] = 'Manage registered applicants in the system';
        return view('Pages.Admin.applicants.index', $data);
    }

    public function list(ApplicantServices $applicantService, Request $request) 
    {
        $role = auth()->user()->role;
        $data = $applicantService->getApplicant($request);

        return response()->json($data);
    }

    public function show(User $user)
    {
        $data['user_profile'] = $user;
        $data['pageTitle'] = 'Applicants Profile';
        return view('Pages.Admin.applicants.view', $data);
    }

    public function edit(User $user)
    {
        $data['user_profile'] = $user;
        $data['pageTitle'] = 'Applicants Profile';
        return view('Pages.Admin.applicants.edit', $data);
    }

    public function update(EditApplicantRequest $request, User $user)
    {
        $payload = $request->validated();

        try {
            $user->update($payload);

            return response()->json([
                'status' => 'success',
                'message' => 'Profile updated successfully.'
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred while updating the profile: ' . $th->getMessage()
            ], 500);
        }
    }
}
