<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Artist extends Model
{
    use HasFactory;

    // 一括割り当ての有効化
    protected $fillable = [
        'name',
    ];

    // ArtistからUserへのリレーション
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
