<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use App\Article;

class File extends Model
{
    protected $fillable = ['name', 'mime', 'extension', 'size', 'path', 'thumb_path', 'source_id', 'source_type', 'list_id', 'active'];

    public function getCreatedAtAttribute($date)
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', $date)->diffForHumans();
    }

    public function articles()
    {
        return $this->belongsToMany(Article::class, 'files_relations', 'file_id', 'source_id');
    }

}
