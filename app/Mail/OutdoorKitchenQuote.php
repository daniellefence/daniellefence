<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

/**
 * Mailable class for outdoor kitchen quote request notifications.
 *
 * This class handles email notifications sent when customers submit outdoor kitchen
 * quote requests. It includes customer information, kitchen specifications, and any
 * uploaded attachments to help the sales team provide accurate outdoor kitchen quotes.
 *
 * @package App\Mail
 * @author Shane Barron
 */
class OutdoorKitchenQuote extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new outdoor kitchen quote email instance.
     *
     * @param \App\Models\QuoteRequest $model The quote request model containing customer data and kitchen specs
     */
    public function __construct(public $model)
    {
        //
    }

    /**
     * Get the message envelope with sender and subject information.
     *
     * Configures the email envelope with the company's from address and
     * a clear subject line indicating this is an outdoor kitchen quote request.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address(setting()->get('from_email'), setting()->get('app_title')),
            subject: 'Outdoor Kitchen Quote Request',
        );
    }

    /**
     * Get the message content definition.
     *
     * Specifies the Markdown template to use for rendering the email content.
     * The template displays customer information and outdoor kitchen specifications.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.outdoor-kitchens-quote-request',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * Retrieves any files uploaded by the customer with their outdoor kitchen quote request,
     * such as property photos, design inspiration images, or space measurements that help
     * provide context for accurate outdoor kitchen quote preparation.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        $attachments = [];

        // Include any files uploaded by the customer
        if ($this->model->attachments->count() > 0) {
            foreach ($this->model->attachments as $attachment) {
                $attachments[] = Attachment::fromStorage($attachment->path);
            }
        }

        return $attachments;
    }
}
