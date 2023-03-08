<?php

if (!function_exists('setting')) {
    function setting($key, $default = null) {
        return Modules\Setting\Facades\SettingFacade::setting($key, $default);
    }
}