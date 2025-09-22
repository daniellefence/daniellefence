<?php

namespace App;

class Toast
{
    public function success($message)
    {
        session()->flash('flash.banner', $message);
        session()->flash('flash.bannerStyle', 'success');
    }

    public function warning($message)
    {
        session()->flash('flash.banner', $message);
        session()->flash('flash.bannerStyle', 'warning');
    }
}
