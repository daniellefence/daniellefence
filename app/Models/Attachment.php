<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Attachment extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = ['attachable_type','attachable_id','disk','path','name','size','mime'];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['name','size','mime'])
            ->logOnlyDirty();
    }

    public function attachable(): MorphTo
    {
        return $this->morphTo();
    }
}
