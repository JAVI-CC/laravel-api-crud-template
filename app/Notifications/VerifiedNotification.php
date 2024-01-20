<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class VerifiedNotification extends Notification implements ShouldQueue
{
  use Queueable;

  /**
   * Create a new notification instance.
   */
  public function __construct(private bool $isVerified)
  {
  }

  /**
   * Get the notification's delivery channels.
   *
   * @return array<int, string>
   */
  public function via(object $notifiable): array
  {
    return ['broadcast'];
  }

  /**
   * Get the mail representation of the notification.
   */
  public function toMail(object $notifiable): void //MailMessage
  {
    //
  }

  /**
   * Get the array representation of the notification.
   *
   * @return array<string, mixed>
   */
  public function toArray(object $notifiable): array
  {
    return [
      //
    ];
  }

  /**
   * Get the broadcastable representation of the notification.
   */
  public function toBroadcast(object $notifiable): BroadcastMessage
  {
    return new BroadcastMessage([
      'tipo' => 'verified',
      'value' => $this->isVerified,
    ]);
  }
}
