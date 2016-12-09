<?php

namespace App\Http\Controllers;

use App\Http\Requests;

class PermissionController extends Controller
{

    protected static $permissions = [
        'superuser' => 'Superuser',
        'admin.dashboard.*' => 'Dashboard\'a erişim sağlar.' ,
        'admin.logs.*' => 'Hata Logları' ,
        'admin.settings.*' => 'Sistem ayarlarına erişim sağlar',
        'admin.users.*' => 'Kullanıcı ve yetkilere erişim sağlar',
        'admin.articles.*' => 'Raporlara erişim sağlar',
        'admin.forms.*' => 'Formlara erişim sağlar',
        'admin.stores.*' => 'Şubelere erişim sağlar',
        'admin.subscribers.*' => 'E-Mail Aboneleri' ,
        'admin.photo-library.*' => 'Fotoğraf kütüphanesine erişim sağlar',
        'admin.users.index' => 'Kullanıcı listelerini görüntüler',
        'admin.users.create' => 'Yeni kullanıcı oluşturur',
        'admin.users.edit'  => 'Kullanıcı kayıtlarını düzenler',
        'admin.roles.index' => 'Kullanıcı rollerini listeler',
        'admin.roles.create' => 'Kullanıcı rolü ekler',
        'admin.roles.edit' => 'Kullanıcı rolü düzenler',
        'admin.articles.create' => 'Makale ekleyebilir',
        'admin.articles.*' => 'Makale Görüntüleyebilir',
        'admin.categories.edit' => 'Kategori düzenleyebilir',
        'admin.categories.create' => 'Kategori ekleyebilir',
        'admin.categories.index' => 'Kategorileri görüntüleyebilir',
        'admin.slides.index' => 'Slide listeler',
        'admin.slides.create' => 'Slide ekler',
        'admin.slides.edit' => 'Slide düzenler',
    ];

    /**
     * @return array
     */
    public static function getPermissions() {
        return self::$permissions;
    }

    /**
     * @param array $permissions
     */
    public static function setPermissions($permissions)
    {
        self::$permissions = $permissions;
    }


    /**
     * @param $route
     * @return bool|int|string
     */
    public static function authCheck($route)
    {
        $permissions = self::getPermissions();

        foreach ($permissions as $key => $value) {
            $sPattern = sprintf(
                '~^%s~',
                str_replace('\*', '(.{1})', preg_quote($key))
            );
            if (preg_match($sPattern, $route))
                return $key;
        }
        return false;
    }


}
