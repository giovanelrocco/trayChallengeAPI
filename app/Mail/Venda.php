<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class Venda extends Mailable
{
    use Queueable, SerializesModels;

    private $vendas;
    private $vendedor;

    /**
     * Create a new message instance.
     */
    public function __construct(array $vendas, array $vendedor)
    {
        $this->vendas = $vendas;
        $this->vendedor = $vendedor;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Vendas do dia',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            html: 'mail.vendas',
            with: [
                'vendas' => $this->vendas,
                'vendedor' => $this->vendedor['nome'],
            ],
        );
    }
}
