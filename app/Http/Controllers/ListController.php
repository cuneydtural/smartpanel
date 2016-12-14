<?php

namespace App\Http\Controllers;

class ListController extends Controller
{
    /**
     * @return array
     * Listeleme / Filtreleme türleri.
     */
    public static function sortList() {
        return ['sort', 'list', 'desc', 'active', 'passive', 'all'];
    }

    /**
     * @param string $default
     * @return array
     * Raporlar için gerekli periyotlar.
     */
    public static function subDays($default = "Seçiniz") {
        $list = [
            '1' => 'Dün',
            '7' => '7 Gün',
            '15' => '15 Gün',
            '30' => '1 Ay',
            '60' => '2 Ay',
            '90' => '3 Ay',
            '120' => '6 Ay',
            '365' => '1 Yıl',
        ];
        if ($default) $list[""] = $default;
        return $list;
    }


    /**
     * @param string $default
     * @return array
     * Ürünler Ölçü Birimleri
     */
    public static function quantityTypes($default = "Ölçü Birimi") {
        $list = [
            'piece' => 'Adet',
            'gram' => 'Gram',
            'kilo' => 'Kilo',
            'package' => 'Paket',
        ];
        if ($default) $list[""] = $default;
        return $list;
    }


}

