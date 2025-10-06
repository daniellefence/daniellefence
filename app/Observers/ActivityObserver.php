<?php

namespace App\Observers;

use App\Models\Activity;
use Illuminate\Database\Eloquent\Model;

class ActivityObserver
{
    public function created(Model $model)
    {
        // Log creation activity if the model is not an Activity (to prevent infinite loop)
        if (! $model instanceof Activity) {
            activity()->create($model, 'create');
        }
    }

    public function updated(Model $model)
    {
        // Log update activity if the model is not an Activity
        if (! $model instanceof Activity) {
            activity()->create($model, 'update');
        }
    }

    public function deleted(Model $model)
    {
        // Log delete activity if the model is not an Activity
        if (! $model instanceof Activity) {
            activity()->create($model, 'delete');
        }
    }
}
