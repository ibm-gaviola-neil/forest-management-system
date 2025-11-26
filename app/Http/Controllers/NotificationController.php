<?php

namespace App\Http\Controllers;

use App\Http\Domains\NotificationDomain;
use App\Http\Domains\TraitAdmin;
use App\Http\Services\NotificationService;
use App\Models\Donor;
use App\Models\RequestMessage;
use App\Models\SystemSettings;
use Illuminate\Http\Request;
use Mockery\Matcher\Not;

class NotificationController extends Controller
{
    use TraitAdmin;
    protected $notificationService;
    
    public function __construct(NotificationService $notificationService) {
        $this->notificationService = $notificationService;
    }

    public function destroy () {
        $isClear = $this->notificationService->clearNotifications(auth()->user()->id);

        if ($isClear) {
            return response()->json(['message' => 'Notifications cleared successfully.'], 200);
        } else {
            return response()->json(['message' => 'Failed to clear notifications.'], 500);
        }
    }

    public function request(Donor $donor){
        $sent = $this->sendEmailNotification($donor->email, 'Blood Donation Request', $this->emailDonationRequestMessage($donor));

        if(!$sent){
            return response()->json([
                'status' => 500,
                'message' => 'Unable to send email notification!'
            ], 500);
        }

        $notification = $this->notificationService->saveNotification([
            'type' => NotificationDomain::DONOR_REQUEST,
            'message' => 'Blood Donation Request',
            'related_id' => $donor->id,
            'related_table' => null,
            'is_read' => false,
            'created_by' => auth()->user()->id,
        ]);

        RequestMessage::create([
            'notification_id' => $notification->id,
            'message' => $this->emailDonationRequestMessage($donor),
            'donor_id' => $donor->id
        ]);

        return response()->json([
            'status' => 200,
            'message' => 'Sent',
            'fuck' => $notification
        ], 200);
    }

    private function emailDonationRequestMessage(Donor $donor)
    {
        $settings = SystemSettings::first();
        $message = "Dear <b>" . ucwords($donor->first_name . " " . $donor->last_name) . "</b>,\n\n";
        $message .= "We hope this message finds you well.\n\n";
        $message .= "We are reaching out to kindly request your support for a blood donation. Your generosity and willingness to donate can make a vital difference for someone in need.\n\n";

        $message .= "If you are available and willing to donate, please contact us at your earliest convenience or visit our blood bank office. Your timely response would be greatly appreciated and could help save a life.\n\n";
        $message .= "For any questions or to confirm your availability, you may reply to this email or contact us directly at:\n";
        $message .= "  - Phone: <b>" . $settings->contact_number . "</b>\n";
        $message .= "  - Email: <b>". $settings->email_address . "</b>\n";
        $message .= "Thank you very much for your continued support and compassion.\n\n";
        $message .= "Best regards,\n";
        $message .= "<b>Blood Bank Team</b>";

        return $message;
    }
}
