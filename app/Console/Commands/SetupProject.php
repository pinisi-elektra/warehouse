<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class SetupProject extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'resync-matah:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        Artisan::call('breeze:install api');
        Artisan::call('nova:install');
        Artisan::call('telescope:install');
        Artisan::call('horizon:install');

        Artisan::call('nova:user');

        Artisan::call('migrate');
        Artisan::call('db:seed');

        $this->info('All package installed!');

        return 0;
    }
}
