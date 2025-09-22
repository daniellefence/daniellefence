# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Development Philosophy

**Test-First Approach**: Going forward, we follow a test-first development methodology. Before implementing any new features or making significant changes:
1. Write tests that define the expected behavior
2. Run tests to confirm they fail (red)
3. Implement the minimum code to make tests pass (green)
4. Refactor while keeping tests green
5. Document the implementation and testing approach

This ensures code quality, reduces bugs, and provides clear specifications for all functionality.

## Project Overview

This is a Laravel 11 application for Danielle Fence, a commercial and residential fencing company. The application uses Laravel Jetstream for authentication, Livewire for interactive components, and Tailwind CSS for styling. It's a business website with content management, product catalog, quote requests, blog, and admin functionality.

## Critical Performance Requirements

**ABSOLUTE MUSTS - Non-negotiable requirements:**

1. **Enterprise Grade SEO**: All pages must implement comprehensive, enterprise-level SEO optimization including:
   - Complete meta tags, structured data, and semantic HTML
   - Optimized page titles, descriptions, and headings
   - Proper URL structure and internal linking
   - Schema markup for business information
   - Local SEO optimization for service areas

2. **100% PageSpeed Insights Scores**: Every page must achieve 100% scores across ALL PageSpeed Insights metrics:
   - Performance: 100%
   - Accessibility: 100%
   - Best Practices: 100%
   - SEO: 100%
   - Must be maintained on both mobile and desktop
   - Zero exceptions - all pages must meet this standard

## Development Environment

**IMPORTANT: This application is hosted via Laravel Herd at https://newdaniellefence.test**
- Do NOT run `php artisan serve` - the site is already served by Herd
- Access the application at: https://newdaniellefence.test
- Admin panel: https://newdaniellefence.test/admin

## Development Commands

### Backend (Laravel/PHP)
- `php artisan migrate` - Run database migrations
- `php artisan migrate:fresh --seed` - Fresh migration with seeding (IMPORTANT: Never run just seed, always use migrate:fresh --seed)
- `php artisan tinker` - Laravel REPL
- `php artisan test` or `vendor/bin/phpunit` - Run PHP tests
- `./vendor/bin/pint` - Laravel Pint code formatting
- `php artisan queue:work` - Process background jobs

### Frontend (Vite/Node.js)
- `npm run dev` - Start Vite development server with hot reload (for asset compilation only)
- `npm run build` - Build assets for production
- `npm install` - Install JavaScript dependencies

### Testing
- Tests are located in `/tests` directory with Unit and Feature test suites
- PHPUnit configuration in `phpunit.xml`

## Architecture & Key Directories

### Core Laravel Structure
- `app/Models/` - Eloquent models for business entities (Product, Category, Blog, Contact, etc.)
- `app/Http/Controllers/` - Standard controllers (AdminController, PageController, VideoController, DeleteController)
- `app/Livewire/` - Livewire components for interactive UI (extensive admin interface components)
- `routes/web.php` - Main application routes with Traffic middleware for analytics

### Custom Application Classes
- `app/helpers.php` - Global helper functions (autoloaded via composer.json)
- `app/Danielle.php` - Main application logic class
- `app/AdminMenu.php` - Admin menu management
- `app/Permission.php` - Permission system
- `app/Toast.php` - Toast notification system
- `app/Seo.php` - SEO management
- `app/Setting.php` - Application settings

### Frontend Assets
- `resources/views/` - Blade templates
- `resources/css/app.css` - Main CSS entry point (Tailwind)
- `resources/js/app.js` - Main JavaScript entry point
- `tailwind.config.js` - Custom Tailwind configuration with brand colors ('danielle': '#8e2a2a')

### Business Logic
The application serves multiple business functions:
- Product catalog with categories and subcategories
- Quote request system for different services (fencing, outdoor kitchens, pavers, etc.)
- Blog/content management system
- Career application system
- Customer review management
- Admin dashboard with comprehensive CRUD operations

