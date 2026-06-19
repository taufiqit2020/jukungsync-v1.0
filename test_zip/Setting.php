<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = ['key', 'value'];

    /**
     * Get setting value by key, optionally providing a default.
     * Uses simple caching per request to avoid multiple DB hits for the same key.
     */
    public static function get($key, $default = null)
    {
        static $cache = [];
        if (array_key_exists($key, $cache)) {
            return $cache[$key];
        }

        $setting = self::where('key', $key)->first();
        $value = $setting ? $setting->value : $default;
        
        $cache[$key] = $value;
        return $value;
    }
}
