<?php

namespace App\Helpers;

use App\Category;
use Illuminate\Support\Facades\Request;

class Frontend
{

    /**
     * @param $categories
     * View'de bu fonksiyon kullanılmalıdır.
     * Kategori parametresi with('locales') relationu ile birlikte gönderilir.
     */
    public static function getHeaderNav($categories)
    {
        print "<ul class=\"nav nav-pills\">";
        foreach($categories as $category) self::renderHeaderNav($category);
        print "</ul>";
    }


    /**
     * @param $category
     */
    public static function renderHeaderNav($category)
    {
        // Aktif dil seçeneğine göre kategori adını belirler. Döngüye dahil eder.
        $title = Category::getLocaleCategories($category);
        $link = Category::getCategoryLink($category);

        print "<li class='dropdown".self::getActiveClass($title, 2)."'><a href=\"$link\">".$title.self::getCaretIcon($category->children)."</a>";
        if ($category->children()->count() > 0) {
            print "<ul class=\"dropdown-menu\">";
            foreach ($category->children as $child) self::renderHeaderNav($child);
            print "</ul>";
        }
        print "</li>";
    }

    /**
     * @param $categories
     */
    public static function getFooterNav($categories) {
        foreach($categories as $category) {
            $title = Category::getLocaleCategories($category);
            $link = Category::getCategoryLink($category);
            print "<li><a href=\"$link\">$title</a></li>";
        }
    }

    public static function getArticleSidebar($categories) {
        foreach($categories as $category) {
            $title = Category::getLocaleCategories($category);
            $link = Category::getCategoryLink($category);
            print "<li><a href=\"$link\" class='article-sidebar".self::getActiveClass($title, 3)."'>$title <i class=\"fa fa-angle-right\"></i></a></li>";
        }
    }

    /**
     * @param $title
     * @param $segment
     * @return string
     */
    public static function getActiveClass($title, $segment) {
        if(Request::segment($segment) == str_slug($title)) {
            return ' active';
        }
    }

    /**
     * @param $val
     * @return string
     */
    public static function getCaretIcon($val) {
        if(count($val)) {
            return '<i class="fa fa-caret-down"></i>';
        }
    }


}