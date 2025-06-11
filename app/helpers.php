<?php

if (!function_exists('resolve_link_image')) {
    function resolve_link_image($link)
    {
        if (!empty($link->image_url)) {
            return $link->image_url;
        }
        $host = parse_url($link->url, PHP_URL_HOST);
        return "https://www.google.com/s2/favicons?sz=64&domain={$host}";
    }
}
