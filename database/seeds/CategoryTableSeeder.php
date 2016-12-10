<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoryTableSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categories')->delete();

        $root = \App\Category::create([
            'name' => 'Kategoriler (Root)',
            'slug' => 'kategoriler-root',
            'active' => '1',
            'list_id' => '1',
        ]);

        $root->children()->create([
            'name' => 'Değişkenler',
            'slug' => 'degiskenler',
            'active' => '0',
            'list_id' => '1',
        ]);

        $navs = $root->children()->create([
            'name' => 'Menü Kategorileri',
            'slug' => 'menu-kategorileri',
            'active' => '0',
            'list_id' => '2',
        ]);

        $navs->children()->create([
            'name' => 'Header Menüler',
            'slug' => 'header-menuler',
            'active' => '1',
            'list_id' => '1',
        ]);

        $navs->children()->create([
            'name' => 'Footer Menüler',
            'slug' => 'footer-menuler',
            'active' => '1',
            'list_id' => '2',
        ]);

        $articles = $root->children()->create([
            'name' => 'Yazı Kategorileri',
            'slug' => 'yazi-kategorileri',
            'active' => '0',
            'list_id' => '3',
        ]);

        $articles->children()->create([
            'name' => 'Blog',
            'slug' => 'blog',
            'active' => '0',
            'list_id' => '3',
        ]);

        $articles->children()->create([
            'name' => 'Basında Biz',
            'slug' => 'basinda-biz',
            'active' => '0',
            'list_id' => '3',
        ]);

        $articles->children()->create([
            'name' => 'Sayfalar',
            'slug' => 'sayfalar',
            'active' => '0',
            'list_id' => '0',
        ]);

        $articles->children()->create([
            'name' => 'Anasayfa İçerikler',
            'slug' => 'anasayfa-icerikler',
            'active' => '0',
            'list_id' => '0',
        ]);

        $brands = $root->children()->create([
            'name' => 'Markalar',
            'slug' => 'markalar',
            'active' => '0',
            'list_id' => '4',
        ]);

        $brands->children()->create([
            'name' => 'Marka 1',
            'slug' => 'marka 1',
            'active' => '0',
            'list_id' => '0',
        ]);
        
        $root->children()->create([
            'name' => 'Ürün Kategorileri',
            'slug' => 'urun-kategorileri',
            'active' => '0',
            'list_id' => '3',
        ]);
    }
}
