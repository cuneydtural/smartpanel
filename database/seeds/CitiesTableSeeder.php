<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CitiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('cities')->delete();

        $cities = [
            [ 'city_id' => 1, 'city' => 'Adana'],
            [ 'city_id' => 2, 'city' => 'Adıyaman' ],
            [ 'city_id' => 3, 'city' => 'Afyonkarahisar' ],
            [ 'city_id' => 4, 'city' => 'Ağrı' ],
            [ 'city_id' => 5, 'city' => 'Amasya' ],
            [ 'city_id' => 6, 'city' => 'Ankara' ],
            [ 'city_id' => 7, 'city' => 'Antalya' ],
            [ 'city_id' => 8, 'city' => 'Artvin' ],
            [ 'city_id' => 9, 'city' => 'Aydın' ],
            [ 'city_id' => 10, 'city' => 'Balıkesir' ],
            [ 'city_id' => 11, 'city' => 'Bilecik' ],
            [ 'city_id' => 12, 'city' => 'Bingöl' ],
            [ 'city_id' => 13, 'city' => 'Bitlis' ],
            [ 'city_id' => 14, 'city' => 'Bolu' ],
            [ 'city_id' => 15, 'city' => 'Burdur' ],
            [ 'city_id' => 16, 'city' => 'Bursa' ],
            [ 'city_id' => 17, 'city' => 'Çanakkale' ],
            [ 'city_id' => 18, 'city' => 'Çankırı' ],
            [ 'city_id' => 19, 'city' => 'Çorum' ],
            [ 'city_id' => 20, 'city' => 'Denizli' ],
            [ 'city_id' => 21, 'city' => 'Diyarbakır' ],
            [ 'city_id' => 22, 'city' => 'Edirne' ],
            [ 'city_id' => 23, 'city' => 'Elazığ' ],
            [ 'city_id' => 24, 'city' => 'Erzincan' ],
            [ 'city_id' => 25, 'city' => 'Erzurum' ],
            [ 'city_id' => 26, 'city' => 'Eskişehir' ],
            [ 'city_id' => 27, 'city' => 'Gaziantep' ],
            [ 'city_id' => 28, 'city' => 'Giresun' ],
            [ 'city_id' => 29, 'city' => 'Gümüşhane' ],
            [ 'city_id' => 30, 'city' => 'Hakkari' ],
            [ 'city_id' => 31, 'city' => 'Hatay' ],
            [ 'city_id' => 32, 'city' => 'Isparta' ],
            [ 'city_id' => 33, 'city' => 'Mersin' ],
            [ 'city_id' => 34, 'city' => 'İstanbul' ],
            [ 'city_id' => 35, 'city' => 'İzmir' ],
            [ 'city_id' => 36, 'city' => 'Kars' ],
            [ 'city_id' => 37, 'city' => 'Kastamonu' ],
            [ 'city_id' => 38, 'city' => 'Kayseri' ],
            [ 'city_id' => 39, 'city' => 'Kırklareli' ],
            [ 'city_id' => 40, 'city' => 'Kırşehir' ],
            [ 'city_id' => 41, 'city' => 'Kocaeli' ],
            [ 'city_id' => 42, 'city' => 'Konya' ],
            [ 'city_id' => 43, 'city' => 'Kütahya' ],
            [ 'city_id' => 44, 'city' => 'Malatya' ],
            [ 'city_id' => 45, 'city' => 'Manisa' ],
            [ 'city_id' => 46, 'city' => 'Kahramanmaraş' ],
            [ 'city_id' => 47, 'city' => 'Mardin' ],
            [ 'city_id' => 48, 'city' => 'Muğla' ],
            [ 'city_id' => 49, 'city' => 'Muş' ],
            [ 'city_id' => 50, 'city' => 'Nevşehir' ],
            [ 'city_id' => 51, 'city' => 'Niğde' ],
            [ 'city_id' => 52, 'city' => 'Ordu' ],
            [ 'city_id' => 53, 'city' => 'Rize' ],
            [ 'city_id' => 54, 'city' => 'Sakarya' ],
            [ 'city_id' => 55, 'city' => 'Samsun' ],
            [ 'city_id' => 56, 'city' => 'Siirt' ],
            [ 'city_id' => 57, 'city' => 'Sinop' ],
            [ 'city_id' => 58, 'city' => 'Sivas' ],
            [ 'city_id' => 59, 'city' => 'Tekirdağ' ],
            [ 'city_id' => 60, 'city' => 'Tokat' ],
            [ 'city_id' => 61, 'city' => 'Trabzon' ],
            [ 'city_id' => 62, 'city' => 'Tunceli' ],
            [ 'city_id' => 63, 'city' => 'Şanlıurfa' ],
            [ 'city_id' => 64, 'city' => 'Uşak' ],
            [ 'city_id' => 65, 'city' => 'Van' ],
            [ 'city_id' => 66, 'city' => 'Yozgat' ],
            [ 'city_id' => 67, 'city' => 'Zonguldak' ],
            [ 'city_id' => 68, 'city' => 'Aksaray' ],
            [ 'city_id' => 69, 'city' => 'Bayburt' ],
            [ 'city_id' => 70, 'city' => 'Karaman' ],
            [ 'city_id' => 71, 'city' => 'Kırıkkale' ],
            [ 'city_id' => 72, 'city' => 'Batman' ],
            [ 'city_id' => 73, 'city' => 'Şırnak' ],
            [ 'city_id' => 74, 'city' => 'Bartın' ],
            [ 'city_id' => 75, 'city' => 'Ardahan' ],
            [ 'city_id' => 76, 'city' => 'Iğdır' ],
            [ 'city_id' => 77, 'city' => 'Yalova' ],
            [ 'city_id' => 78, 'city' => 'Karabük' ],
            [ 'city_id' => 79, 'city' => 'Kilis' ],
            [ 'city_id' => 80, 'city' => 'Osmaniye' ],
            [ 'city_id' => 81, 'city' => 'Düzce' ],
        ];

        DB::table('cities')->insert($cities);
    }
}
