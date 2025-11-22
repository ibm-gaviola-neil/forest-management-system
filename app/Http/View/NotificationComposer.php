<?php

namespace App\Http\View;

use App\Http\Domains\NotificationDomain;
use App\Models\Notification;
use Illuminate\View\View;

class NotificationComposer
{
    public function compose(View $view)
    {
        $nofications = $this->geNotification();
        $view->with('nofications', $nofications);
    }

    protected function geNotification()
    {
        $userRole = null;

        if (auth()->user() === null) {
            return collect();
        }

        $userRole = auth()->user()->role;

        $nofications = Notification::where('is_read', false)
            ->whereIn('type', NotificationDomain::NOTIFICATION_ACCESS[$userRole])
            ->orderBy('created_at', 'DESC')->get();

        foreach ($nofications as $notification) {
            $notification->icon = NotificationDomain::TYPES_ICONS[$notification->type] ?? '';
            $notification->title = NotificationDomain::TYPES_TITLES[$notification->type] ?? '';
        }

        return $nofications;
    }
}