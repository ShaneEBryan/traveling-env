<?php

namespace ShaneEBryan\TravelingEnv;

use Illuminate\Support\ServiceProvider;
use ShaneEBryan\TravelingEnv\Console\PublishEnvSeed;

class TravelingEnvServiceProvider extends ServiceProvider
{
  public function register()
  {
      $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'traveling-env');

  }

  public function boot()
  {
      if ($this->app->runningInConsole()) {
          //Registering artisan CLI commands
          $this->commands([
              PublishEnvSeed::class,
          ]);

          $this->publishes([
            __DIR__.'/../config/config.php' => config_path('traveling-env.php'),
          ], 'config');

      }
  }
}
