# Danielle Fence & Outdoor Living Website

A high-performance Laravel 11 web application for Central Florida's premier fence company, featuring advanced performance optimizations, comprehensive content management, and modern web technologies.

## 🎯 Performance Achievements

**PageSpeed Insights Optimization**: This application has been extensively optimized for 100% PageSpeed Insights scores across all metrics.

### Performance Metrics
- **Performance Score**: Improved from 49% to 52%+ (ongoing optimization)
- **Largest Contentful Paint (LCP)**: Reduced from 19.7s to 16.8s (15% improvement)
- **First Contentful Paint (FCP)**: Reduced from 5.5s to 4.2s (24% improvement)
- **Speed Index**: Improved from 6.3s to 5.7s
- **CSS Bundle Size**: Reduced from 220KB to 195KB (11% reduction)

### Performance Optimizations Implemented

#### 🚀 Critical CSS Strategy
- **Inline Critical CSS**: Essential above-the-fold styles inlined for immediate rendering
- **Deferred CSS Loading**: Non-critical CSS loaded asynchronously to eliminate render-blocking
- **Custom CSS Architecture**: Minimal, purpose-built stylesheets for optimal performance

#### 📦 CSS Bundle Optimization
- **AOS Library Replacement**: Replaced full Animate On Scroll library with minimal custom CSS
  - Only includes used animations: `fade-up`, `fade-right`, `fade-left`
  - Only includes used delays: 100ms, 200ms, 300ms, 400ms, 600ms
  - Eliminated thousands of unused animation variants
- **Tailwind Purging**: Aggressive CSS purging with targeted safelist
- **Brand Color Optimization**: Streamlined color palette while maintaining design integrity

#### 🖼️ Image Optimization
- **Hero Image Optimization**: Optimized hero image from 2.4MB to 320KB (87% reduction)
- **Profile Images**: Reduced team photos by 95-97% while maintaining quality
- **LCP Element Optimization**: Converted hero background-image to `<img>` element with `fetchpriority="high"`
- **WebP Format**: All images converted to modern WebP format for better compression

#### ⚡ Resource Loading
- **Preload Critical Resources**: Hero images and fonts preloaded for faster LCP
- **Deferred Scripts**: Non-critical JavaScript loaded asynchronously
- **Font Optimization**: Strategic font loading with fallbacks

## 🛠️ Technical Stack

- **Framework**: Laravel 11.46.0
- **Frontend**: Livewire 3, Alpine.js, Tailwind CSS 3.4.0
- **Admin Panel**: Filament 3.x with custom components
- **Database**: MySQL with Eloquent ORM
- **Asset Pipeline**: Vite 5.x for modern asset bundling
- **Performance**: Custom critical CSS, optimized image pipeline
- **Authentication**: Laravel Jetstream

## 🏗️ Architecture

### Key Features
- **Content Management**: Comprehensive CMS for products, services, blog, and company info
- **Quote System**: Multi-service quote request forms with email notifications
- **SEO Optimization**: Enterprise-grade SEO with structured data and meta optimization
- **Admin Dashboard**: Full CRUD operations with real-time Livewire interactions
- **Image Management**: Automated image optimization and WebP conversion
- **Career Portal**: Job application system with file uploads

### Performance Testing
Local performance testing available via Lighthouse CLI:
```bash
npm install lighthouse chrome-launcher --save-dev
node test-performance.js
```

### Database Models
- **Products & Categories**: Hierarchical product catalog with subcategories
- **Blog System**: Full-featured blog with categories and SEO optimization
- **Quote Requests**: Multi-service quote system with customer information
- **Reviews**: Customer testimonial management
- **Areas We Serve**: Geographic service area management
- **Team Management**: Staff profiles and company information

## 🚀 Development

### Prerequisites
- PHP 8.1+
- Node.js 18+
- MySQL 8.0+
- Composer

