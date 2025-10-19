<?php

namespace App\Http\Services;

use App\Models\SystemSettings;

class SettingService {
    public function getSettings() : array
    {
        $settings = SystemSettings::first();
        $data = array();

        $data = [
            'settings' => $settings,
            'is_enable' => $this->setEnableRegister($settings)
        ];

        return $data;
    }

    private function setEnableRegister(SystemSettings $settings) : bool
    {   
        $is_enable = false;

        if(!$settings){
            return false;
        }

        switch ($settings->is_enable) {
            case 1:
                $is_enable = true;
                break;

            case 2:
                $is_enable = false;
                break;
            
            case 3:
                $startDate = $settings->display_start_date;
                $endDate = $settings->display_end_date;
                $today = date('Y-m-d');
                if ($today >= $startDate && $today <= $endDate) {
                    $is_enable = true;
                } else {
                    $is_enable = false;
                }
                break;
            default:
                return false;
        }

        return $is_enable;
    }
}