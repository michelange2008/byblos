<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable = [
        'title',
        'author',
        'authors',
        'file',
        'cover',
        'isbn',
        'language',
        'description',
        'published_at',
        'publisher',
    ];

    protected $casts = [
        'authors' => 'array',
    ];

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }
}
