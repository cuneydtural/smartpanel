<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class District extends Model
{

    /**
     * @param $city_id
     * @return mixed
     * Selectbox
     */
    public static function getDistricts($city_id)
    {
        $lists = self::where('city_id', $city_id)->get();

        foreach ($lists as $list) {
            $val[] = $list->district;
            $key[] = $list->id;
        }

        $list = array_combine($key, $val);
        return $list;
    }
    
}
