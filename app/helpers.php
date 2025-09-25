<?php

if (! function_exists('danielle')) {
    function danielle()
    {
        return new \App\Danielle;
    }
}
if (! function_exists('toast')) {
    function toast()
    {
        return new \App\Toast;
    }
}
if (! function_exists('permission')) {
    function permission()
    {
        return new \App\Permission;
    }
}
if (! function_exists('productMenu')) {
    function productMenu()
    {
        return new \App\ProductMenu;
    }
}
if (! function_exists('products')) {
    function products()
    {
        return new \App\Products;
    }
}
if (! function_exists('seeds')) {
    function seeds()
    {
        return new \App\Seeds;
    }
}
if (! function_exists('activity')) {
    function activity()
    {
        return new \App\Activity;
    }
}
if (! function_exists('seo')) {
    function seo()
    {
        return new \App\Seo;
    }
}
if (! function_exists('setting')) {
    function setting()
    {
        return new \App\Setting;
    }
}