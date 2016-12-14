<?php

namespace App\Observers;

use App\Action;
use App\User;

class UserObserver extends Observer
{

    public function created(User $user)
    {
        Action::create([
            'desc' => $user->first_name.' '.$user->last_name.' isimli kullanıcı eklendi.',
            'user_id' => $this->profile->id,
            'icon' => 'icon-user-plus'
        ]);
    }

    public function updated(User $user)
    {
        Action::create([
            'desc' => $user->first_name.' '.$user->last_name.' isimli kullanıcı güncellendi.',
            'user_id' => $this->profile->id,
            'icon' => 'icon-user'
        ]);
    }

    public function deleted(User $user)
    {
        Action::create([
            'desc' => $user->first_name.' '.$user->last_name.' isimli kullanıcı silindi.',
            'user_id' => $this->profile->id,
            'icon' => 'icon-user-cancel'
        ]);
    }


}