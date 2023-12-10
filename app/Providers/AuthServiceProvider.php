<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;

use App\Mail\VerifiedMail;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        VerifyEmail::toMailUsing(function ($notifiable, $url) {
            $parseUrl = parse_url($url);
            $urlPath = str_replace('/email/verify', '', $parseUrl['path']);
            $urlPath = $urlPath . '?' . $parseUrl['query'];
            //En el frontend esta url sera redirigido al vue router que obtendra el user_id + hash
            //para que haga una petición axios pasandole su user_id + hash.
            $url = config('app.DOMAIN_FRONTEND') . "/auth/verification/email" . $urlPath . "&token=" . urlencode($notifiable->generateToken());
            return (new VerifiedMail($url))->to($notifiable->email);
        });
    }
}
