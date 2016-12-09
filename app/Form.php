<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Form extends Model
{
    protected $table  = 'forms';
    protected $guarded = ['*'];
    protected $fillable = ['name', 'email', 'phone', 'subject', 'message', 'type',
        'list_id', 'active', 'city', 'district', 'notes'];

    public static function types($default = "Seçiniz")
    {
        $list = [
            '1' => 'Biz Sizi Arayalım',
            '2' => 'İletişim Formu',
        ];

        if ($default) $list[""] = $default;
        return $list;
    }

    public static function getFormType($formType) {
        $type = array_only(self::types(), [$formType]);
        return $type[$formType];
    }

    public function getUpdatedAtAttribute($date)
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', $date)->diffForHumans();
    }
}
