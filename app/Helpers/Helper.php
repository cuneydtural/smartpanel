<?php

namespace App\Helpers;

use Carbon\Carbon;
use DB;
use Mcamara\LaravelLocalization\LaravelLocalization;

class Helper
{
    /**
     * @param $profile
     * @return string
     * @internal param $sentinel
     */
    public static function getProfile($profile)
    {
        return $profile->first_name.' '.$profile->last_name;
    }

    /**
     * @param $val
     * @return string
     */
    public static function slug($val)
    {
        $tr = ["ş", "Ş", "ı", "(", ")", "'", "ü", "Ü", "ö", "Ö", "ç", "Ç", " ", "/", "*", "?", "ş", "Ş", "ı", "ğ", "Ğ", "İ", "ö", "Ö", "Ç", "ç", "ü", "Ü", "`"];
        $en = ["s", "s", "i", "", "", "", "u", "u", "o", "o", "c", "c", "-", "-", "-", "", "s", "s", "i", "g", "g", "i", "o", "o", "c", "c", "u", "u", "'"];
        $val = str_replace($tr, $en, $val);
        $val = preg_replace("@[^A-Za-z0-9\-_]+@i", "", $val);
        return strtolower($val);
    }


    /**
     * @param $val
     * @return mixed
     * Köşeli parantezleri temizler.
     */
    public static function escapeBrackets($val)
    {
        $old = ['[', ']', ''];
        $new = ['', '', ''];
        return $val = str_replace($old, $new, $val);
    }


    /**
     * @param $val
     * @return mixed
     */
    public static function getFileName($val) {
        $filename_array = explode('/', $val);
        $filename = $filename_array[sizeof($filename_array) - 1];
        return $filename;
    }

    /**
     * @param $val
     * @return string
     */
    public static function diffForHumans($val) {
        return Carbon::createFromFormat('Y-m-d H:i:s', $val)->diffForHumans();
    }

    /**
     * @param $roots
     * Kategori Ağacı (View)
     */
    public static function categoryTree($roots)
    {
        print "<ul>";
        foreach($roots as $root) self::renderNode($root);
        print "</ul>";
    }

    /**
     * @param $node
     * Kategori Ağacını render eder.
     */
    public static function renderNode($node)
    {
        print "<li>";
        print "<b>{$node->name}</b>";
        if ($node->children()->count() > 0) {
            print "<ul>";
            foreach ($node->children as $child) self::renderNode($child);
            print "</ul>";
        }
        print "</li>";
    }
    
    /**
     * @return mixed
     * @throws \Mcamara\LaravelLocalization\Exceptions\SupportedLocalesNotDefined
     * Selectbox
     */
    public static function getLanguages()
    {
        $locales = new LaravelLocalization();
        $all = $locales->getSupportedLocales();
        $keys  = array_keys($all);
        $values = array_pluck($all, 'native');
        $list = array_combine($keys, $values);
        return $list;
    }


    public static function getViewDate($date) {
        return Carbon::createFromFormat('Y-m-d H:i:s', $date)->format('d.m.Y');
    }

}
