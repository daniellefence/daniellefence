<?php

namespace App;

use App\Models\GeneralSetting;

class Setting
{
    public function get($key)
    {
        $setting = GeneralSetting::where([[
            'key', '=', $key,
        ]])->first();
        if ($setting) {
            return $setting->value;
        }
    }

    public function set($key, $value, $input_type = false)
    {
        $setting = GeneralSetting::where([[
            'key', '=', $key,
        ]])->first();
        if (! $setting) {
            $setting = GeneralSetting::create([
                'key' => $key,
                'value' => $value,
                'input_type' => $input_type ?? 'text',
            ]);
        }
        $setting->value = $value;
        $setting->save();
    }
}
