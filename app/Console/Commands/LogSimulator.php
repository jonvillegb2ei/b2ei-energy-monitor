<?php

namespace App\Console\Commands;

use App\Models\Log;
use App\Models\Variable;
use Carbon\Carbon;
use Illuminate\Console\Command;

class LogSimulator extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'variable:simulate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate some simulated logs';

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
        Log::query()->truncate();
        $date = Carbon::now()->subDays(2);
        $lines = [];
        while(true) {
            $date->addMinutes(15);
            $this->line(sprintf('Processing date: %s (%s)', $date->format('Y/m/d H:i:s'), $date->diffForHumans()));
            if ($date->timestamp > Carbon::now()->timestamp) break;
            Variable::all()->each(function($variable) use (&$lines, $date) {
                $lines[] = ['variable_id'=>$variable->id, 'value' => rand(10000,100000) / 100, 'created_at' => $date ];
            });
            if (count($lines) > 50) {
                Log::insert($lines);
                $lines = [];
            }
        }
        if (count($lines) > 0) {
            Log::insert($lines);
        }
        return null;
    }
}
