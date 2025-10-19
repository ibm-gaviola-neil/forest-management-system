<?php

namespace App\Http\View;

use Illuminate\View\View;
use App\Models\SystemSetting;
use App\Models\SystemSettings;

class SystemSettingsComposer
{
    public function compose(View $view)
    {
        $settings = SystemSettings::first();
        $view->with('systemSettings', $settings);
    }
}