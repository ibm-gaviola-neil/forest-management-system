<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\ProfileImageRequest;
use App\Http\Requests\ProfileSettingRequest;
use App\Models\User;
use App\Http\Services\PasswordService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileSettingController extends Controller
{
    /**
     * The password service instance.
     *
     * @var PasswordService
     */
    protected $passwordService;

     /**
     * Create a new controller instance.
     *
     * @param PasswordService $passwordService
     * @return void
     */
    public function __construct(PasswordService $passwordService)
    {
        $this->passwordService = $passwordService;
    }

    public function index(Request $request)
    {
        $data['tab'] = $request->query('tab') ?? 'account-settings';
        $data['user_profile'] = auth()->user();;
        return view('Pages.Applicant.profile.index', $data);
    }

    public function update(ProfileSettingRequest $request)
    {
        $payload = $request->validated();

        try {
            $user = User::where('id', auth()->user()->id)->first();
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

    public function updateProfileImage(ProfileImageRequest $request)
    {
        $payload = $request->validated();

        try {
            $user = User::where('id', auth()->user()->id)->first();

            if ($request->hasFile('profile_image')) {
                $file = $request->file('profile_image');
                $filename = 'profile_' . auth()->user()->id . '_' . time() . '.' . $file->getClientOriginalExtension();
                $file->storeAs('public/profile_images', $filename);
                $payload['profile_image'] = $filename;
            }

            $user->update($payload);

            return response()->json([
                'status' => 'success',
                'message' => 'Profile image updated successfully.'
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred while updating the profile image: ' . $th->getMessage()
            ], 500);
        }
    }

    /**
     * Change the authenticated user's password.
     *
     * @param ChangePasswordRequest $request
     * @return JsonResponse
     */
    public function changePassword(ChangePasswordRequest $request): JsonResponse
    {
        // Get validated data
        $validatedData = $request->validated();

        // Call the password service to change the password
        $result = $this->passwordService->changePassword(
            $request->user(),
            $validatedData['current_password'],
            $validatedData['password']
        );

        if ($result['success']) {
            Auth::logout();
            return response()->json([
                'success' => true,
                'message' => $result['message']
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => $result['message'],
                'errors' => [
                    "current_password" => [
                        $result['message']
                    ]
                ]
            ], 422);
        }
    }
}
