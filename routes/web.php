<?php

use App\Http\Controllers\ChatGPTController;
use App\Http\Controllers\CityLandingController;
use App\Http\Controllers\DeleteController;
use App\Http\Controllers\DiyController;
use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;
use Laravel\Pulse\Facades\Pulse;

// Sitemap route (outside middleware to ensure it's always accessible)
Route::get('/sitemap.xml', function () {
    $path = public_path('sitemap.xml');
    if (!file_exists($path)) {
        abort(404, 'Sitemap not found');
    }

    $content = file_get_contents($path);

    return response($content, 200, [
        'Content-Type' => 'application/xml; charset=UTF-8',
        'Cache-Control' => 'public, max-age=3600'
    ]);
})->name('sitemap');

Route::middleware(['Traffic'])->group(function () {
    Route::get('/acceptable-use', [PageController::class, 'acceptableUse'])->name('acceptable-use');
    Route::get('/about-us', [PageController::class, 'aboutUs'])->name('about-us');
    Route::get('/apply/{id?}', [PageController::class, 'apply'])->name('apply');
    Route::get('/blog', [PageController::class, 'blog'])->name('blog');
    Route::get('/blog/read/{id}', [PageController::class, 'blogRead'])->name('blog.read');
    Route::get('/career-read/{id}', [PageController::class, 'careerRead'])->name('career-read');
    Route::get('/careers', [PageController::class, 'careers'])->name('careers');
    Route::get('/chat', [PageController::class, 'chat'])->name('chat');
    Route::get('/contact', [PageController::class, 'contact'])->name('contact');
    Route::get('/cookie-policy', [PageController::class, 'cookiePolicy'])->name('cookie-policy');
    Route::get('/discounts-deals', [PageController::class, 'discountsDeals'])->name('discounts-deals');
    Route::get('/diy', [DiyController::class, 'index'])->name('diy');
    Route::get('/diy/category/{id}', [DiyController::class, 'category'])->name('diy.category');
    Route::get('/diy/product/{id}', [DiyController::class, 'product'])->name('diy.product');
    Route::get('/easy-fixes', [PageController::class, 'easyFixes'])->name('easy-fixes');
    Route::get('/faq', [PageController::class, 'faq'])->name('faq');
    Route::get('/disclaimer', [PageController::class, 'disclaimer'])->name('disclaimer');
    Route::get('/financing', [PageController::class, 'financing'])->name('financing');
    Route::get('/fire-feature-catalogs', [PageController::class, 'fireFeatureCatalogs'])->name('fire-feature-catalogs');
    Route::get('/', [PageController::class, 'home'])->name('home');
    Route::get('/mascots', [PageController::class, 'mascots'])->name('mascots');
    Route::get('/pickett-pals', [PageController::class, 'pickettPals'])->name('pickett-pals');
    Route::get('/privacy', [PageController::class, 'privacy'])->name('privacy');
    Route::get('/product-warranties', [PageController::class, 'productWarranties'])->name('product-warranties');
    Route::get('/request-a-quote', [PageController::class, 'requestAQuote'])->name('request-a-quote');
    Route::get('/reviews', [PageController::class, 'reviews'])->name('reviews');
    Route::get('/search', [PageController::class, 'search'])->name('search');
    Route::get('/showroom', [PageController::class, 'showroom'])->name('showroom');
    Route::get('/specials', [PageController::class, 'specials'])->name('specials');

    // SEO-friendly product routes
    Route::get('/fencing/{category_slug}', [PageController::class, 'categoryBySlug'])->name('category.slug');
    Route::get('/fencing/{category_slug}/{product_slug}', [PageController::class, 'productBySlug'])->name('product.slug');

    // Legacy routes for backward compatibility
    Route::get('/products/category/{category_id}/{category_title?}', [PageController::class, 'category'])->name('category');
    Route::get('/product/{product_id}/{product_title?}', [PageController::class, 'product'])->name('product');
    Route::get('/products/subcategory/{subcategory_id}/{subcategory_title?}', [PageController::class, 'subcategory'])->name('subcategory');
    Route::get('/thanks', [PageController::class, 'thanks'])->name('thanks');
    Route::get('/videos', [PageController::class, 'videos'])->name('videos');
    Route::get('/why-danielle-fence', [PageController::class, 'whyDanielleFence'])->name('why-danielle-fence');
    Route::get('/terms', [PageController::class, 'terms'])->name('terms');
    Route::get('/returns', [PageController::class, 'returns'])->name('returns');
    //    Route::get('/resources',[PageController::class,'resources'])->name('resources');

    // City Landing Pages
    Route::get('/service-areas', [CityLandingController::class, 'index'])->name('service-areas');

    // City-specific service pages
    Route::get('/fence-installation-{area}', [CityLandingController::class, 'fenceInstallation'])->name('city.fence-installation');
    Route::get('/vinyl-fencing-{area}', [CityLandingController::class, 'vinylFencing'])->name('city.vinyl-fencing');
    Route::get('/wood-fencing-{area}', [CityLandingController::class, 'woodFencing'])->name('city.wood-fencing');
    Route::get('/chain-link-fencing-{area}', [CityLandingController::class, 'chainLinkFencing'])->name('city.chain-link-fencing');
    Route::get('/commercial-fencing-{area}', [CityLandingController::class, 'commercialFencing'])->name('city.commercial-fencing');

    // General city landing page
    Route::get('/fencing-{area}', [CityLandingController::class, 'show'])->name('city.landing');
});

// API routes
Route::post('/api/chatgpt-autofill', [ChatGPTController::class, 'autofill'])->middleware('auth')->name('api.chatgpt.autofill');
Route::post('/api/chatgpt-generate', [ChatGPTController::class, 'generate'])->middleware('auth')->name('api.chatgpt.generate');

Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {
    Route::post('/delete', [DeleteController::class, 'delete'])->middleware('Delete')->name('delete');
});

Route::get('users/loginAs/{id?}', function ($id) {
    $user = \App\Models\User::findOrFail($id);
    session()->flush();
    Auth::login($user);

    return redirect(route('profile.show'));
})
    ->middleware('SuperUser')
    ->middleware('AddLoginAsToActivity')
    ->name('loginAs');

// Test route for Flare error tracking (only in development)
if (app()->environment('development', 'local')) {
    Route::get('/test-flare-error', function () {
        throw new \Exception('This is a test error for Flare integration');
    })->name('test.flare.error');
}



