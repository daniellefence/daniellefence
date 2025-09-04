<?php

namespace App\Filament\Resources\DIYOrderResource\Pages;

use App\Filament\Resources\DIYOrderResource;
use App\Mail\DIYOrderConfirmation;
use App\Mail\DIYOrderNotification;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Mail;

class ViewDIYOrder extends ViewRecord
{
    protected static string $resource = DIYOrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('resendConfirmation')
                ->label('Resend Customer Email')
                ->icon('heroicon-o-envelope')
                ->color('info')
                ->requiresConfirmation()
                ->action(function (): void {
                    try {
                        Mail::to($this->record->customer_email)
                            ->send(new DIYOrderConfirmation($this->record));
                            
                        Notification::make()
                            ->title('Email Sent')
                            ->body('Confirmation email resent to customer.')
                            ->success()
                            ->send();
                    } catch (\Exception $e) {
                        Notification::make()
                            ->title('Email Failed')
                            ->body('Failed to send confirmation email: ' . $e->getMessage())
                            ->danger()
                            ->send();
                    }
                }),

            Actions\Action::make('resendNotification')
                ->label('Resend Staff Email')
                ->icon('heroicon-o-bell')
                ->color('warning')
                ->requiresConfirmation()
                ->action(function (): void {
                    try {
                        $staffEmails = [
                            'marc@daniellefence.net',
                            'cperez@daniellefence.net',
                            'Pepe@daniellefence.net',
                            'SBarron@daniellefence.net',
                            'CDahlman@daniellefence.net',
                        ];

                        foreach ($staffEmails as $email) {
                            Mail::to($email)->send(new DIYOrderNotification($this->record));
                        }
                            
                        Notification::make()
                            ->title('Emails Sent')
                            ->body('Notification emails resent to all staff members.')
                            ->success()
                            ->send();
                    } catch (\Exception $e) {
                        Notification::make()
                            ->title('Email Failed')
                            ->body('Failed to send notification emails: ' . $e->getMessage())
                            ->danger()
                            ->send();
                    }
                }),

            Actions\Action::make('process')
                ->label('Mark as Processing')
                ->icon('heroicon-o-cog-6-tooth')
                ->color('success')
                ->visible(fn (): bool => $this->record->isPending())
                ->requiresConfirmation()
                ->action(function (): void {
                    $this->record->markAsProcessed(auth()->id());
                    
                    Notification::make()
                        ->title('Order Updated')
                        ->body('Order marked as processing.')
                        ->success()
                        ->send();
                }),

            Actions\EditAction::make(),
        ];
    }
}