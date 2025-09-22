# Instructions for Claude Code

## When Working on This Project

### Before Making Any Changes
1. Read `/.claude/project_notes.md` for critical component information
2. Check `/.claude/fixes_applied.json` for recent fixes that shouldn't be reverted
3. Review `/TRIX_EDITOR_DOCUMENTATION.md` if working with rich text editors

### Trix Editor - CRITICAL
**⚠️ DO NOT MODIFY without understanding the issue**

The Trix editor component has been specifically modified to work with Livewire.
- **File**: `/resources/views/components/input/trix.blade.php`
- **Key Change**: Removed @once directive (this MUST stay removed)
- **Why**: @once breaks Trix when navigating via Livewire

### If You Need to Modify Trix Component
1. NEVER add @once or @endonce directives
2. NEVER use lazy loading on components containing Trix
3. ALWAYS test on both create AND edit pages
4. ALWAYS run `php artisan view:clear` after changes

### Common Tasks

#### Adding a New Rich Text Field
```blade
<x-input.trix 
    label="Field Label" 
    wire:model="modelProperty"
/>
```

#### Debugging Trix Issues
1. Check browser console for JavaScript errors
2. Verify Trix CSS and JS are loaded (check page source)
3. Ensure wire:ignore is present on container
4. Clear view cache: `php artisan view:clear`

### Project Structure
- **Blade Components**: `/resources/views/components/`
- **Livewire Components**: `/resources/views/livewire/`
- **Admin Pages**: `/resources/views/pages/admin/`
- **Routes**: `/routes/web.php`
- **Controllers**: `/app/Http/Controllers/`

### Testing URLs
- Homepage: `https://newdaniellefence.test`
- Admin Blog List: `https://newdaniellefence.test/admin/blog`
- Create Blog: `https://newdaniellefence.test/admin/blog/create`
- Edit Blog: `https://newdaniellefence.test/admin/blog/update/{id}`

### Environment
- Laravel with Livewire
- Local server: Laravel Herd
- Database: MySQL/SQLite
- Frontend: Tailwind CSS + Alpine.js

### Important Commands
```bash
# After modifying Blade files
php artisan view:clear

# After modifying configs
php artisan config:clear

# Full cache clear
php artisan cache:clear
php artisan view:clear
php artisan config:clear
```

### Version Control
When committing changes related to Trix:
1. Update `/.claude/fixes_applied.json`
2. Document in commit message: "Fixed: [issue]"
3. Test both create and edit functionality

## Contact for Questions
If you encounter issues with Trix editor specifically:
1. Check `/TRIX_EDITOR_DOCUMENTATION.md`
2. Review `/.claude/fixes_applied.json` for history
3. Test in browser console for JavaScript errors
