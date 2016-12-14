<?php

namespace App\Observers;

use App\Action;
use App\Article;

class ArticleObserver extends Observer
{

    public function updated(Article $article)
    {
        Action::create([
            'desc' => '('.$article->title.') başlıklı yazı güncellendi',
            'user_id' => $this->profile->id,
            'icon' => 'icon-file-openoffice'
        ]);
    }

    public function deleted(Article $article)
    {
        Action::create([
            'desc' => '('.$article->title. ') başlıklı yazı silindi',
            'user_id' => $this->profile->id,
            'icon' => 'icon-eraser'
        ]);
    }


}