<?php

namespace App\Filament\Resources\MediaResource\Pages;

use App\Filament\Resources\MediaResource as Resource;
use Filament\Resources\Pages\CreateRecord;
use Filament\Forms;
use Filament\Forms\Form;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use Spatie\MediaLibrary\HasMedia;

class CreateMediaResource extends CreateRecord
{
    protected static string $resource = Resource::class;
    
    protected static ?string $title = 'Upload Media Files';
    
    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('File Upload')
                    ->description('Upload files to your media library. You can upload multiple files at once.')
                    ->schema([
                        Forms\Components\FileUpload::make('files')
                            ->label('Select Files')
                            ->multiple()
                            ->required()
                            ->disk('public')
                            ->directory('temp-uploads')
                            ->preserveFilenames()
                            ->acceptedFileTypes([
                                'image/*',
                                'video/*',
                                'audio/*',
                                'application/pdf',
                                'application/msword',
                                'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                                'application/vnd.ms-excel', 
                                'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                                'application/vnd.ms-powerpoint',
                                'application/vnd.openxmlformats-officedocument.presentationml.presentation',
                                'text/plain',
                                'text/csv',
                                'application/zip',
                                'application/x-rar-compressed',
                            ])
                            ->maxSize(102400) // 100MB
                            ->reorderable()
                            ->panelLayout('grid')
                            ->uploadingMessage('Uploading files...')
                            ->columnSpan('full')
                            ->helperText('Supported formats: Images, Videos, Audio, Documents (PDF, Word, Excel, PowerPoint), Text files, and Archives. Maximum file size: 100MB per file.'),
                    ])
                    ->columnSpan('full'),

