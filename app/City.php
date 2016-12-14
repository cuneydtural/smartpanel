<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    
    /**
     * İlçeler
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function districts()
    {
        return $this->hasMany(District::class);
    }

    /**
     * @param string $default
     * @return \___PHPSTORM_HELPERS\static|array|mixed
     */
    public static function getCities($default = "Şehir Seçiniz")
    {
        $lists = self::all();

        foreach ($lists as $list) {
            $val[] = $list->city;
            $key[] = $list->city_id;
        }

        $list = array_combine($key, $val);
        if ($default) $list[""] = $default;
        return $list;
    }


}
