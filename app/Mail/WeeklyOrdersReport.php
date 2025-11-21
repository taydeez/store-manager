<?php
/*
 *
 *  * © ${YEAR} Demilade Oyewusi
 *  * Licensed under the MIT License.
 *  * See the LICENSE file for details.
 *
 */

namespace App\Mail;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class WeeklyOrdersReport extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;


    public $orders;

    /**
     * Create a new message instance.
     */
    public function __construct($orders)
    {
        $this->orders = $orders;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {


        return new Envelope(
            subject: "Weekly Orders Report",
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mails.reports.weekly_orders',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        $pdf = Pdf::loadView('pdf.weekly_orders', [
            'orders' => $this->orders
        ])->output();

        return [
            \Illuminate\Mail\Mailables\Attachment::fromData(
                fn() => $pdf,
                'weekly_orders.pdf'
            )->withMime('application/pdf')
        ];
    }
}
