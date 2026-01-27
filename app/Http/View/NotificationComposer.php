<?php

namespace App\Http\View;

use App\Http\Domains\NotificationDomain;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\View\View;

class NotificationComposer
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function compose(View $view)
    {
        $nofications = $this->geNotification($this->request);
        $view->with('nofications', $nofications);
    }

    protected function geNotification(Request $request)
    {
        $userRole = null;

        if ($request->has('notification_id')) {
            Notification::where('id', $request->input('notification_id'))
                ->update(['is_read' => 1]);
        }

        if (auth()->user() === null) {
            return collect();
        }

        $userRole = auth()->user()->role;
        $specificRelatedId = auth()->user()->donor_id;

        $query = Notification::where('is_read', false)
            ->whereIn('type', NotificationDomain::NOTIFICATION_ACCESS[$userRole]);

        if($userRole === 'applicant') {
            $query->where('reciever_id', auth()->user()->id);
        }

        $nofications = $query->orderBy('created_at', 'DESC')->get();

        foreach ($nofications as $key => $notification) {
            // Check for donor_request type and related_id
            if ($notification->type == 'donor_request' && $notification->related_id != $specificRelatedId) {
                // Skip this notification for this user
                unset($nofications[$key]);
                continue;
            }

            $notification->icon = NotificationDomain::TYPES_ICONS[$notification->type] ?? '';
            $notification->title = NotificationDomain::TYPES_TITLES[$notification->type] ?? '';
            $route = NotificationDomain::NOTIFICATION_ROUTE[$notification->type] ?? '';
    
            // Replace :id with the related_id if needed
            if (strpos($route, ':id') !== false && isset($notification->related_id)) {
                $route = str_replace(':id', $notification->related_id, $route);
            }
            
            $notification->route = $route.$notification->id;
        }

        return $nofications;
    }
}