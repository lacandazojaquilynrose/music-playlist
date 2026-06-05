<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Playlist extends Model
{
    protected $fillable = ['user_id', 'name'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function songs(): BelongsToMany
    {
        // Removed ->withTimestamps() to stop looking for created_at/updated_at columns
        return $this->belongsToMany(Song::class, 'playlist_song');
    }
}