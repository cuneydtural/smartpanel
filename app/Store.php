<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    protected $table = 'stores';

    protected $fillable = ['name', 'category', 'address', 'address2', 'city', 'district', 'zip',
    'country', 'lat', 'lng', 'phone', 'email', 'list_id', 'active'];

    /**
     * @return array
     */
    public static function categories()
    {
        $list = [
            '1' => 'Satış Noktalarımız',
            '3' => 'Servislerimiz',
        ];
        return $list;
    }

    /**
     * @param $formType
     * @return mixed
     */
    public static function getCategories($formType) {
        $type = array_only(self::categories(), [$formType]);
        return $type[$formType];
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function cities()
    {
        return $this->hasOne(City::class, 'city_id', 'city');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function districts()
    {
        return $this->belongsTo(District::class, 'district', 'id');
    }

}
