<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

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
        'type',
    ];

    /**
     * Retrieve a cached setting value.
     */
    public static function get($key, $default = null)
    {
        $setting = Cache::remember("setting_{$key}", 60, function () use ($key) {
            return self::where('key', $key)->first();
        });

        if (! $setting || $setting->value === null) {
            return $default;
        }

        return self::castValue($setting->value, $setting->type);
    }

    /**
     * Cast a setting value based on its configured type.
     */
    protected static function castValue($value, $type)
    {
        return match ($type) {
            'boolean' => filter_var($value, FILTER_VALIDATE_BOOLEAN),
            'integer' => (int) $value,
            'float' => (float) $value,
            default => $value,
        };
    }

    /**
     * Flush cached setting values when settings change.
     */
    protected static function booted(): void
    {
        static::saved(function (Setting $setting): void {
            Cache::forget("setting_{$setting->key}");
        });

        static::deleted(function (Setting $setting): void {
            Cache::forget("setting_{$setting->key}");
        });
    }
}
