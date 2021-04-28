<?php

namespace ShaneEBryan\TravelingEnv\Tests;

use Orchestra\Testbench\TestCase as BaseTestCase;
use ShaneEBryan\TravelingEnv\TravelingEnvServiceProvider;

class TestCase extends BaseTestCase
{
  protected function setUp(): void
  {
      parent::setUp();
      // additional setup
  }

  protected function getPackageProviders($app)
  {
      return [
         TravelingEnvServiceProvider::class,
      ];
  }

  protected function getEnvironmentSetUp($app)
  {
      // perform environment setup
  }

  protected function tearDown(): void
  {
      parent::teardown();

  }


}