### Key Features
- Laravel Jetstream authentication with user management
- Livewire-powered admin interface with real-time interactions
- Image optimization with Vite plugin
- Custom middleware for traffic tracking
- SEO management system
- Multi-service quote request forms
- Responsive design with custom brand styling

### Database Models
Key business entities include Product, Category, Subcategory, Blog, Contact, QuoteRequest, Review, Career, User, and various content models for FAQ, documentation, and settings.

## Admin List Item Patterns

There are two types of admin list items in this application:

### 1. Simple Items (Inline Editable)
Used for simple text-based items like Areas We Serve, Blog Categories, DIY Colors, etc.
These items can be edited directly in the list using inline editing.

### 2. Complex Items (Preview/Edit Page)
Used for complex content like Blog Posts, Products, etc.
These items open a preview page when clicked, with a separate edit button that goes to a dedicated edit page.

## Inline Editing Pattern (Simple Items)

For implementing inline editing functionality in Livewire components, follow this standardized pattern:

### Livewire Component Properties
```php
public $editingId = null;
public $editingTitle = '';  // or appropriate field name
```

### Livewire Component Methods
```php
public function startEditing($itemId)
{
    $this->editingId = $itemId;
    $item = Model::find($itemId);
    $this->editingTitle = $item->title;  // or appropriate field
}

public function cancelEditing()
{
    $this->editingId = null;
    $this->editingTitle = '';
}

public function saveEdit($itemId)
{
    $this->validate([
        'editingTitle' => 'required|string|max:255'
    ]);

    $item = Model::find($itemId);
    $item->title = $this->editingTitle;  // or appropriate field
    $item->save();

    $this->editingId = null;
    $this->editingTitle = '';

    session()->flash('message', 'Item updated successfully.');
}
```

### Blade Template Pattern
```blade
<div class="flex gap-2 items-center justify-between w-full">
    @if($editingId === $item->id)
        <div class="flex items-center gap-2 flex-1">
            <div class="cursor-move" wire:sortable.handle>
                <x-icon.drag class="w-6"></x-icon.drag>
            </div>
            <input
                type="text"
                wire:model="editingTitle"
                wire:keydown.enter="saveEdit({{ $item->id }})"
                wire:keydown.escape="cancelEditing"
                class="flex-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm"
                autofocus
            >
        </div>
        <div class="flex items-center gap-2">
            <button wire:click="saveEdit({{ $item->id }})" class="...green-button...">Save</button>
            <button wire:click="cancelEditing" class="...gray-button...">Cancel</button>
        </div>
    @else
        <div class="flex items-center gap-2">
            <div class="cursor-move" wire:sortable.handle>
                <x-icon.drag class="w-6"></x-icon.drag>
            </div>
            <span class="cursor-pointer hover:text-blue-600" wire:click="startEditing({{ $item->id }})">
                {{ $item->title }}
            </span>
        </div>
        <div class="flex items-center gap-2">
            <button wire:click="startEditing({{ $item->id }})" class="text-blue-600 hover:text-blue-900 text-xs font-medium">
                Edit
            </button>
            <x-delete-button :guid="$item->id" type="itemType"></x-delete-button>
        </div>
    @endif
</div>
```

### Layout Structure
The layout uses `justify-between w-full` to create proper separation:
- **Left side**: Drag handle + content (title or input field)
- **Right side**: Action buttons (Edit/Delete or Save/Cancel)

This ensures buttons are pushed all the way to the right edge for optimal UX.

### Admin List Component Usage

The `x-admin-list-item` component supports both patterns:

#### For Simple Items (Inline Editing):
```blade
<x-admin-list-item
    :item="$category"
    :editing-id="$editingId"
    :editing-title="$editingTitle"
    :show-drag-handle="true"
    :show-edit-button="true"
    delete-type="blogCategory"
/>
```

