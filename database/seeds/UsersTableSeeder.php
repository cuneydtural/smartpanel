<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->delete();
        DB::table('users')->insert(
            [
                'first_name' => 'Demo',
                'last_name' => 'Kullanıcı',
                'email' => 'demo@demo.com',
                'password' => bcrypt('demo'),
                'image' => 'demo-kullanici-09121611.jpg',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'permissions' => '{"superuser":true}',
            ]
        );
    }
}
