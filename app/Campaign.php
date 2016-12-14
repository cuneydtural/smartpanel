<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Campaign extends Model
{
    protected $fillable = ['name', 'discount', 'date_start', 'date_end'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function products()
    {
        return $this->belongsToMany(Product::class, 'campaign_relations');
    }

    /**
     * @return $this
     */
    public function photos()
    {
        return $this->belongsToMany(File::class, 'files_relations', 'source_id', 'file_id')
            ->withPivot('id','showcase', 'active', 'list_id', 'active');
    }
}
