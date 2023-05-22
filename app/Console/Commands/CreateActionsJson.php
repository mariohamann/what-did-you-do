<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CreateActionsJson extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:create-actions-json';

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
        \App\Models\Action::createJsonFile();
    }
}
