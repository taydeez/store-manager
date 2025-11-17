<?php

namespace App\Mail;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class WeeklyBooksStockReportMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $books;

    /**
     * Create a new message instance.
     */
    public function __construct($books)
    {
        $this->books = $books;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Weekly Books Stock Report',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mails.reports.weekly_books',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        $pdf = Pdf::loadView('pdf.weekly_books', [
            'books' => $this->books
        ])->output();

        return [
            \Illuminate\Mail\Mailables\Attachment::fromData(
                fn() => $pdf,
                'weekly_books_report.pdf'
            )->withMime('application/pdf')
        ];
    }
}
