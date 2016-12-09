<?php

namespace App\Http\Controllers;

class ListController extends Controller
{
    /**
     * @return array
     */
    public static function sortList() {
        return ['sort', 'list', 'desc', 'active', 'passive', 'all'];
    }

    public static function subDays($default = "Seçiniz") {
        
        $list = [
            '1' => 'Dün',
            '7' => '7 Gün',
            '15' => '15 Gün',
            '30' => '1 Ay',
            '60' => '2 Ay',
            '90' => '3 Ay',
            '120' => '6 Ay',
        ];

        if ($default) $list[""] = $default;
        return $list;
    }

}


