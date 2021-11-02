<?php

namespace App\Models;

use App\Helper\PhotoUploadTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
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
        if ($key == 'logo') {
            $name = (new self)->UploadOne($value, 'images/site', [], 'logo', site_setting('logo'));
            static::updateOrCreate(['key' => $key], ['value' => $name]);
        } elseif ($key == 'footer_logo') {
            $name = (new self)->UploadOne($value, 'images/site', [], 'footer-logo', site_setting('footer_logo'));
            static::updateOrCreate(['key' => $key], ['value' => $name]);
        } elseif ($key == 'favicon') {
            $name = (new self)->UploadOne($value, 'images/site', [], 'favicon', site_setting('favicon'));
            static::updateOrCreate(['key' => $key], ['value' => $name]);
        } else {
            static::updateOrCreate(['key' => $key], ['value' => $value]);
        }
        if ($key == 'store_id') {
            envUpdate('STORE_ID', $value);
        }
        if ($key == 'store_password') {
            envUpdate('STORE_PASSWORD', $value);
        }
        if ($key == 'ssl_api_url') {
            envUpdate('API_DOMAIN_URL', $value);
        }
        if ($key == 'payment_mode') {
            if ($value == 'live') {
                envUpdate('IS_LOCALHOST', 'false');
            }else {
                envUpdate('IS_LOCALHOST', 'true'); 
            }
        }
        if ($key == 'google_id') {
            envUpdate('GOOGLE_CLIENT_ID', $value);
        }
        if ($key == 'google_key') {
            envUpdate('GOOGLE_SECRET_KEY', $value);
        }
        if ($key == 'google_redirect') {
            envUpdate('GOOGLE_REDIRECT', $value);
        }
        if ($key == 'app_name') {
            envUpdate('APP_NAME', $value);
        }
        if ($key == 'mailchimp_api') {
            envUpdate('MAILCHIMP_APIKEY', $value);
        }
        if ($key == 'mailchimp_list') {
            envUpdate('MAILCHIMP_LIST_ID', $value);
        }
        
        // mail setup
        if ($key == 'from_email') {
            envUpdate('MAIL_FROM_ADDRESS', $value);
        }
        if ($key == 'mail_mailer') {
            envUpdate('MAIL_MAILER', $value);
        }
        if ($key == 'mail_host') {
            envUpdate('MAIL_HOST', $value);
        }
        if ($key == 'mail_port') {
            envUpdate('MAIL_PORT', $value);
        }
        if ($key == 'mail_username') {
            envUpdate('MAIL_USERNAME', $value);
        }
        if ($key == 'mail_password') {
            envUpdate('MAIL_PASSWORD', $value);
        }
        if ($key == 'mail_encryption') {
            envUpdate('MAIL_ENCRYPTION', $value);
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
