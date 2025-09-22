<?php

namespace App;

class RouteList
{
    /**
     * @var Collection
     */
    private $routes;

    public function __invoke()
    {
        $this->routes = $this->generateRoutes();

        return $this->generateWebRoutes();
    }

    private function generateApiRoutes(string $version): Collection
    {
        return $this->routes->filter(function ($value, $key) use ($version) {
            return preg_match("/api\/v{$version}/i", $value['uri']);
        })
            ->values();
    }

    private function generateWebRoutes(): Collection
    {
        return $this->routes->reject(function ($value, $key) {
            return preg_match('/api/i', $value['uri'])
                || substr($value['uri'], 0, 1) === '_';
        })
            ->values();
    }

    private function generateRoutes(): Collection
    {
        Artisan::call('route:list --json --columns=method,uri,name');

        return collect(json_decode(Artisan::output(), true));
    }
}
