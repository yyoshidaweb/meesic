<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class SpotifyArtist extends Model
{
    use HasFactory;

    // 一括割り当ての有効化
    protected $fillable = [
        'spotify_id',
        'user_id',
    ];

    /**
     * UserとSpotifyArtistに多対多のリレーションを定義する
     *
     * @return BelongsToMany
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }
}
