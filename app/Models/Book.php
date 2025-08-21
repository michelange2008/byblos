<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable = [
        'title',
        'author',
        'authors',
        'lastName',
        'file',
        'cover',
        'description',
        'publisher',
        'published_at',
    ];

    protected $casts = [
        'authors' => 'array',
    ];

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }
}
