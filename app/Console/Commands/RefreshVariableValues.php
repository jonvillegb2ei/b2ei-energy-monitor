<?php

namespace App\Console\Commands;

use App\Jobs\RefreshEquipmentJob;
use App\Models\Equipment;
use Illuminate\Console\Command;
use Illuminate\Foundation\Bus\DispatchesJobs;

class RefreshVariableValues extends Command
{
    use DispatchesJobs;

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
            try {
                $this->line(sprintf('Refreshing equipment %s (%s)',$equipment->id,$equipment->name));
                $this->dispatch(new RefreshEquipmentJob($equipment));
            } catch (\Exception $error) {
                return null;
            }
        });
        return null;
    }
}
