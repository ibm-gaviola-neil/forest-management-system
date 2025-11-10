<?php

namespace App\Http\View;

use App\Http\Domains\NotificationDomain;
use App\Models\Notification;
use Illuminate\View\View;

class NotificationComposer
{
    public function compose(View $view)
    {
        $nofications = Notification::where('is_read', false)->orderBy('created_at', 'DESC')->get();

        foreach ($nofications as $notification) {
            $notification->icon = NotificationDomain::TYPES_ICONS[$notification->type] ?? '';
            $notification->title = NotificationDomain::TYPES_TITLES[$notification->type] ?? '';
        }
        $view->with('nofications', $nofications);
    }
}