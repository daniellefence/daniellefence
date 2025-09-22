# Project Notes for Claude Code

## Project: newdaniellefence
Laravel application for Danielle Fence and Outdoor Living

## Critical Components

### Trix Editor Integration
**⚠️ IMPORTANT: Special handling required for Trix editor**

#### Known Issues Fixed
1. **Trix not loading on edit pages** (Fixed Jan 2025)
   - Root cause: @once directive + Livewire navigation
   - Solution: Removed @once directive from component
   - File: `/resources/views/components/input/trix.blade.php`

#### Key Files
- Trix Component: `/resources/views/components/input/trix.blade.php`
- Blog Create: `/resources/views/livewire/admin-blog-create.blade.php`
- Blog Update: `/resources/views/livewire/admin-blog-update.blade.php`
- Update Page: `/resources/views/pages/admin/blog/update.blade.php`

#### Rules for Trix Editor
1. **NEVER add @once directive** to Trix component
2. **NEVER use lazy loading** with Trix components
3. **ALWAYS use wire:ignore** on Trix container
4. **ALWAYS clear view cache** after changes: `php artisan view:clear`

#### Testing Requirements
When modifying anything related to Trix:
1. Test on CREATE pages (should work)
2. Test on EDIT/UPDATE pages (historically problematic)
3. Test Livewire navigation between pages
4. Verify toolbar appears
5. Verify content loads in editor

## Development Environment
- **Stack**: Laravel + Livewire
- **Local Server**: Laravel Herd
- **Path**: `/Users/shanebarron/Herd/newdaniellefence`
- **URL**: `https://newdaniellefence.test`

## Common Commands
```bash
# Clear all caches
php artisan view:clear
php artisan cache:clear
php artisan config:clear

# Clear specific to Trix issues
php artisan view:clear
```

## Architecture Notes
- Uses Livewire for reactive components
- Blade components in `/resources/views/components`
- Admin pages use `<x-admin-holder>` wrapper
- Rich text editing via Trix editor

## Known Gotchas
1. **Livewire + JavaScript Libraries**: Special care needed with initialization
2. **View Caching**: Always clear after blade changes
3. **Asset Loading**: @push directives must work with Livewire navigation

## References
- Full documentation: `/TRIX_EDITOR_DOCUMENTATION.md`
- Component notes: `/resources/views/components/input/TRIX_COMPONENT_README.md`
