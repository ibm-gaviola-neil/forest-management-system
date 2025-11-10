<?php

namespace App\Http\Services;

use App\Models\Notification;

class NotificationService
{

    /**
     * Save a notification to the database.
     * 
     * @param array $data
     * @return \App\Models\Notification
     */
    public function saveNotification($data)
    {
        return Notification::create([
            'type'           => $data['type'] ?? null,
            'message'        => $data['message'] ?? null,
            'related_id'     => $data['related_id'] ?? null,
            'related_table'  => $data['related_table'] ?? null,
            'is_read'        => $data['is_read'] ?? false,
            'created_by'     => $data['created_by'] ?? null,
        ]);
    }

    public function sendNotification($user, $message)
    {
        // Logic to send notification to the user
        // This is a placeholder implementation
        echo "Sending notification to {$user->email}: {$message}";
    }
}