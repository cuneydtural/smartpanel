<?php

namespace App\Observers;
use App\Category;
use App\Action;

class CategoryObserver extends Observer
{

    public function updated(Category $category)
    {
        Action::create([
            'desc' => '(' .$category->name. ') kategorisi güncellendi',
            'user_id' => $this->profile->id,
            'icon' => 'icon-menu'
        ]);
    }

    public function deleted(Category $category)
    {
        Action::create([
            'desc' => '(' .$category->name. ') kategorisi silindi',
            'user_id' => $this->profile->id,
            'icon' => 'icon-folder-remove'
        ]);
    }

}