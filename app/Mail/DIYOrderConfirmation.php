<?php

namespace App\Mail;

use App\Models\DIYOrder;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class DIYOrderConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    public DIYOrder $order;

    /**
     * Create a new message instance.
     */
    public function __construct(DIYOrder $order)
    {
        $this->order = $order;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'DIY Order Confirmation - ' . $this->order->order_number,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.diy-order-confirmation',
            with: [
                'order' => $this->order,
                'product' => $this->order->product,
                'specifications' => $this->order->getFormattedSpecifications(),
            ],
        );
    }

    /**
     * Get the attachments for the message.
     */
    public function attachments(): array
    {
        return [];
    }
}
