<?php

namespace App\Jobs;

use App\Events\MinimumFreeDiskSpace;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class CheckFreeDiskSpace implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if ((disk_free_space("/") / disk_total_space("/"))  > 0.95)
            MinimumFreeDiskSpace::dispatch();
    }
}
