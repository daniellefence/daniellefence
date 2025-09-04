<?php

namespace App\Services;

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Cache;

class NotificationService
{
    /**
     * Send DIY order notifications to staff
     *
     * @param \App\Models\DIYOrder $order
     * @param string $mailClass
     * @return bool
     */
    public function sendDIYOrderNotifications($order, $mailClass)
    {
        $staffEmails = config('notifications.staff_emails.diy_orders', []);
        
        if (empty($staffEmails)) {
            Log::error('No staff emails configured for DIY order notifications');
            return false;
        }

        $successCount = 0;
        $errors = [];

        foreach ($staffEmails as $email) {
            try {
                if (config('notifications.should_queue', true)) {
                    Mail::to($email)->queue(new $mailClass($order));
                } else {
                    Mail::to($email)->send(new $mailClass($order));
                }
                $successCount++;
            } catch (\Exception $e) {
                $errors[] = "Failed to send to {$email}: " . $e->getMessage();
                Log::error("Notification failed", [
                    'email' => $email,
                    'order' => $order->order_number,
                    'error' => $e->getMessage()
                ]);
            }
        }

        // Log notification results
        Log::info('DIY Order notifications sent', [
            'order_number' => $order->order_number,
            'success_count' => $successCount,
            'total_recipients' => count($staffEmails),
            'errors' => $errors
        ]);

        return $successCount > 0;
    }

    /**
     * Send customer confirmation email
     *
     * @param \App\Models\DIYOrder $order
     * @param string $mailClass
     * @return bool
     */
    public function sendCustomerConfirmation($order, $mailClass)
    {
        try {
            $customerEmail = $order->customer_email;
            
            if (config('notifications.should_queue', true)) {
                Mail::to($customerEmail)->queue(new $mailClass($order));
            } else {
                Mail::to($customerEmail)->send(new $mailClass($order));
            }

            Log::info('Customer confirmation sent', [
                'order_number' => $order->order_number,
                'customer_email' => $customerEmail
            ]);

            return true;
        } catch (\Exception $e) {
            Log::error('Customer confirmation failed', [
                'order_number' => $order->order_number,
                'error' => $e->getMessage()
            ]);
            return false;
        }
    }

    /**
     * Check rate limit for notifications
     *
     * @param string $type
     * @param string $identifier
     * @return bool
     */
    public function checkRateLimit($type, $identifier)
    {
        $key = "notification_limit:{$type}:{$identifier}";
        $limit = config("notifications.rate_limits.{$type}", 10);
        
        return RateLimiter::tooManyAttempts($key, $limit) === false;
    }

    /**
     * Increment rate limit counter
     *
     * @param string $type
     * @param string $identifier
     * @return void
     */
    public function incrementRateLimit($type, $identifier)
    {
        $key = "notification_limit:{$type}:{$identifier}";
        RateLimiter::hit($key, 3600); // 1 hour window
    }

    /**
     * Get notification statistics
     *
     * @param string $type
     * @param int $hours
     * @return array
     */
    public function getNotificationStats($type, $hours = 24)
    {
        $cacheKey = "notification_stats:{$type}:" . now()->format('Y-m-d-H');
        
        return Cache::remember($cacheKey, 3600, function () use ($type, $hours) {
            // In a real implementation, this would query a notifications table
            return [
                'sent_count' => 0,
                'failed_count' => 0,
                'success_rate' => 100,
                'last_sent' => null
            ];
        });
    }

    /**
     * Send quote request notifications
     *
     * @param array $data
     * @return bool
     */
    public function sendQuoteRequestNotifications($data)
    {
        $staffEmails = config('notifications.staff_emails.quote_requests', []);
        
        if (empty($staffEmails)) {
            Log::error('No staff emails configured for quote request notifications');
            return false;
        }

        $successCount = 0;
        
        foreach ($staffEmails as $email) {
            try {
                // This would use a QuoteRequestNotification mailable
                // Mail::to($email)->send(new QuoteRequestNotification($data));
                $successCount++;
            } catch (\Exception $e) {
                Log::error("Quote request notification failed", [
                    'email' => $email,
                    'error' => $e->getMessage()
                ]);
            }
        }

        return $successCount > 0;
    }
}