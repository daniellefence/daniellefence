@php
    if(\App\Models\GeneralSetting::where([
        ['key','=','analytics']
    ])->count() >0) {
@endphp
{!! \App\Models\GeneralSetting::where([
    ['key','=','analytics']
])->first()->value !!}
@php
    }
@endphp
