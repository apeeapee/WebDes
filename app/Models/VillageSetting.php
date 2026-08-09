<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VillageSetting extends Model
{
    use HasFactory;

    protected $fillable = ['key', 'value'];

    public static function getVal($key, $default = null)
    {
        $setting = static::where('key', $key)->first();
        return ($setting && $setting->value !== null) ? $setting->value : $default;
    }

    public static function setVal($key, $value)
    {
        return static::updateOrCreate(['key' => $key], ['value' => (string) $value]);
    }
}
