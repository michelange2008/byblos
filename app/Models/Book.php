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

    function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function getOwnerAttribute()
    {
        return $this->users->first();
    }

    public function downloads()
    {
        return $this->hasMany(Download::class);
    }
}
