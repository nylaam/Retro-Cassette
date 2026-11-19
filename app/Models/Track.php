<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Track extends Model
{
    protected $fillable = [
        'title', 'artist', 'duration_sec',
        'source_type', 'source_id', 'side', 'position',
    ];

    public function cassette()
    {
        return $this->belongsTo(Cassette::class);
    }
}