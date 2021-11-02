<?php

namespace App\Models;

use App\Helper\PhotoUploadTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class HomePage extends Model
{
    use HasFactory, PhotoUploadTrait;
    protected $guarded = [];

    /**
     * Get setting for the given key.
     *
     * @param string $key
     * @param mixed $default
     * @return string|array
     */
    public static function get($key, $default = null)
    {
        return static::where('key', $key)->first()->value ?? $default;
    }

    /**
     * Set the given setting.
     *
     * @param string $key
     * @param mixed $value
     * @return void
     */
    public static function set($key, $value)
    {
        if ($key == 'banner_photo') {
            $name = (new self)->UploadOne($value, 'images/banner', [], 'banner-photo', site_setting('banner_photo'));
            static::updateOrCreate(['key' => $key], ['value' => $name]);
        }  else {
            static::updateOrCreate(['key' => $key], ['value' => $value]);
        }
    }

    /**
     * Set the given settings.
     *
     * @param array $settings
     * @return void
     */
    public static function setMany($settings)
    {
        foreach ($settings as $key => $value) {
            self::set($key, $value);
        }
    }
}
