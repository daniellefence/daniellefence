<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

/**
 * Mailable class for contact form submission notifications.
 *
 * This class handles email notifications sent when customers submit general
 * contact inquiries through the website contact form. It includes customer
 * information and their message for follow-up by the sales team.
 *
 * @package App\Mail
 * @author Shane Barron
 */
class Contact extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * The contact form submission model.
     *
     * @var \App\Models\Contact
     */
    public $model;

    /**
     * Create a new contact email instance.
     *
     * @param \App\Models\Contact $model The contact submission containing customer data
     */
    public function __construct($model)
    {
        $this->model = $model;
    }

    /**
     * Get the message envelope with sender and subject information.
     *
     * Configures the email envelope with the company's from address and
     * a clear subject line indicating this is a general contact request.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address(setting()->get('from_email'), setting()->get('app_title')),
            subject: 'Contact Request',
        );
    }

    /**
     * Get the message content definition.
     *
     * Specifies the Markdown template to use for rendering the email content.
     * The template displays customer information and their inquiry message.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.contact-request',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * Contact form submissions typically do not include file attachments.
     * This method returns an empty array as contacts are text-based inquiries.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
