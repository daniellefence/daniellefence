<?php

namespace App\Filament\Resources\BlogResource\Pages;

use App\Filament\Resources\BlogResource;
use App\Services\AIContentService;
use Filament\Actions;
use Filament\Forms;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;

class CreateBlog extends CreateRecord
{
    protected static string $resource = BlogResource::class;
    
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['author_id'] = auth()->id();
        
        return $data;
    }

    public function getTitle(): string 
    {
        return 'Create New Blog Post';
    }

    public function getSubheading(): string
    {
        return 'Create engaging blog content with rich text, images, and proper SEO. Use AI to generate complete blog posts or write manually.';
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('generate_ai_blog')
                ->label('Generate with AI')
                ->icon('heroicon-o-sparkles')
                ->color('warning')
                ->form([
                    Forms\Components\TextInput::make('topic')
                        ->label('Blog Topic')
                        ->placeholder('Enter a custom topic or leave blank for AI to choose')
                        ->helperText('Describe the topic you want the blog post to cover, or leave empty for AI to choose randomly'),
                    
                    Forms\Components\Select::make('style')
                        ->label('Writing Style')
                        ->options([
                            'informative' => 'Informative & Educational',
                            'promotional' => 'Promotional & Sales-Focused', 
                            'how-to' => 'Step-by-Step Guide',
                            'comparison' => 'Comparison & Analysis',
                        ])
                        ->default('informative')
                        ->helperText('Choose the tone and style for your blog post'),
                        
                    Forms\Components\Select::make('length')
                        ->label('Content Length')
                        ->options([
                            'short' => 'Short (800-1200 words)',
                            'medium' => 'Medium (1200-1800 words)',
                            'long' => 'Long (1800-2500 words)',
                        ])
                        ->default('medium')
                        ->helperText('Longer posts tend to rank better in search engines'),
                ])
                ->action(function (array $data) {
                    $service = app(AIContentService::class);
                    $result = $service->generateBlogPost($data);
                    
                    if ($result['success']) {
                        // Update the form data directly
                        $this->data = array_merge($this->data, [
                            'title' => $result['title'],
                            'slug' => $result['slug'],
                            'excerpt' => $result['excerpt'],
                            'content' => $result['content'],
                            'author_id' => auth()->id(),
                            'published' => false, // Keep as draft initially
                        ]);
                        
                        // Refresh the form to show the new data
                        $this->form->fill($this->data);
                        
                        Notification::make()
                            ->title('AI Blog Post Generated!')
                            ->body('Your blog post has been generated successfully. Review and edit as needed before publishing.')
                            ->success()
                            ->send();
                    } else {
                        Notification::make()
                            ->title('Failed to Generate Blog Post')
                            ->body($result['message'])
                            ->danger()
                            ->send();
                    }
                })
                ->modalHeading('Generate Blog Post with AI')
                ->modalDescription('AI will create a complete, high-quality blog post about fencing topics tailored for Danielle Fence. The content will be informative, SEO-friendly, and professionally written.')
                ->modalSubmitActionLabel('Generate Blog Post')
                ->modalWidth('lg'),
        ];
    }
}