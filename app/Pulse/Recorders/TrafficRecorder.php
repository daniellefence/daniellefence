<?php

namespace App\Pulse\Recorders;

use Laravel\Pulse\Pulse;
use Laravel\Pulse\Contracts\Recorder;

class TrafficRecorder implements Recorder
{
    public function __construct(
        protected Pulse $pulse,
    ) {
        //
    }

    public function register(callable $record): void
    {
        $record('traffic_views', function () {
            return [
                'type' => 'counter',
                'key' => 'page_views',
                'value' => 1,
            ];
        });

        $record('traffic_routes', function () {
            $route = request()->route()?->getName() ?? request()->path();
            return [
                'type' => 'counter',
                'key' => "route:{$route}",
                'value' => 1,
            ];
        });
    }
}