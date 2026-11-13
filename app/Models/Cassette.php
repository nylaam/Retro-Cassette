<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cassette extends Model
{
    protected $fillable = ['title', 'color', 'note', 'visibility', 'sticker_style'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tracks()
    {
        return $this->hasMany(Track::class);
    }
}