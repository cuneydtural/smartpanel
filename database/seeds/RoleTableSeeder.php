<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('roles')->delete();
        DB::table('roles')->insert(
            [
                'slug' => 'admin',
                'name' => 'Admin',
                'permissions' => '{"superuser":true,"sistem.*":true,"kullanici.*":true,"rapor.*":true,"admin.users.index":true,
                "admin.users.create":true,"admin.users.edit":true,"admin.roles.index":true,"admin.roles.create":true,
                "admin.roles.edit":true,"admin.articles.create":true}',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ]
        );
    }
}

