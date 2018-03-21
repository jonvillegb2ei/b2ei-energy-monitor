<?php

namespace App\Console\Commands;

use App\Models\Equipment;
use Illuminate\Console\Command;

class RefreshVariableValues extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'variable:refresh';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        Equipment::get()->each(function ($equipment) {
            $equipment->refresh();
        });
    }
}
