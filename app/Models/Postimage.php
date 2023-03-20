<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Postimage extends Model
{
    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    protected $fillable = [
        'image_name',
        'post_id',
        'path',
    ];
}
