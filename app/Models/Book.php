<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable = ['title', 'author', 'description', 'file'];

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }
}

