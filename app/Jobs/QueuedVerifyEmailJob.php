<?php

namespace App\Jobs;

use App\Models\User;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class QueuedVerifyEmailJob implements ShouldQueue
{
  use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


  /**
   * Create a new job instance.
   */
  public function __construct(protected User $user)
  {
    //
  }

  /**
   * Execute the job.
   */
  public function handle(): void
  {
    //This queued job sends
    //Illuminate\Auth\Notifications\VerifyEmail verification
    //to the user by triggering the notification
    $this->user->notify(new VerifyEmail);
  }
}
