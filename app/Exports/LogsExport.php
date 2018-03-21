<?php

namespace App\Exports;

use App\Models\Variable;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class LogsExport implements WithMultipleSheets
{

    private $variables;
    private $start;
    private $end;

    public function __construct (Collection $variables, Carbon $start = null, Carbon $end = null)
    {
        $this->variables = $variables;
        $this->start = $start;
        $this->end = $end;
    }

    /**
     * @return array
     */
    public function sheets (): array
    {
       return $this->variables->map(function(Variable $variable) {
            return new LogsSheet($variable, $this->start, $this->end);
       })->all();
    }
}