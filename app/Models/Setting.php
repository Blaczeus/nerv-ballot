<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'key',
        'value',
    ];

    /**
     * Retrieve a cached setting value.
     */
    public static function get($key, $default = null)
    {
        $value = cache()->remember("setting_{$key}", 60, function () use ($key) {
            return self::where('key', $key)->value('value');
        });

        return $value ?? $default;
    }
}
