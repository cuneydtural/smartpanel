<?php

namespace App;

use App\Helpers\Helper;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Product extends Model
{
    protected $fillable = ['category_id', 'name', 'desc', 'keywords', 'content', 'brand_id',
        'price', 'special_price', 'discount', 'discount_type', 'installment', 'vat_included', 'quantity', 'quantity_type',
        'list_id', 'active', 'locale'];


    /**
     * @return array
     */
    public static function discountType()
    {
        $list = [
            '0' => 'İndirim Uygulanmadı',
            '1' => '% ile İndirim',
            '2' => 'Özel Fiyat',
        ];
        return $list;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     * Ürünlere bağlı kategorileri getir.
     */
    public function categories()
    {
        return $this->hasOne(Category::class, 'id', 'category_id');
    }

    /**
     * @return $this
     * Ürünlere bağlı fotoğrafları getir.
     */
    public function photos()
    {
        return $this->belongsToMany(File::class, 'files_relations', 'source_id', 'file_id')
            ->withPivot('id', 'showcase', 'active', 'list_id', 'active', 'source_type')
            ->wherePivot('source_type', 'products');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     * Kampanyalı Ürünler Listesi
     */
    public function campaigns()
    {
        return $this->belongsToMany(Campaign::class, 'campaign_relations')->where('date_end', '>=', Carbon::now());
    }

    /**
     * @param $photos
     * @return string
     */
    public static function getShowcaseImage($photos)
    {
        if (isset($photos)) {
            foreach ($photos as $photo) {
                if ($photo->pivot->showcase) {
                    return url($photo->path . $photo->name);
                } else {
                    return '/';
                }
            }
        } else {
            return '/';
        }
    }


    /**
     * @param $id
     * @return array
     * Alışveriş Sepeti için kampanyalı fiyatı bulur.
     * Shopping Cart, price bilgilerini bu fonksiyondan alıyor.
     */
    public static function getPrices($id)
    {
        // Ürün Detay
        $product = self::with('campaigns')->find($id);

        // Kampanya Detay
        $campaign = $product->campaigns->first();

        // KDV Kontrol
        $vat_included = $product->vat_included;

        // Kampanya Relation'ı var, indirim Türü % İndirim.

        if (count($campaign) && $campaign->type == 1) {
            $price = self::priceWithDiscount($campaign->discount, $product->price, $vat_included, $product->quantity);
        } else {

            // Kampanya Relation'ı yok, ürün İndirimi'de bulunmuyor.

            if ($product->discount_type == 0) {

                $price = [
                    'price' => $product->price,
                    'discount' => 0,
                    'discounted_price' => $product->price,
                    'vat_included' => $vat_included,
                    'product_quantity' => $product->quantity,
                ];

                // Kampanya Relation'ı yok, ürün indirimi özel fiyat ile.
            } elseif($product->discount_type == 2) {

                $price = [
                    'price' => $product->price,
                    'discount' => 0,
                    'discounted_price' => $product->special_price,
                    'vat_included' => $vat_included,
                    'product_quantity' => $product->quantity,
                ];

                // Kampanya Relation'ı yok, Ürün indirimi % ile.
            } elseif($product->discount_type == 1) {
                $price = self::priceWithDiscount($product->discount, $product->price, $vat_included, $product->quantity);
            }

        }
        return $price;
    }

    /**
     * @param $discount
     * @param $price
     * @param $vat
     * @param $quantity
     * @return array
     * İndirim yüzdesine göre indirimli fiyatı tespit eder.
     */
    public static function priceWithDiscount($discount, $price, $vat, $quantity)
    {
        $discountedPrice = Helper::percentageDiscount($price, $discount);

        return [
            'price' => $price,
            'discount' => $discount,
            'discounted_price' => $discountedPrice,
            'vat_included' => $vat,
            'product_quantity' => $quantity
        ];
    }

}
