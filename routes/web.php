<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DIYController;
use App\Http\Controllers\PublicPagesController;
use App\Http\Controllers\QuoteRequestController;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

// Media download route - Secured with proper validation
Route::get('/media/{media}/download', function (\Spatie\MediaLibrary\MediaCollections\Models\Media $media) {
    // Check permissions
    if (!auth()->check() || !auth()->user()->can('view_media')) {
        abort(403, 'Unauthorized');
    }
    
    // Validate media exists and get secure path
    $filePath = $media->getPath();
    
    // Security check: Ensure file actually exists and is within expected directory
    if (!file_exists($filePath) || !is_readable($filePath)) {
        abort(404, 'File not found');
    }
    
    // Additional security: Check if path is within allowed storage directory
    $storagePath = storage_path('app/public');
    $realFilePath = realpath($filePath);
    $realStoragePath = realpath($storagePath);
    
    if (!$realFilePath || !$realStoragePath || !str_starts_with($realFilePath, $realStoragePath)) {
        abort(403, 'Access denied');
    }
    
    // Sanitize filename to prevent header injection
    $safeFileName = preg_replace('/[^a-zA-Z0-9\-_.]/u', '', $media->file_name);
    
    return response()->download($realFilePath, $safeFileName, [
        'Content-Type' => $media->mime_type,
        'Content-Disposition' => 'attachment; filename="' . addslashes($safeFileName) . '"',
    ]);
})->middleware(['auth', 'throttle:60,1'])->name('media.download');

// DIY Section Routes
Route::prefix('diy')->name('diy.')->group(function () {
    Route::get('/', [DIYController::class, 'index'])->name('index');
    Route::get('/products', [DIYController::class, 'products'])->name('products');
    Route::get('/product/{slug}', [DIYController::class, 'show'])->name('product');
    Route::get('/quote', [DIYController::class, 'quote'])->name('quote');
    Route::post('/quote', [DIYController::class, 'storeQuote'])->name('quote.store');
    Route::get('/order', [DIYController::class, 'orderForm'])->name('order');
    Route::post('/order', [DIYController::class, 'order'])->name('order.store');
    Route::get('/thank-you/{order}', [DIYController::class, 'thankYou'])->name('thank-you');
    Route::get('/guide/{type?}', [DIYController::class, 'guide'])->name('guide');
    Route::get('/easy-fixes', [DIYController::class, 'easyFixes'])->name('easy-fixes');
});

// Public Pages Routes
Route::get('/commercial', [PublicPagesController::class, 'commercial'])->name('commercial');
Route::get('/financing', [PublicPagesController::class, 'financing'])->name('financing');
Route::get('/fire-feature-catalogs', [PublicPagesController::class, 'fireFeatureCatalogs'])->name('fire-feature-catalogs');
Route::get('/mascots', [PublicPagesController::class, 'mascots'])->name('mascots');
Route::get('/showroom', [PublicPagesController::class, 'showroom'])->name('showroom');
Route::get('/product-warranties', [PublicPagesController::class, 'productWarranties'])->name('product-warranties');
Route::get('/why-danielle-fence', [PublicPagesController::class, 'whyDanielleFence'])->name('why-danielle-fence');

// Legal Pages Routes
Route::get('/acceptable-use', [PublicPagesController::class, 'acceptableUse'])->name('acceptable-use');
Route::get('/cookie-policy', [PublicPagesController::class, 'cookiePolicy'])->name('cookie-policy');
Route::get('/terms', [PublicPagesController::class, 'terms'])->name('terms');
Route::get('/privacy', [PublicPagesController::class, 'privacy'])->name('privacy');
Route::get('/returns', [PublicPagesController::class, 'returns'])->name('returns');
Route::get('/disclaimer', [PublicPagesController::class, 'disclaimer'])->name('disclaimer');

// Contact & Quote Routes
Route::get('/contact', [PublicPagesController::class, 'contact'])->name('contact');
Route::post('/quote-request', [QuoteRequestController::class, 'store'])->name('quote.request');
Route::get('/thanks', [PublicPagesController::class, 'thanks'])->name('thanks');

// Search Route
Route::get('/search', [PublicPagesController::class, 'search'])->name('search');
