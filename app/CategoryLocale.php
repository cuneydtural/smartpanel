<?php

namespace App;

use Mcamara\LaravelLocalization\LaravelLocalization;

use Illuminate\Database\Eloquent\Model;

class CategoryLocale extends Model
{
    protected $table = 'category_langs';

    protected $fillable = [
        'category_id', 'name', 'slug', 'locale', 'url', 'article_url', 'link_type'
    ];
    
}
