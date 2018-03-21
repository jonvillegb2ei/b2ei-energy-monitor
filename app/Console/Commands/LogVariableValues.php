<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class LogVariableValues extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'variable:log';

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
        return DB::statement( 'INSERT INTO logs (`id`, `variable_id`, `value`, `created_at`) SELECT NULL, `id`, `value`, NOW() FROM variables' ) and
            DB::statement( 'DELETE `logs` FROM `logs` INNER JOIN `variables` ON `variables`.`id` = `logs`.`variable_id` WHERE `variables`.`log_expiration` > 0 AND UNIX_TIMESTAMP(NOW()) - UNIX_TIMESTAMP(`logs`.`created_at`) > `variables`.`log_expiration`' );
    }
}
