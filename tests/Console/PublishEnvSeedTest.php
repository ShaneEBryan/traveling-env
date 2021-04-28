<?php

namespace ShaneEBryan\TravelingEnv\Tests\Console;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use ShaneEBryan\TravelingEnv\Tests\TestCase;


class PublishEnvSeedTest extends TestCase {
  protected function setUp(): void {
    parent::setUp();
    // Clean any env seed files within laravels base path
    $this->cleanEnvSeedFiles();
  }

  protected function tearDown(): void {
    parent::tearDown();
    // Clean any env seed files within laravels base path
    $this->cleanEnvSeedFiles();
  }

  public function test_publish_env_seed_file_with_force_option_without_existing_files_in_base_path() {

    // Run Laravel artisan command with --f|force option
    Artisan::call('travelingenv:publishseed --force');

    $this->confirmEnvSeedFiles();

  }

  public function test_publish_env_seed_file_with_force_option_with_existing_files_in_base_path() {
    // Stage the test by copying the example .env.seed file into the Larvel base_path
    $this->stageEnvSeedFiles();

    // Confirm the staged .env.seed file has been placed in Larvel base_path
    $this->assertFileExists(base_path('.env.seed'),
                                      '.env.seed file was not staged for test');

    // Run Laravel artisan command with --f|force option
    Artisan::call('travelingenv:publishseed -f');

    $this->confirmEnvSeedFiles();
  }

  protected function stageEnvSeedFiles() {
    // Copy .env.seed.example from library's Stub file
    File::copy(__DIR__.'/../../src/stubs/.env.seed.example', base_path('.env.seed'));
  }

  protected function cleanEnvSeedFiles() {
    // clean up any existing env seed files in base path
    if (File::exists(base_path('.env.seed.example'))) {
      unlink(base_path('.env.seed.example'));
    }

    if (File::exists(base_path('.env.seed'))) {
      unlink(base_path('.env.seed'));
    }

    // Confirm that any existing files have been removed for tests
    $this->assertFileDoesNotExist(base_path('.env.seed.example'),
                                            '.env.seed.example file was not removed before test');
    $this->assertFileDoesNotExist(base_path('.env.seed'),
                                            '.env.seed file was not removed before test');
  }

  protected function confirmEnvSeedFiles() {
    // Confirm command was successful by determining if
    // .env.seed file now exists in base directory
    $this->assertFileExists(base_path('.env.seed'),
                                      '.env.seed file does not exist in Laravel base_path');

    // Confirm proper file was copied
    $this->assertFileEquals(__DIR__.'/../../src/stubs/.env.seed.example', base_path('.env.seed'),
                            'Proper file was not copied to Laravel base_path');
  }
}
