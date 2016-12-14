<?php

namespace App\Observers;

use App\Action;
use App\Setting;

class SettingObserver extends Observer
{

    public function updating(Setting $setting)
    {
        Action::create([
            'desc' => 'Site ayarları güncellendi',
            'user_id' => $this->profile->id,
            'icon' => 'icon-file-text3'
        ]);
    }

}