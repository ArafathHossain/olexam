<?php

use App\Models\HomePage;
use App\Models\Setting;
use Carbon\Carbon;

function limit_string($txt, $limit = 50)
{
    return strlen($txt) > $limit ? substr($txt, 0, $limit) . "..." : $txt;
}

function word_view($text)
{
    $text = str_replace('_', ' ', $text);
    $text = str_replace('-', ' ', $text);
    $text = str_replace('+', ' ', $text);

    return ucwords($text);
}

function formatNumber($number, $currency = 'TK')
{
    if ($currency == 'TK') {
        return number_format($number, 0, '.', ',');
    }

    return number_format($number, 2, '.', ',');
}

function currency_type($amount, $type = "USD")
{
    return $type . ' ' . formatNumber($amount);
}

function arr_shuffle($list)
{
    if (!is_array($list)) return $list;

    $keys = array_keys($list);
    shuffle($keys);
    $random = array();
    foreach ($keys as $key)
        $random[$key] = $list[$key];

    return $random;
}

// MCQ View helper
function mcq_type_checkbox($option_id, $field_id)
{
    return 'ans_' . $option_id . '_opt_' . $field_id . '';
}

function mcq_type_other($type, $field_id)
{
    return $type . '_' . $field_id . '';
}

function footer_column()
{
    return [
        'column_two',
        'column_three',
        'column_four',
    ];
}

function subject_color()
{
    return [
        '0, 173, 182',
        '247, 179, 32',
        '241, 7, 80',
        '154, 222, 69',
        '13, 214, 234',
        '236, 80, 152',
        '37, 165, 95',
        '185, 95, 253',
        '234, 105, 13',
    ];
}

function coupon_type()
{
    return [
        'percent',
        'fixed'
    ];
}

function user_group()
{
    return [
        'exam_submit_notification',
    ];
}

function format_date_time($date, $format)
{
    return Carbon::parse($date)->format($format);
}

function site_links()
{
    return [
        '#' => '#',
        '/' => 'Home',
        '/about-us' => 'About Us',
        '/contact' => 'Contact Us',
        '/faqs' => 'Faqs',
        '/live/exam' => 'Live Exam',
        '/leadboard' => 'Leadboard',
        '/cart' => 'Cart',
        '/checkout' => 'Checkout',
        '/my-section/saved_courses' => 'Wishlist',
    ];
}

function site_setting($key, $default = null)
{
    return Setting::get($key, $default);
}

function home_page($key, $default = null)
{
    return HomePage::get($key, $default);
}

function envUpdate($key, $value)
{
    $path = base_path('.env');

    if (file_exists($path)) {

        $lines = explode("\n", file_get_contents($path));

        $settings = collect($lines)
            ->filter()
            ->transform(function ($item) {
                return explode("=", $item, 2);
            })
            ->pluck(1, 0);

        $settings[$key] = $value;

        $rebuilt = $settings->map(function ($value, $key) {
            return "$key=$value";
        })->implode("\n");

        file_put_contents($path, $rebuilt);
    }
}
