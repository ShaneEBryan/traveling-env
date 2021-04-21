<?php

namespace ShaneEBryan\TravelingEnv\Tests;

use ShaneEBryan\TravelingEnv\TravelingEnvServiceProivder;

class TestCase extends \Orchestra\Testbench\TestCase
{
  public function setUp(): void
  {
    parent::setUp();
    // additional setup
  }

  protected function getPackageProviders($app)
  {
    return [
      TravelingEnvServiceProivder::class,
    ];
  }

  protected function getEnvironmentSetUp($app)
  {
    // perform environment setup
  }
}
