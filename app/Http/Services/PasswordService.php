<?php

namespace App\Http\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class PasswordService
{
    /**
     * Change the user's password.
     *
     * @param User $user
     * @param string $currentPassword
     * @param string $newPassword
     * @return array
     */
    public function changePassword(User $user, string $currentPassword, string $newPassword): array
    {
        // Check if the current password is correct
        if (!Hash::check($currentPassword, $user->password)) {
            return [
                'success' => false,
                'message' => 'The current password is incorrect.'
            ];
        }

        // Update the password
        $user->password = Hash::make($newPassword);
        $user->save();

        return [
            'success' => true,
            'message' => 'Password has been changed successfully.'
        ];
    }
}