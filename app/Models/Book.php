<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

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

    public function getOwnerAttribute()
    {
        return $this->users->first();
    }

    function isAdmin()
    {
        if (Auth::user()->email === "michelange@wanadoo.fr") {
            return true;
        } else {
            return false;
        }
            
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }    

    function users()
    {
        return $this->belongsToMany(User::class);
    }    

    public function downloads()
    {
        return $this->hasMany(Download::class);
    }
}
