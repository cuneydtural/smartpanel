<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['category_id', 'name', 'desc', 'keywords', 'content','brand_id', 'price', 'discount', 'installment', 'vat_included',
    'quantity', 'quantity_type', 'list_id', 'active', 'locale'];

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
            ->withPivot('id','showcase', 'active', 'list_id', 'active');
    }
}
