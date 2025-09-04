<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\Contact;
use App\Models\QuoteRequest;
use App\Models\Product;
use App\Models\Category;
use App\Models\Modifier;
use App\Models\Attachment;
use Spatie\Tags\Tag;
use App\Policies\ContactPolicy;
use App\Policies\QuoteRequestPolicy;
use App\Policies\ProductPolicy;
use App\Policies\CategoryPolicy;
use App\Policies\ModifierPolicy;
use App\Policies\AttachmentPolicy;
use App\Policies\TagPolicy;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Contact::class => ContactPolicy::class,
        QuoteRequest::class => QuoteRequestPolicy::class,
        Product::class => ProductPolicy::class,
        Category::class => CategoryPolicy::class,
        Modifier::class => ModifierPolicy::class,
        Attachment::class => AttachmentPolicy::class,
        Tag::class => TagPolicy::class,
    ];

    public function boot(): void
    {
        $this->registerPolicies();

        Gate::define('viewPulse', function ($user) {
            return $user->can('view_pulse');
        });
    }
}