                Forms\Components\Section::make('Organization')
                    ->description('Choose how to organize your uploaded files.')
                    ->schema([
                        Forms\Components\Select::make('collection_name')
                            ->label('Collection')
                            ->options([
                                'default' => 'Default',
                                'images' => 'Images',
                                'documents' => 'Documents', 
                                'videos' => 'Videos',
                                'audio' => 'Audio',
                                'archives' => 'Archives',
                                'thumbnails' => 'Thumbnails',
                                'gallery' => 'Gallery',
                                'products' => 'Product Media',
                                'blog' => 'Blog Media',
                                'downloads' => 'Downloads',
                            ])
                            ->default('default')
                            ->required()
                            ->searchable()
                            ->helperText('Files will be automatically assigned to appropriate collections based on their type, but you can override this selection.')
                            ->createOptionForm([
                                Forms\Components\TextInput::make('name')
                                    ->label('Collection Name')
                                    ->required()
                                    ->maxLength(255)
                                    ->rules(['alpha_dash'])
                                    ->helperText('Use lowercase letters, numbers, hyphens, and underscores only.'),
                            ])
                            ->createOptionUsing(function (array $data, Forms\Get $get): string {
                                return Str::slug($data['name']);
                            }),

                        Forms\Components\Toggle::make('auto_organize')
                            ->label('Auto-organize by file type')
                            ->default(true)
                            ->helperText('Automatically assign files to collections based on their MIME type (images → images, documents → documents, etc.)'),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Default Metadata')
                    ->description('Set default metadata for all uploaded files. You can edit individual files later.')
                    ->schema([
                        Forms\Components\TextInput::make('default_alt')
                            ->label('Default Alt Text')
                            ->maxLength(255)
                            ->helperText('Default alt text for images (important for accessibility and SEO)'),
                        
                        Forms\Components\Textarea::make('default_description')
                            ->label('Default Description')
                            ->rows(3)
                            ->helperText('Default description for all uploaded files'),
                            
                        Forms\Components\KeyValue::make('default_properties')
                            ->label('Default Custom Properties')
                            ->keyLabel('Property Name')
                            ->valueLabel('Property Value')
                            ->reorderable()
                            ->addActionLabel('Add Property')
                            ->helperText('Add custom metadata that will be applied to all uploaded files'),
                    ])
                    ->collapsible()
                    ->collapsed(),
            ]);
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // We don't actually create a single record but handle multiple files
        return [];
    }

    public function create(bool $another = false): void
    {
        $data = $this->form->getState();
        
        if (empty($data['files'])) {
            Notification::make()
                ->title('No files selected')
                ->body('Please select at least one file to upload.')
                ->danger()
                ->send();
            return;
        }

        $uploadedCount = 0;
        $errors = [];

        foreach ($data['files'] as $filePath) {
            try {
                $this->processUploadedFile($filePath, $data);
                $uploadedCount++;
            } catch (\Exception $e) {
                $errors[] = "Failed to process file: " . basename($filePath) . " - " . $e->getMessage();
                \Log::error('Media upload error', [
                    'file' => $filePath,
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString()
                ]);
            }
        }

        if ($uploadedCount > 0) {
            $message = $uploadedCount === 1 
                ? "Successfully uploaded 1 file to the media library."
                : "Successfully uploaded {$uploadedCount} files to the media library.";
                
            Notification::make()
                ->title('Upload Complete')
                ->body($message)
                ->success()
                ->send();
        }

        if (!empty($errors)) {
            foreach ($errors as $error) {
                Notification::make()
                    ->title('Upload Error')
                    ->body($error)
                    ->danger()
                    ->send();
            }
        }

        if ($uploadedCount > 0) {
            $this->redirect($this->getResource()::getUrl('index'));
        }
    }

    protected function processUploadedFile(string $filePath, array $formData): void
    {
        $fullPath = Storage::disk('public')->path($filePath);
        
        if (!file_exists($fullPath)) {
            throw new \Exception("File not found at path: {$fullPath}");
        }

        $originalName = pathinfo($filePath, PATHINFO_BASENAME);
        $mimeType = mime_content_type($fullPath);
        $fileSize = filesize($fullPath);
        
        // Determine collection
        $collection = $this->determineCollection($mimeType, $formData);
        
        // Generate a clean name
        $name = $this->generateMediaName($originalName);
        
        // Set custom properties
        $customProperties = $formData['default_properties'] ?? [];
        
        if (!empty($formData['default_alt'])) {
            $customProperties['alt'] = $formData['default_alt'];
        }
        
        if (!empty($formData['default_description'])) {
            $customProperties['description'] = $formData['default_description'];
        }
        
        // Add image dimensions if it's an image
        if (str_starts_with($mimeType, 'image/')) {
            $imageInfo = getimagesize($fullPath);
            if ($imageInfo) {
                $customProperties['width'] = $imageInfo[0];
                $customProperties['height'] = $imageInfo[1];
            }
        }

        // Save the file first, then save the record
        $uuid = Str::uuid();
        $mediaDir = $uuid;
        $finalPath = $mediaDir . '/' . $originalName;
        
        // Ensure the directory exists
        Storage::disk('public')->makeDirectory($mediaDir);
        
        // Move the file to the final location
        if (!Storage::disk('public')->move($filePath, $finalPath)) {
            throw new \Exception("Failed to move file to final location");
        }
        
        // Create the media record
        $media = new Media();
        $media->model_type = null; // Unattached media
        $media->model_id = null;
        $media->uuid = $uuid;
        $media->collection_name = $collection;
        $media->name = $name;
        $media->file_name = $originalName;
        $media->mime_type = $mimeType;
        $media->disk = 'public';
        $media->conversions_disk = 'public';
        $media->size = $fileSize;
        $media->custom_properties = $customProperties;
        $media->generated_conversions = [];
        $media->responsive_images = [];
        $media->order_column = (Media::max('order_column') ?? 0) + 1;
        
        $media->save();
        
        \Log::info("Created media record", [
            'id' => $media->id,
            'name' => $media->name,
            'file_name' => $media->file_name,
            'collection' => $media->collection_name,
            'final_path' => $finalPath,
            'url' => Storage::disk('public')->url($finalPath)
        ]);
    }

    protected function determineCollection(string $mimeType, array $formData): string
    {
        // If auto-organize is disabled, use the selected collection
        if (!($formData['auto_organize'] ?? true)) {
            return $formData['collection_name'] ?? 'default';
        }

        // Auto-determine based on MIME type
        return match (true) {
            str_starts_with($mimeType, 'image/') => 'images',
            str_starts_with($mimeType, 'video/') => 'videos',
            str_starts_with($mimeType, 'audio/') => 'audio',
            in_array($mimeType, [
                'application/pdf',
                'application/msword',
                'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                'application/vnd.ms-excel',
                'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                'application/vnd.ms-powerpoint',
                'application/vnd.openxmlformats-officedocument.presentationml.presentation',
                'text/plain',
                'text/csv',
            ]) => 'documents',
            in_array($mimeType, [
                'application/zip',
                'application/x-rar-compressed',
                'application/x-tar',
                'application/gzip',
            ]) => 'archives',
            default => $formData['collection_name'] ?? 'default',
        };
    }

    protected function generateMediaName(string $originalName): string
    {
        $name = pathinfo($originalName, PATHINFO_FILENAME);
        
        // Clean up the name
        $name = preg_replace('/[^a-zA-Z0-9\s\-_]/', '', $name);
        $name = preg_replace('/\s+/', ' ', $name);
        $name = trim($name);
        
        // If name is empty after cleaning, use a default
        if (empty($name)) {
            $name = 'Uploaded File';
        }
        
        return $name;
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}