<?php

namespace ShaneEBryan\TravelingEnv\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class PublishEnvSeed extends Command
{
  /**
   * The name and signature of the console command.
   *
   * @var string
   */
    protected $signature = 'travelingenv:publishseed {--f|force}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Publishes the environment seed file to the applications root directory';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle() {
        $this->info('Publishing environment seed file...');
        // Is the --f|force command option true?
        if ($this->forceOverwrite()) {
            // Yes. Publish .env.seed.example file from Stubs folder without prompting
            $this->publishEnvSeed();
        } else {
            // No. The --f|force command option was false.
            // Is there a .env.seed file already in the base directory?
            if (! $this->seedsExists('.env.seed')) {
                // No. Is there a .env.seed.example file in the base directory?
                if (! $this->seedsExists('env.seed.example')) {
                    // No. Publish .env.seed file from stubs directory
                    $this->publishEnvSeed();
                } else {
                    // Yes, there is a .env.seed.example file in the base directory
                    // Should we use it?
                    if ($this->shouldUsePublishedExampleEnvSeed()) {
                        // Yes. Copy .env.seed.example file in base direcory to .env.seed
                        $this->publishEnvSeed(true);
                    } else {
                        // No. Publish .env.seed file from stubs directory
                        $this->publishEnvSeed();
                    }
                }
            } else {
                // Yes, there is a .env.seed file already in the base directory
                // Should we overwrite it?
                if ($this->shouldOverwriteEnvSeed()) {
                    $this->info('Overwriting environment seed file...');
                    // Yes. Is there a .env.seed.example file in the base directory?
                    if ($this->seedsExists('.env.seed.example')) {
                        // Yes. Should we use it?
                        if ($this->shouldUsePublishedExampleEnvSeed()) {
                            // Yes. Copy .env.seed.example file in base direcory to .env.seed
                            $this->publishEnvSeed(true);
                        } else {
                          // No. Publish .env.seed file from stubs directory
                          $this->publishEnvSeed();
                        }
                    } else {
                        // No. There is not a .env.seed.example file in base directory
                        // Publish .env.seed file from stubs directory
                        $this->publishEnvSeed();
                    }
                } else {
                    // No. The user does not want to overwrite the current file.
                    // Nothing left to do. Return to CLI
                    $this->info('Existing environment seed file was not overwritten');
                    return;
                }
            }
        }

        $this->info('Published environment seed file');
    }

    /**
     * Determines if the $fileName exists in the base directory
     *
     * @param  $fileName
     * @return bool
     */
    private function seedsExists($fileName) {
        return File::exists(base_path($fileName));
    }

    /**
     * Prompts user if its okay to overwrite existing file
     *
     * @return bool
     */
    private function shouldOverwriteEnvSeed() {
        return $this->confirm(
            'Environment seed file already exists. Do you want to overwrite it?'
        );
    }

    /**
     * Prompts user if its okay to use custom example env seed file
     *
     * @return bool
     */
    private function shouldUsePublishedExampleEnvSeed() {
        return $this->confirm(
            'Custom example env seed file exists in base directory. Do you want to use it?'
        );
    }

    /**
     * Copies choosen env seed file to base directory
     * This will overwrite existing file in base directory
     *
     * @param $custom
     * @return void
     */
    private function publishEnvSeed($custom = false) {
        if ($custom === true) {
            File::copy(base_path('.env.seed.example'), base_path('.env.seed'));
        } else {
            File::copy(__DIR__.'/../stubs/.env.seed.example', base_path('.env.seed'));
        }
    }

    /**
     * Command option --f|force, when true will overwrite .env.seed with library's version
     * located in stubs folder as .env.seed.example
     *
     * @return bool
     */
    private function forceOverwrite() {
        $force = $this->option('force');
        return $force;
    }
}
