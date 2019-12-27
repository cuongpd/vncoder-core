<?php

if (!function_exists('backend')) {
    function backend($slug = null)
    {
        if (!$slug) {
            return url('/');
        }
        $slug = str_replace('_', '-', $slug);
        $slug = str_replace('.', '/', $slug);
        return url(strtolower($slug));
    }
}

if (!function_exists('base_url')) {
    function base_url($path = '')
    {
        return BASE_URL.$path;
    }
}

if (!function_exists('filemanager')) {
    function filemanager($field_id = 'photo')
    {
        return base_url('manager/dialog.php').'?type=1&akey='.FILE_MANAGER_KEY.'&field_id='.$field_id;
    }
}