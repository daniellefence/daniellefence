<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Activity extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getMessage()
    {
        $user = $this->user;
        $model_class = $this->model_class;
        $model_id = $this->model_id;
        $action = $this->action;
        $return = [
            $user->name,
            $action,
            $model_class,
            $model_id,
        ];

        return implode(' ', $return);
    }
}
