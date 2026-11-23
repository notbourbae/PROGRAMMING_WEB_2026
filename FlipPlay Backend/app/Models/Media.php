<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    protected $table = 'media';

    protected $fillable = [
        'title',
        'type',
        'genre',
        'rating',
        'episodes',
        'studio',
    ];

    protected $casts = [
        'rating' => 'float',
        'episodes' => 'integer',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
