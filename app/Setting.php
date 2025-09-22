<?php

namespace App;

use App\Models\GeneralSetting;

class Setting
{
    public function get($key)
    {
        try {
            if (!\Schema::hasTable('general_settings')) {
                return null;
            }
            $setting = GeneralSetting::where([[
                'key', '=', $key,
            ]])->first();
            if ($setting) {
                return $setting->value;
            }
        } catch (\Exception $e) {
            return null;
        }
    }

    public function set($key, $value, $input_type = false)
    {
        try {
            if (!\Schema::hasTable('general_settings')) {
                return false;
            }
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
        } catch (\Exception $e) {
            return false;
        }
    }
}
