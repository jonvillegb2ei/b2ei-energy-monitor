<?php

namespace App\Jobs;

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
     *
     * @return void
     */
    public function handle()
    {
        $this->equipment->refresh();
    }
}
