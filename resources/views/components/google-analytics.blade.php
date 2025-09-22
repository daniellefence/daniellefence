@php
    try {
        if(\Schema::hasTable('general_settings') && \App\Models\GeneralSetting::where([
            ['key','=','analytics']
        ])->count() >0) {
@endphp
{!! \App\Models\GeneralSetting::where([
    ['key','=','analytics']
])->first()->value !!}
@php
        }
    } catch (\Exception $e) {
        // Silently fail if database/table doesn't exist yet
    }
@endphp
