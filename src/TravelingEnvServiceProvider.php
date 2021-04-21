<?php

namespace ShaneEBryan\TravelingEnv;

use Illuminate\Support\ServiceProvider;

class TravelingEnvServiceProivder extends ServiceProvider
{
  public function register()
  {
      $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'traveling-env');

  }

  public function boot()
  {
      if ($this->app->runningInConsole()) {

          $this->publishes([
            __DIR__.'/../config/config.php' => config_path('traveling-env.php'),
          ], 'config');

      }
  }
}
