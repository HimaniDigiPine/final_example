<?php

use App\Models\ThemeOptionFront;

if (!function_exists('theme_option')) {
    function theme_option($name, $default = null) {
        $option = \App\Models\ThemeOptionFront::where('option_name', $name)->first();
        if ($option) {
            if ($option->option_image) {
                return asset('uploads/option_image/' . $option->option_image);
            }
            return $option->option_value ?? $default;
        }
        return $default;
    }
}