<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminUserRequest;
use App\Http\Requests\EditApplicantRequest;
use App\Http\Services\ApplicantServices;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminUserController extends Controller
{
    public function index() 
    {
        $data['pageTitle'] = 'Registered Users';
        $data['pageSubTitle'] = 'Manage registered applicants in the system';
        return view('Pages.Admin.users.index', $data);
    }

    public function list(ApplicantServices $applicantService, Request $request) 
    {
        $data = $applicantService->getApplicant($request, ['denr','admin']);

        return response()->json($data);
    }

    public function create()
    {
        $data['pageTitle'] = 'Create User';
        return view('Pages.Admin.users.create', $data);
    }

    public function show(User $user)
    {
        $data['user_profile'] = $user;
        $data['pageTitle'] = 'User Profile';
        return view('Pages.Admin.users.view', $data);
    }

    public function edit(User $user)
    {
        $data['user_profile'] = $user;
        $data['pageTitle'] = 'User Profile';
        return view('Pages.Admin.users.edit', $data);
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

    public function store(AdminUserRequest $request)
    {
        $payload = $request->validated();

        try {
            $payload['password'] = Hash::make($payload['password']);
            User::create($payload);

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
