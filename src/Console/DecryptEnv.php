<?php

namespace ShaneEBryan\TravelingEnv\Console;

use Illuminate\Console\Command;

class DecryptEnv extends Command
{
  /**
   * The name and signature of the console command.
   *
   * @var string
   */
    protected $signature = 'travelingenv:decrypt
                            {environment? Which environment are you decyrpting an env file for?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '';

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

    }


}