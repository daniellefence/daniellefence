# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

Danielle Fence Website - A Laravel 12 application for a family-owned fencing company established in 1976 in Central Florida. Features include a content management system with Filament admin panel, DIY product configurator, and customer management.

## Common Development Commands

### Development
```bash
# Start development server with hot reload, queue processing, and log monitoring
composer dev

# Run development server without additional services
php artisan serve

# Build frontend assets for development
npm run dev

# Build frontend assets for production
npm run build

# Run database migrations
php artisan migrate

# Seed database with demo data
php artisan db:seed

# Clear all caches
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

### Testing
```bash
# Run all tests
composer test

# Run specific test file
php artisan test tests/Feature/ExampleTest.php

# Run tests with coverage
php artisan test --coverage
```

### Code Quality
```bash
# Run Laravel Pint (PHP CS Fixer)
./vendor/bin/pint

# Check code without fixing
./vendor/bin/pint --test
```

### Custom Artisan Commands
```bash
# Ensure all site settings are properly configured
php artisan site:ensure-settings

# Warm up application caches
php artisan cache:warmup

# Sync Google reviews
php artisan sync:google-reviews

# Track visitor analytics
php artisan track:visitor-analytics
```

## Architecture & Key Components

### Database Models & Relationships

**Core Business Models:**
- `Product` → Has many `DiyAttribute`, `DiyCombination`, media attachments
- `Category/ProductCategory` → Has many `Product`
- `DiyAttribute` → Has many `DiyOption`
- `DiyOption` → Belongs to `DiyAttribute`
- `DiyCombination` → Belongs to `Product`, contains pricing modifiers
- `Review` → Customer ratings with Google integration
- `QuoteRequest` → Lead capture with product configurations
- `SiteSetting` → Global configuration with caching

### Filament Admin Resources

Admin panel at `/admin` with comprehensive CRUD interfaces:
- Product management with media gallery
- DIY configuration system
- Quote request management
- Site settings with grouped configuration
- User and permission management
- SEO settings per page

### Frontend Architecture

**Views Structure:**
```
resources/views/
├── layouts/
│   └── app.blade.php       # Main layout wrapper
├── components/
│   ├── header.blade.php    # Navigation and hero
│   └── footer.blade.php    # Site footer
├── welcome.blade.php       # Homepage
└── diy/                    # DIY section views
    ├── index.blade.php
    ├── products.blade.php
    └── quote.blade.php
```

**Asset Pipeline:**
- Vite for asset bundling
- Tailwind CSS for styling
- Alpine.js for interactivity (via Jetstream)
- Livewire for reactive components

### Key Features

**DIY Product Configurator:**
- Interactive price calculation
- Color, height, width options with modifiers
- Real-time quote generation
- Media galleries per product

**Site Settings System:**
- Cached for performance (`Cache::remember`)
- Public/private setting distinction
- Grouped settings (SEO, contact, social)
- Accessed via `SiteSetting::get('key')`

## Design System

### Color Palette
```css
/* Primary Brand Colors */
--primary-red: #832a2a;     /* Main brand color */
--success-green: #00916e;   /* Success/accent color */
--cream: #feefe5;           /* Light backgrounds */
--light-blue: #2589bd;      /* Accent blue */
--dark-green: #143109;      /* Dark accents */
--navy-blue: #23395b;       /* Navy accents */
--gold: #9b8816;           /* Warning/accent color */
```

### Logo Design
- Automobile license plate style
- Red background (#832a2a)
- White border with corner mounting holes
- "EST 1976" and "FLORIDA" text elements

## Important Patterns & Conventions

### Database Seeders
- `DatabaseSeeder` orchestrates all seeders
- `DemoDataSeeder` for development data
- Each model has dedicated seeder
- Use factories for test data generation

### Media Management
- Spatie Media Library for file handling
- Collections: 'images', 'documents', 'videos'
- Conversions for responsive images
- Secure download routes with permissions

### Caching Strategy
- Site settings cached for 24 hours
- Clear cache after settings update
- Use cache tags for granular clearing

### Security Considerations
- Never commit `.env` file
- Use environment variables for secrets
- Implement rate limiting on public forms
- Sanitize all user inputs
- Use Laravel's built-in CSRF protection

## Recent UI Updates
- Moved reviews marquee underneath hero section
- Moved "Proudly Serving These Areas" above footer
- Removed "Why Choose DIY?" section
- Removed "Start Your DIY Fence Project Today" section
- Standardized container widths to max-w-7xl
- Doubled footer height for better visual balance

## Development Workflow

1. **Always check existing patterns** before implementing new features
2. **Use Filament resources** for admin functionality
3. **Follow Laravel conventions** for controllers, models, migrations
4. **Test database changes** with seeders first
5. **Clear caches** after config or route changes
6. **Run Pint** before committing code changes