<?php

namespace App;

use Baum\Node;
use Illuminate\Support\Facades\App;
use Mcamara\LaravelLocalization\LaravelLocalization;

class Category extends Node
{

    protected $orderColumn = 'list_id';

    /**
     * @return array
     */
    public static function linkType()
    {
        $list = [
            '1' => 'Bağlantı Yok',
            '2' => 'Elle menü bağlantısı oluştur',
            '3' => 'Yazılardan seçerek bağlantı oluştur',
        ];
        return $list;
    }

    /**
     * @param string $default
     * @return mixed
     * Yazı kategorileri (Selectbox)
     */
    public static function getArticleCategories($default = "Kategori Seçiniz!")
    {
        $lists = self::where('slug', '=', 'yazi-kategorileri')->first()->getDescendants();

        foreach ($lists as $list) {
            $val[] = str_repeat('-', $list->depth ).' '.self::getLocaleCategories($list);
            $key[] = $list->id;
        }

        $list = array_combine($key, $val);
        if ($default) $list[""] = $default;
        return $list;
    }

    /**
     * @param $categories
     * @return mixed
     * Aktif dil seçeneğine göre locale name yada name gönderir.
     * Header ve Footer'da kategorileri listelerken kullanılıyor.
     */
    public static function getLocaleCategories($categories) {

        $locale = new LaravelLocalization();
        
        if($locale->getCurrentLocale() == 'tr') {
            return $categories->name;
        } else {
            if($categories->locales) {
                return $categories->locales->name;
            } else {
                return $categories->name;
            }
        }
    }

    /**
     * @param $category
     * @return string
     * Kategori linklerini yerele göre gönderir.
     * getHeaderNav fonksiyonunda kullanılıyor.
     */
    public static function getCategoryLink($category) {

        $locale = new LaravelLocalization();

        if($locale->getCurrentLocale() == 'tr') {

            switch ($category->link_type) {
                case null:
                    $link = '#.';
                    break;
                case 1:
                    $link = '#.';
                    break;
                case 2:
                    $link = $category->url;
                    break;
                case 3:
                    $link = $category->article_url;
            }
        } elseif($category->locales) {
            switch ($category->locales->link_type) {
                case null:
                    $link = '#.';
                    break;
                case 1:
                    $link = '#.';
                    break;
                case 2:
                    $link = $category->locales->url;
                    break;
                case 3:
                    $link = $category->locales->article_url;
            }
        } else {
            $link = '#';
        }
        return $link;
    }

    /**
     * @return mixed
     * Locales Relationship
     */
    public function locales()
    {
        return $this->hasOne(CategoryLocale::class, 'category_id', 'id')->where('locale', App::getLocale());
    }
    

    /**
     * @param string $default
     * @return array
     */
    public static function getProductCategories($default = "Kategori Seçiniz!")
    {
        $lists = self::where('slug', '=', 'urun-kategorileri')->first()->getDescendants();

        foreach ($lists as $list) {
            $val[] = str_repeat('-', $list->depth ).' '.self::getLocaleCategories($list);
            $key[] = $list->id;
        }

        $list = array_combine($key, $val);
        if ($default) $list[""] = $default;
        return $list;
    }


    /**
     * @param string $default
     * @return array
     */
    public static function getBrands($default = "Kategori Seçiniz!")
    {
        $lists = self::where('slug', '=', 'markalar')->first()->getDescendants();

        if(count($lists)) {
            foreach ($lists as $list) {
                $val[] = str_repeat('-', $list->depth ).' '.self::getLocaleCategories($list);
                $key[] = $list->id;
            }
            $list = array_combine($key, $val);
        }

        if ($default) $list[""] = $default;
        return $list;
    }

}
