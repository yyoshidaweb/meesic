<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Artist extends Model
{
    use HasFactory;

    // 一括割り当ての有効化
    protected $fillable = [
        'name',
    ];

    /**
     * UserとArtistに多対多のリレーションを定義する
     *
     * @return void
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'artist_user', 'artist_id', 'user_id');
    }
}
