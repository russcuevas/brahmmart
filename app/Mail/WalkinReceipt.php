<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class WalkinReceipt extends Mailable
{
    use Queueable, SerializesModels;

    public $orders;
    public $customer;

    public function __construct($orders, $customer)
    {
        $this->orders = $orders;
        $this->customer = $customer;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Walk-in Order Receipt - UB-Store',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.walkin_receipt',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
