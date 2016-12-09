<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Slide extends Model
{
    protected $table = 'slides';
    protected $fillable = [
        'photo', 'title', 'desc', 'url', 'list_id', 'active', 'locale', 'url_type', 'style_class'
    ];

    public function getUpdatedAtAttribute($date)
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', $date)->diffForHumans();
    }

    public function getCreatedAtAttribute($date)
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', $date)->diffForHumans();
    }

    public static function urlType()
    {
        $list = [
            '1' => 'Bağlantı Yok',
            '2' => 'Elle menü bağlantısı oluştur',
        ];
        return $list;
    }

}
