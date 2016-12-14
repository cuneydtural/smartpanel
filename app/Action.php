<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Action extends Model
{

    protected $fillable = ['desc', 'user_id', 'icon'];

    public static function last()
    {
        return self::with('user')->orderBy('id', 'desc')->take(10)->get();
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function getCreatedAtAttribute($date)
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', $date)->diffForHumans();
    }

}
