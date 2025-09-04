<?php

namespace App\Jobs;

use App\Models\DIYOrder;
use App\Mail\DIYOrderConfirmation;
use App\Mail\DIYOrderNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class SendDIYOrderNotifications implements ShouldQueue
{
    use Queueable;

    public DIYOrder $order;
    
    /**
     * The number of times the job may be attempted.
     */
    public int $tries = 3;
    
    /**
     * The number of seconds to wait before retrying the job.
     */
    public int $backoff = 30;

    /**
     * Create a new job instance.
     */
    public function __construct(DIYOrder $order)
    {
        $this->order = $order;
        $this->onQueue('emails');
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            // Send customer confirmation
            Mail::to($this->order->customer_email)
                ->send(new DIYOrderConfirmation($this->order));

            // Send staff notifications
            $staffEmails = config('notifications.staff_emails.diy_orders', []);
            
            foreach ($staffEmails as $email) {
                Mail::to($email)->send(new DIYOrderNotification($this->order));
            }

            Log::info('DIY Order notifications sent successfully', [
                'order_number' => $this->order->order_number,
                'customer_email' => $this->order->customer_email,
                'staff_count' => count($staffEmails),
            ]);

        } catch (\Exception $e) {
            Log::error('DIY Order notification job failed', [
                'order_number' => $this->order->order_number,
                'error' => $e->getMessage(),
                'attempt' => $this->attempts(),
            ]);

            // Re-throw to trigger retry mechanism
            throw $e;
        }
    }

    /**
     * Handle a job failure.
     */
    public function failed(\Throwable $exception): void
    {
        Log::error('DIY Order notification job failed permanently', [
            'order_number' => $this->order->order_number,
            'error' => $exception->getMessage(),
        ]);

        // Optionally notify administrators about the failed notification
        // This could send a Slack message or create a database record
    }
}