#### For Complex Items (Preview/Edit Pages):
```blade
<x-admin-list-item
    :item="$blog"
    :link-url="route('admin.blog.preview', $blog->id)"
    delete-type="blog"
    :subtitle="'Metadata subtitle'"
>
    <x-slot name="customActions">
        <!-- Custom buttons like publish toggle -->
    </x-slot>
</x-admin-list-item>
```

### Success Message Display
```blade
@if (session()->has('message'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
        <span class="block sm:inline">{{ session('message') }}</span>
    </div>
@endif
```

**Examples implemented:** Areas We Serve (`AdminAreasWeServe.php`) and Blog Categories (`AdminBlogCategories.php`)

## Preview/Edit Pattern (Complex Items)

For complex content items that require full preview and dedicated edit pages:

### Component Implementation
```php
// In the list component (e.g., AdminBlogs.php)
public function openPreview($itemId)
{
    // Direct link to preview page
    return redirect()->route('admin.item.preview', $itemId);
}
```

### Blade Template Pattern
```blade
<x-admin-list-item
    :item="$item"
    :link-url="route('admin.item.preview', $item->id)"
    delete-type="item"
    :subtitle="'Metadata info here'"
>
    <x-slot name="customActions">
        <!-- Any custom buttons like publish toggle -->
    </x-slot>
</x-admin-list-item>
```

### Preview Page Features
- **Full content display** with proper formatting
- **Metadata information** (author, dates, categories, etc.)
- **Edit button** linking to dedicated edit page
- **View live item** link to frontend
- **Back to list** navigation

### Route Structure
```php
Route::get('/admin/item/preview/{id}', [AdminController::class, 'adminItemPreview'])->name('admin.item.preview');
Route::get('/admin/item/update/{id}', [AdminController::class, 'adminItemUpdate'])->name('admin.item.update');
```

**Examples implemented:** Blog Posts (`AdminBlogs.php` with preview page)

## ChatGPT Integration Pattern

The application includes a comprehensive ChatGPT integration for rich text editors in the Filament admin panel.

### ChatGPTRichEditor Component

Use the `ChatGPTRichEditor` component instead of the standard `RichEditor` for any content field that would benefit from AI-generated content:

```php
// In Filament Resource form schema
\App\Filament\Forms\Components\ChatGPTRichEditor::make('content')
    ->required()
    ->columnSpanFull(),
```

### Implementation Details

The ChatGPT integration consists of:

1. **Custom Form Component**: `ChatGPTRichEditor` extends Filament's `RichEditor`
2. **API Integration**: Uses OpenAI's GPT-3.5-turbo model via `/api/chatgpt-generate` endpoint
3. **JavaScript Functions**: Global functions for editor interaction and content generation
4. **Admin Panel Integration**: Scripts loaded via Filament render hooks

### File Structure

```
app/Filament/Forms/Components/ChatGPTRichEditor.php - Custom editor component
app/Http/Controllers/ChatGPTController.php - API controller
resources/views/filament/admin-scripts.blade.php - Admin panel JavaScript
resources/js/chatgpt.js - Standalone JavaScript functions
```

### Configuration

Requires `OPENAI_API_KEY` in `.env` file:
```env
OPENAI_API_KEY=sk-your-api-key-here
```

### Usage Pattern

The ChatGPT button appears above rich text editors with the following features:
- Prompts user for content description
- Generates professional content using OpenAI API
- Automatically populates the editor with formatted HTML
- Provides error handling and user feedback
- Supports multiple editor instances on the same page

### Error Handling

The integration includes comprehensive error handling:
- API key validation
- Network error handling
- Editor update fallback strategies
- User-friendly error messages

### Troubleshooting

If the ChatGPT button doesn't work:
1. Check browser console for JavaScript errors
2. Verify OPENAI_API_KEY is set in environment
3. Ensure admin-scripts.blade.php is loading properly
4. Check that the field name is being passed correctly to the JavaScript function