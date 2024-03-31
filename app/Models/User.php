<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Prunable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    use Prunable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'url_name',
        'email',
        'password',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // Userモデルを定期的に削除する
    public function prunable()
    {
        // 作成後3時間以上経過したゲストユーザーを削除する
        return static::where('created_at', '<=', now()->subHours(3))->where('role', 'guest');
    }

    /**
     * UserとArtistに多対多のリレーションを定義する。
     *
     * @return BelongsToMany
     */
    public function artists(): BelongsToMany
    {
        return $this->belongsToMany(Artist::class);
    }

    /**
     * UserとSpotifyArtistに多対多のリレーションを定義する
     *
     * @return BelongsToMany
     */
    public function spotifyArtists(): BelongsToMany
    {
        return $this->belongsToMany(SpotifyArtist::class);
    }
}
