<?php

namespace App\Jobs;

use App\Exceptions\RefreshEquipmentVariablesException;
use App\Models\Equipment;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class RefreshEquipmentJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    /**
     * @var Equipment
     */
    public $equipment;

    /**
     * Create a new job instance.
     *
     * @param Equipment $equipment
     */
    public function __construct(Equipment $equipment)
    {
        $this->equipment = $equipment;
    }

    /**
     * Execute the job.
     * @return void
     * @throws RefreshEquipmentVariablesException
     */
    public function handle()
    {
        if (!$this->equipment->refresh())
            throw (new RefreshEquipmentVariablesException());
    }

    /**
     * The job failed to process.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function failed(\Exception $exception)
    {

    }

}
