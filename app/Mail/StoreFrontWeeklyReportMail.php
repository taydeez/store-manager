<?php

namespace App\Mail;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class StoreFrontWeeklyReportMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;


    public $storefronts;

    /**
     * Create a new message instance.
     */
    public function __construct($storefronts)
    {
        $this->storefronts = $storefronts;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Store Front Weekly Report Mail',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mails.reports.weekly_storefronts',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        $pdf = Pdf::loadView('pdf.weekly_storefront', [
            'storefronts' => $this->storefronts
        ])->output();

        return [
            \Illuminate\Mail\Mailables\Attachment::fromData(
                fn() => $pdf,
                'weekly_storefront.pdf'
            )->withMime('application/pdf')
        ];
    }
}
