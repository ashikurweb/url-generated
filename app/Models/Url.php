<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Url extends Model
{
    protected $fillable = [
        'original_url',
        'short_code',
        'description',
        'clicks',
        'is_enabled',
        'expires_at',
    ];

    protected $casts = [
        'is_enabled' => 'boolean',
        'expires_at' => 'datetime',
    ];

    public static function generateUniqueShortCode(): string
    {
        do {
            $code = bin2hex(random_bytes(3)); // 6 characters
        } while (self::where('short_code', $code)->exists());

        return $code;
    }
}