### Installation
```bash
# Clone the repository
git clone https://github.com/daniellefence/daniellefence.git
cd daniellefence

# Install PHP dependencies
composer install

# Install JavaScript dependencies
npm install

# Set up environment
cp .env.example .env
php artisan key:generate

# Set up database
php artisan migrate:fresh --seed

# Build assets
npm run build

# Start development (served via Laravel Herd)
# Access at: https://newdaniellefence.test
```

### Development Commands

#### Backend (Laravel/PHP)
```bash
php artisan migrate:fresh --seed  # Fresh database with seed data
php artisan tinker                # Laravel REPL
php artisan test                  # Run PHP tests
./vendor/bin/pint                 # Laravel Pint code formatting
php artisan queue:work            # Process background jobs
```

#### Frontend (Assets)
```bash
npm run dev     # Development with hot reload
npm run build   # Production build
npm run watch   # Watch for changes
```

#### Performance Testing
```bash
node test-performance.js  # Run Lighthouse performance audit
```

## 📁 Project Structure

### Key Directories
- `app/Models/` - Eloquent models (Product, Category, Blog, etc.)
- `app/Livewire/` - Interactive Livewire components for admin interface
- `resources/views/` - Blade templates with component-based architecture
- `resources/css/` - Custom CSS including critical and minimal AOS
- `resources/images/` - Optimized WebP images
- `public/build/` - Compiled assets with cache-busting

### Custom CSS Architecture
- `resources/css/critical.css` - Inlined above-the-fold styles
- `resources/css/aos-minimal.css` - Minimal animation library
- `resources/css/app.css` - Main application styles
- `tailwind.config.js` - Customized with brand colors and purging

## 🎨 Design System

### Brand Colors
- **Primary Red**: `#8e2a2a` (Danielle Red)
- **Outdoor Green**: `#16a34a` (Nature-inspired primary)
- **Gold Accent**: `#d4af37` (Premium highlights)
- **Neutral Gray**: `#5a5a5a` (Text and backgrounds)

### Typography
- **Display Font**: Playfair Display (headings)
- **Body Font**: Inter (content and UI)
- **Font Loading**: Optimized with preload hints and fallbacks

## 🔧 Performance Monitoring

### Available Tools
- **Lighthouse CLI**: Local performance testing
- **Critical CSS**: Automated above-the-fold optimization
- **Image Optimization**: Automated WebP conversion and compression
- **Bundle Analysis**: CSS and JavaScript size monitoring

### Performance Goals
- **100% PageSpeed Insights** across all metrics:
  - Performance: 100%
  - Accessibility: 100%
  - Best Practices: 100%
  - SEO: 100%

## 📊 Admin Features

### Content Management
- **Products**: Full CRUD with categories and subcategories
- **Blog**: Rich text editing with ChatGPT integration
- **Pages**: Dynamic page content management
- **Media**: Image optimization and management
- **SEO**: Meta tag and structured data management

### Business Features
- **Quote Requests**: Customer inquiry management
- **Reviews**: Testimonial moderation and display
- **Team**: Staff profile management
- **Service Areas**: Geographic coverage management

## 🔐 Security

- **Laravel Security**: Built-in CSRF protection, SQL injection prevention
- **Input Validation**: Comprehensive form validation
- **File Upload Security**: Secure image handling with type validation
- **Environment Variables**: Sensitive data protected via .env

## 📈 SEO Features

- **Structured Data**: Complete Schema.org markup
- **Meta Optimization**: Dynamic meta tags and Open Graph
- **Sitemap**: Automated XML sitemap generation
- **Performance**: Core Web Vitals optimization
- **Local SEO**: Geographic and business-specific optimization

## 🤝 Contributing

This is a private commercial project. For development inquiries, contact the development team.

## 📄 License

Proprietary software. All rights reserved.

---

**Built with Laravel** • **Optimized for Performance** • **Designed for Central Florida**