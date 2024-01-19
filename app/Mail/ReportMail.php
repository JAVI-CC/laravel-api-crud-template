<?php

namespace App\Mail;

use App\Models\LogError;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ReportMail extends Mailable
{
  use Queueable, SerializesModels;

  /**
   * Create a new message instance.
   */
  public function __construct(private LogError $reporte)
  {
    //
  }

  /**
   * Get the message envelope.
   */
  public function envelope(): Envelope
  {
    return new Envelope(
      subject: config('app.name') . " " . __('new report'),
    );
  }

  /**
   * Get the message content definition.
   */
  public function content(): Content
  {
    return new Content(
      view: 'emails.report',
      with: [
        'id' => $this->reporte->id,
        'mensaje' => $this->reporte->message,
        'uri' => $this->reporte->uri,
        'user' => $this->reporte->user,
        'parameters' =>  json_encode($this->reporte->request_params),
        'fecha' => $this->reporte->created_at->format('d/m/Y H:i'),
      ],
    );
  }

  /**
   * Get the attachments for the message.
   *
   * @return array<int, \Illuminate\Mail\Mailables\Attachment>
   */
  public function attachments(): array
  {
    return [];
  }
}
