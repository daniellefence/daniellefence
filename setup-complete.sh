#!/bin/bash

echo "🚀 Completing Danielle Fence Project Setup..."

# Navigate to project directory
cd ~/Herd/daniellefence

# Install dependencies
echo "📦 Installing dependencies..."
composer install --no-interaction
npm install

# Build assets
echo "🎨 Building assets..."
npm run build

# Generate key if needed
php artisan key:generate

# Run migrations and seeders
echo "🗄️ Setting up database..."
php artisan migrate:fresh --seed

# Clear and optimize
echo "⚡ Optimizing application..."
php artisan optimize:clear
php artisan optimize
php artisan filament:cache-components

# Generate sitemap
echo "🗺️ Generating sitemap..."
php artisan sitemap:generate

# Storage link
php artisan storage:link

# Set permissions
chmod -R 775 storage bootstrap/cache

echo "✅ Project setup complete!"
echo ""
echo "🌐 Access your site at: http://daniellefence.test"
echo "🔑 Admin panel: http://daniellefence.test/admin"
echo ""
echo "Default admin credentials:"
echo "Email: admin@daniellefence.com"
echo "Password: password"
