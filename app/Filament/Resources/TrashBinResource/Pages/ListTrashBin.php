<?php

namespace App\Filament\Resources\TrashBinResource\Pages;

use App\Filament\Resources\TrashBinResource;
use App\Models\Blog;
use App\Models\Product;
use App\Models\Special;
use App\Models\ServiceArea;
use App\Models\YouTubeVideo;
use App\Models\Career;
use App\Models\Contact;
use Filament\Actions;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class ListTrashBin extends ListRecords
{
    protected static string $resource = TrashBinResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('empty_trash')
                ->label('Empty All Trash')
                ->icon('heroicon-o-fire')
                ->action(function () {
                    $this->emptyAllTrash();
                })
                ->requiresConfirmation()
                ->modalHeading('Empty All Trash')
                ->modalDescription('Are you sure you want to permanently delete ALL items in the trash? This action cannot be undone.')
                ->color('danger')
                ->visible(fn (): bool => auth()->user()?->can('manage_trash') ?? false),
            Actions\Action::make('restore_all')
                ->label('Restore All')
                ->icon('heroicon-o-arrow-uturn-left')
                ->action(function () {
                    $this->restoreAllTrash();
                })
                ->requiresConfirmation()
                ->modalHeading('Restore All Items')
                ->modalDescription('Are you sure you want to restore ALL items in the trash?')
                ->color('success')
                ->visible(fn (): bool => auth()->user()?->can('manage_trash') ?? false),
        ];
    }

    public function getTabs(): array
    {
        return [
            'all' => Tab::make('All Items')
                ->icon('heroicon-o-square-3-stack-3d')
                ->modifyQueryUsing(fn (Builder $query) => $this->getAllTrashedQuery())
                ->badge($this->getTotalTrashedCount()),

            'blogs' => Tab::make('Blogs')
                ->icon('heroicon-o-document-text')
                ->modifyQueryUsing(fn (Builder $query) => Blog::query()->onlyTrashed())
                ->badge(Blog::onlyTrashed()->count()),

            'products' => Tab::make('Products')
                ->icon('heroicon-o-cube')
                ->modifyQueryUsing(fn (Builder $query) => Product::query()->onlyTrashed())
                ->badge(Product::onlyTrashed()->count()),



            'specials' => Tab::make('Specials')
                ->icon('heroicon-o-gift')
                ->modifyQueryUsing(fn (Builder $query) => Special::query()->onlyTrashed())
                ->badge(Special::onlyTrashed()->count()),

            'service_areas' => Tab::make('Service Areas')
                ->icon('heroicon-o-map-pin')
                ->modifyQueryUsing(fn (Builder $query) => ServiceArea::query()->onlyTrashed())
                ->badge(ServiceArea::onlyTrashed()->count()),

            'videos' => Tab::make('Videos')
                ->icon('heroicon-o-video-camera')
                ->modifyQueryUsing(fn (Builder $query) => YouTubeVideo::query()->onlyTrashed())
                ->badge(YouTubeVideo::onlyTrashed()->count()),


            'careers' => Tab::make('Careers')
                ->icon('heroicon-o-briefcase')
                ->modifyQueryUsing(fn (Builder $query) => Career::query()->onlyTrashed())
                ->badge(Career::onlyTrashed()->count()),

            'contacts' => Tab::make('Contacts')
                ->icon('heroicon-o-users')
                ->modifyQueryUsing(fn (Builder $query) => Contact::query()->onlyTrashed())
                ->badge(Contact::onlyTrashed()->count()),
        ];
    }

    public function getTitle(): string 
    {
        return 'Trash Bin';
    }

    public function getSubheading(): string
    {
        return 'Manage deleted items across all content types. Restore items to bring them back or permanently delete them to free up space.';
    }

    protected function getAllTrashedQuery(): Builder
    {
        // Get all trashed items from different models and union them
        $blogs = Blog::onlyTrashed()->select('id', 'title as title', 'deleted_at', 'created_at')->selectRaw("'Blog' as model_type");
        $products = Product::onlyTrashed()->select('id', 'name as title', 'deleted_at', 'created_at')->selectRaw("'Product' as model_type");
        $specials = Special::onlyTrashed()->select('id', 'title as title', 'deleted_at', 'created_at')->selectRaw("'Special' as model_type");
        $serviceAreas = ServiceArea::onlyTrashed()->select('id', 'name as title', 'deleted_at', 'created_at')->selectRaw("'ServiceArea' as model_type");
        $videos = YouTubeVideo::onlyTrashed()->select('id', 'title as title', 'deleted_at', 'created_at')->selectRaw("'YouTubeVideo' as model_type");
        $careers = Career::onlyTrashed()->select('id', 'title as title', 'deleted_at', 'created_at')->selectRaw("'Career' as model_type");
        $contacts = Contact::onlyTrashed()->select('id')->selectRaw("CONCAT(first_name, ' ', last_name) as title")->addSelect('deleted_at', 'created_at')->selectRaw("'Contact' as model_type");

        // For the "All" tab, we'll use the Blog model as base but actually show mixed results
        return Blog::query()->onlyTrashed();
    }

    protected function getTotalTrashedCount(): int
    {
        return Blog::onlyTrashed()->count() +
               Product::onlyTrashed()->count() +
               Special::onlyTrashed()->count() +
               ServiceArea::onlyTrashed()->count() +
               YouTubeVideo::onlyTrashed()->count() +
               Career::onlyTrashed()->count() +
               Contact::onlyTrashed()->count();
    }

    protected function emptyAllTrash(): void
    {
        Blog::onlyTrashed()->forceDelete();
        Product::onlyTrashed()->forceDelete();
        Special::onlyTrashed()->forceDelete();
        ServiceArea::onlyTrashed()->forceDelete();
        YouTubeVideo::onlyTrashed()->forceDelete();
        Career::onlyTrashed()->forceDelete();
        Contact::onlyTrashed()->forceDelete();
        
        $this->redirect(request()->header('Referer'));
    }

    protected function restoreAllTrash(): void
    {
        Blog::onlyTrashed()->restore();
        Product::onlyTrashed()->restore();
        Special::onlyTrashed()->restore();
        ServiceArea::onlyTrashed()->restore();
        YouTubeVideo::onlyTrashed()->restore();
        Career::onlyTrashed()->restore();
        Contact::onlyTrashed()->restore();
        
        $this->redirect(request()->header('Referer'));
    }
}