<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Str;

class Url extends Model
{
    use HasFactory;
    protected $fillable = [
        'long_url',
        'url_id',
        'uid',
        'description',
        'click_count',
        'is_enabled',
        'expires_at',
    ];

    protected $casts = [
        'is_enabled' => 'boolean',
        'expires_at' => 'datetime',
        'click_count' => 'integer',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($url) {
            $url->uid = (string) Str::ulid();
        });
    }

    public static function generateUniqueUrlId(): string
    {
        do {
            $id = Str::random(6);
        } while (self::where('url_id', $id)->exists());

        return $id;
    }
}
