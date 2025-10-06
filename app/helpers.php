<?php

use App\Danielle;
use App\Toast;
use App\Permission;
use App\ProductMenu;
use App\Products;
use App\Seeds;
use App\Activity;
use App\Seo;
use App\Setting;

if (! function_exists('danielle')) {
    function danielle()
    {
        return new Danielle;
    }
}
if (! function_exists('toast')) {
    function toast()
    {
        return new Toast;
    }
}
if (! function_exists('permission')) {
    function permission()
    {
        return new Permission;
    }
}
if (! function_exists('productMenu')) {
    function productMenu()
    {
        return new ProductMenu;
    }
}
if (! function_exists('products')) {
    function products()
    {
        return new Products;
    }
}
if (! function_exists('seeds')) {
    function seeds()
    {
        return new Seeds;
    }
}
if (! function_exists('activity')) {
    function activity()
    {
        return new Activity;
    }
}
if (! function_exists('seo')) {
    function seo()
    {
        return new Seo;
    }
}
if (! function_exists('setting')) {
    function setting()
    {
        return new Setting;
    }
}
