<?php

namespace App\Providers;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;
use Laravel\Sanctum\PersonalAccessToken;
use Laravel\Sanctum\Sanctum;

class AppServiceProvider extends ServiceProvider
{
  /**
   * Register any application services.
   */
  public function register(): void
  {
    //
  }

  /**
   * Bootstrap any application services.
   */
  public function boot(): void
  {
    //Para ahorar memoria con grandes consultas
    DB::connection()->disableQueryLog();

    //Detectar problema N+1 y detectar campos que falten en el $fillable
    Model::preventLazyLoading(!$this->app->isProduction());
    Model::preventSilentlyDiscardingAttributes(!$this->app->isProduction());

    //Formato fecha español
    Carbon::setLocale(config('app.locale'));
    setlocale(LC_TIME, 'es_ES');

    //Expirar la sessión en 30 minutos
    Sanctum::authenticateAccessTokensUsing(
      static function (PersonalAccessToken $accessToken, bool $isValid): bool {
        $minutes = 30;
        if (!$accessToken->can('read:limited'))
          return $isValid;

        return (!$accessToken->last_used_at)
          ? $isValid && $accessToken->created_at->gt(now()->subMinutes($minutes))
          : $isValid && $accessToken->last_used_at->gt(now()->subMinutes($minutes));
      }
    );

    //Migrations separado por carpetas
    $migrationsPath = database_path('migrations');
    $directories    = glob($migrationsPath . '/*', GLOB_ONLYDIR);
    $paths          = array_merge([$migrationsPath], $directories);
    $this->loadMigrationsFrom($paths);
  }
}
