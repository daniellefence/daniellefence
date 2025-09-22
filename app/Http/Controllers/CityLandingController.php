<?php

namespace App\Http\Controllers;

use App\Models\AreasWeServe;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\Response;

class CityLandingController extends Controller
{
    public function show(AreasWeServe $area): View
    {
        // Ensure the area is published
        if (!$area->published) {
            abort(404);
        }

        // Set SEO data for this city page
        $this->setSeoData($area);

        return view('pages.city-landing', compact('area'));
    }

    public function fenceInstallation(AreasWeServe $area): View
    {
        if (!$area->published) {
            abort(404);
        }

        $service = 'Fence Installation';
        $this->setSeoDataForService($area, $service);

        return view('pages.city-service', compact('area', 'service'));
    }

    public function vinylFencing(AreasWeServe $area): View
    {
        if (!$area->published) {
            abort(404);
        }

        $service = 'Vinyl Fencing';
        $this->setSeoDataForService($area, $service);

        return view('pages.city-service', compact('area', 'service'));
    }

    public function commercialFencing(AreasWeServe $area): View
    {
        if (!$area->published) {
            abort(404);
        }

        $service = 'Commercial Fencing';
        $this->setSeoDataForService($area, $service);

        return view('pages.city-service', compact('area', 'service'));
    }

    public function woodFencing(AreasWeServe $area): View
    {
        if (!$area->published) {
            abort(404);
        }

        $service = 'Wood Fencing';
        $this->setSeoDataForService($area, $service);

        return view('pages.city-service', compact('area', 'service'));
    }

    public function chainLinkFencing(AreasWeServe $area): View
    {
        if (!$area->published) {
            abort(404);
        }

        $service = 'Chain Link Fencing';
        $this->setSeoDataForService($area, $service);

        return view('pages.city-service', compact('area', 'service'));
    }

    private function setSeoData(AreasWeServe $area): void
    {
        // Set dynamic SEO data for view
        view()->share('pageTitle', $area->meta_title);
        view()->share('pageDescription', $area->meta_description);
        view()->share('pageKeywords', "fence installation, {$area->title}, Florida, fencing company, residential fencing, commercial fencing");
    }

    private function setSeoDataForService(AreasWeServe $area, string $service): void
    {
        $title = "{$service} in {$area->title}, FL | Danielle Fence";
        $description = "Professional {$service} services in {$area->title}, Florida. Licensed & insured fencing contractors. Free estimates. Commercial & residential projects.";
        $keywords = strtolower($service) . ", " . strtolower($area->title) . ", florida, fencing company, fence installation, fence contractor";

        view()->share('pageTitle', $title);
        view()->share('pageDescription', $description);
        view()->share('pageKeywords', $keywords);
    }

    public function index(): View
    {
        $areas = AreasWeServe::published()
            ->orderBy('county')
            ->orderBy('title')
            ->get()
            ->groupBy('county');

        view()->share('pageTitle', 'Service Areas | Central Florida Fence Installation | Danielle Fence');
        view()->share('pageDescription', 'Danielle Fence serves over 130 cities across Central Florida. Find your city and get a free fence installation estimate today!');
        view()->share('pageKeywords', 'central florida, fence installation, service areas, fencing company, florida counties');

        return view('pages.service-areas', compact('areas'));
    }
}
