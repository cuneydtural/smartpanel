<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Support\Facades\App;
use Cviebrock\EloquentSluggable\Sluggable;
use Mcamara\LaravelLocalization\LaravelLocalization;

class Article extends Model
{

    use Sluggable;

    protected $table = 'articles';
    protected $fillable = ['category', 'title', 'desc', 'keywords', 'content', 'list_id', 'active',
        'locale', 'date', 'url', 'slug', 'slug_update', 'article_url', 'link_type'];

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'title',
            ]
        ];
    }

    /**
     * @param $date
     * @return string
     */
    public function getUpdatedAtAttribute($date)
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', $date)->diffForHumans();
    }
    
    /**
     * @param string $default
     * @return mixed
     * Kategoriler modülünden linki yazılardan seç (Selectbox)
     */
    public static function getArticles($default = "Kategori Seçiniz!")
    {
        try {
            $articles = self::with('categories', 'localeCategories')->where('locale', App::getLocale())->get();
            foreach ($articles as $article) {
                $val[] = 'ID: '.$article->id.' - '.Category::getLocaleCategories($article->categories).' / '.$article->title;
                $key[] = '/'.self::getLocaleCategorySlug($article).'/'.$article->slug;
            }
            $list = array_combine($key, $val);
            if ($default) $list[""] = $default;
            return $list;
        } catch (\Exception $e) {
            return ['' => 'İçerik bulunamadı.'];
        }
    }

    /**
     * @param string $default
     * @return mixed
     * Kategoriler Selectbox için listele. [Kullanılmıyor]
     */
    public static function getArticlesOld($default = "Kategori Seçiniz!")
    {
        $list = self::select('title', 'slug')->where('locale', App::getLocale())->get()->pluck('title', 'slug');
        if ($default) $list[""] = $default;
        return $list;
    }


    /**
     * @param $article
     * @return string
     * Seçili dile göre Slug kategori ve title getir.
     */
    public static function getSlugLink($article)
    {
        return url(self::getLocaleCategorySlug($article).'/'.$article->slug);
    }

    /**
     * @param $article
     * @return mixed
     * GetArticles fonksiyonundaki kategorinin slug halini seçili dile göre getir.
     */
    public static function getLocaleCategorySlug($article)
    {
        $locale = new LaravelLocalization();

        if($locale->getCurrentLocale() == 'tr') {
            return $article->categories->slug;
        } else {
            if($article->localeCategories) {
                return $article->localeCategories->slug;
            } else {
                return $article->categories->slug;
            }
        }
    }

    /**
     * @param $photos
     * @return string
     */
    public static function getShowcaseImage($photos)
    {
        if(isset($photos)) {
            foreach($photos as $photo) {
                if($photo->pivot->showcase) {
                    return url($photo->path.$photo->name);
                } else {
                    return '/';
                }
            }
        } else {
            return '/';
        }
    }


    /**
     * @param $article
     * @return string
     * Yazıların link çıktısını verir.
     */
    public static function getArticleLink($article) {

        switch ($article->link_type) {
            case null:
                $link = '#.';
                break;
            case 1:
                $link = '#.';
                break;
            case 2:
                $link = $article->url;
                break;
            case 3:
                $link = $article->article_url;
        }

        return $link;
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     * Yazıya bağlı kategorileri getir.
     */
    public function categories()
    {
        return $this->hasOne(Category::class, 'id', 'category');
    }

    /**
     * @return mixed
     * Yerel kategorileri getir.
     */
    public function localeCategories()
    {
        return $this->hasOne(CategoryLocale::class, 'category_id', 'category')->where('locale', App::getLocale());
    }

    /**
     * @return $this
     * Yazılara bağlı fotoğrafları getir.
     */
    public function photos()
    {
        return $this->belongsToMany(File::class, 'files_relations', 'source_id', 'file_id')
            ->withPivot('id','showcase', 'active', 'list_id', 'active');
    }

}
