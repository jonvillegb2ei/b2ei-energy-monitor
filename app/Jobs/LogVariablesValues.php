<?php

namespace App\Jobs;

use App\Exceptions\LogVariablesValuesException;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\DB;

class LogVariablesValues implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Execute the job.
     * @return void
     * @throws LogVariablesValuesException
     */
    public function handle()
    {
        $return =
            DB::statement('INSERT INTO `logs` (`id`, `variable_id`, `value`, `created_at`) SELECT NULL, `id`, `value`, NOW() FROM `variables` WHERE `id` NOT IN (SELECT `logs`.`variable_id` FROM `logs` WHERE UNIX_TIMESTAMP(`logs`.`created_at`)  >  (UNIX_TIMESTAMP(NOW()) - (`variables`.`log_interval` * 60)))')
                and
            DB::statement('DELETE `logs` FROM `logs` INNER JOIN `variables` ON `variables`.`id` = `logs`.`variable_id` WHERE `variables`.`log_expiration` > 0 AND UNIX_TIMESTAMP(NOW()) - UNIX_TIMESTAMP(`logs`.`created_at`) > `variables`.`log_expiration`');

        if (!$return)
            throw (new LogVariablesValuesException());
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
