<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class RefreshDirectories extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'refresh-directories';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // let's run RefreshDirectories job:
        dispatch(new \App\Jobs\RefreshDirectories());
        logger('RefreshDirectories command is running');
    }
}
