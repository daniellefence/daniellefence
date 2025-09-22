<?php

namespace App;

use Illuminate\Support\Facades\Auth;

class Activity
{
    public function create($model, $action)
    {
        if (Auth::check()) {
            auth()->user()->activities()->create([
                'model_id' => $model->id,
                'model_class' => get_class($model),
                'action' => $action,
            ]);
        }
    }
}
