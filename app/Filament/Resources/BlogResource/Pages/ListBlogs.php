<?php

namespace App\Filament\Resources\BlogResource\Pages;

use App\Filament\Resources\BlogResource;
use App\Models\Blog;
use Filament\Actions;
use Filament\Forms;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListBlogs extends ListRecords
{
    protected static string $resource = BlogResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Create New Blog Post')
                ->tooltip('Add a new blog post with rich content, images, and SEO optimization'),
            Actions\Action::make('create_with_ai')
                ->label('Generate with AI')
                ->icon('heroicon-o-sparkles')
                ->color('success')
                ->tooltip('Use AI to generate a blog post draft based on your specifications')
                ->form([
                    Forms\Components\TextInput::make('topic')
                        ->label('Blog Topic')
                        ->required()
                        ->placeholder('Enter the topic you want to write about...')
                        ->helperText('Describe what you want the blog post to be about'),
                    Forms\Components\Select::make('tone')
                        ->label('Writing Tone')
                        ->options([
                            'professional' => 'Professional',
                            'casual' => 'Casual & Friendly',
                            'informative' => 'Informative & Educational',
                            'persuasive' => 'Persuasive & Sales-focused',
                            'technical' => 'Technical & Expert',
                        ])
                        ->default('professional')
                        ->required()
                        ->helperText('Choose the tone and style for your blog post'),
                    Forms\Components\Select::make('length')
                        ->label('Content Length')
                        ->options([
                            'short' => 'Short (500-800 words)',
                            'medium' => 'Medium (800-1200 words)',
                            'long' => 'Long (1200-2000 words)',
                        ])
                        ->default('medium')
                        ->required()
                        ->helperText('How long should the blog post be?'),
                    Forms\Components\Textarea::make('key_points')
                        ->label('Key Points to Include')
                        ->rows(3)
                        ->placeholder('List any specific points, benefits, or topics you want included...')
                        ->helperText('Optional: Add specific points you want the AI to cover'),
                    Forms\Components\Select::make('blog_category_id')
                        ->label('Category')
                        ->relationship('category', 'name', fn (Builder $query) => $query->published())
                        ->searchable()
                        ->preload()
                        ->required()
                        ->helperText('Choose the category for this blog post'),
                ])
                ->action(function (array $data) {
                    $blog = Blog::create([
                        'title' => 'AI Generated: ' . $data['topic'],
                        'slug' => \Illuminate\Support\Str::slug('ai-generated-' . $data['topic'] . '-' . time()),
                        'excerpt' => 'AI-generated blog post about ' . $data['topic'],
                        'content' => '<div style="background: #f3f4f6; padding: 20px; border-radius: 8px; margin: 20px 0;"><h3>🤖 AI Blog Post Draft</h3><p>This blog post was generated using AI. Please edit the content to customize it for your needs.</p><p><strong>Topic:</strong> ' . $data['topic'] . '</p><p><strong>Tone:</strong> ' . $data['tone'] . '</p><p><strong>Length:</strong> ' . $data['length'] . '</p>' . (!empty($data['key_points']) ? '<p><strong>Key Points:</strong> ' . $data['key_points'] . '</p>' : '') . '<p><em>Note: Replace this placeholder content with AI-generated content or integrate with your preferred AI service.</em></p></div>',
                        'blog_category_id' => $data['blog_category_id'],
                        'author_id' => auth()->id(),
                        'published' => false,
                    ]);
                    
                    return redirect()->route('filament.admin.resources.blogs.edit', $blog);
                })
                ->modalHeading('Generate Blog Post with AI')
                ->modalDescription('Create a blog post draft using AI. You can customize and edit the content after generation.')
                ->modalWidth('lg')
                ->visible(fn (): bool => auth()->user()?->can('create_blogs') ?? false),
        ];
    }

    public function getTitle(): string 
    {
        return 'Blog Posts';
    }

    public function getSubheading(): string
    {
        return 'Manage your blog content, categories, and publishing schedule. Use filters to find specific posts and bulk actions to publish or organize content efficiently.';
    }
}