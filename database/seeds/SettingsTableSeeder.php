<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('settings')->delete();
        DB::table('settings')->insert(
            [
                'site_name' => 'Site Adı (TR)',
                'title' => 'Site Başlığı',
                'keywords' => 'key1, key2, key3, key4, key5',
                'desc' => 'Site Açıklaması',
                'locale' => 'tr',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ]
        );

        DB::table('settings')->insert(
            [
                'site_name' => 'Site Adı (EN)',
                'title' => 'Site Başlığı',
                'keywords' => 'key1, key2, key3, key4, key5',
                'desc' => 'Site Açıklaması',
                'locale' => 'en',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ]
        );
    }
}
