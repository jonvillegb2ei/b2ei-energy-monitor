<?php

namespace App\Exports;

use App\Models\Variable;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class LogsSheet implements FromCollection, WithTitle, WithMapping, WithHeadings
{
    private $variable;
    private $start;
    private $end;

    public function __construct (Variable $variable, Carbon $start = null, Carbon $end = null)
    {
        $this->variable = $variable;
        $this->start = $start;
        $this->end = $end;
    }

    public function collection()
    {
        $builder = $this->variable->logs()->orderBy('created_at','ASC');
        if ($this->start) $builder = $builder->whereDate('created_at', '>=', $this->start);
        if ($this->end) $builder = $builder->whereDate('created_at', '<=', $this->end);
        return $builder->get();
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return $this->variable->printable_name;
    }

    public function headings(): array
    {
        return [
            '#',
            'Value',
            'Unite',
            'Full value',
            'Date',
        ];
    }

    /**
     * @var Log $log
     * @return array
     */
    public function map($log): array
    {
        return [
            $log->id,
            $log->value,
            $this->variable->unite,
            $this->variable->printable_value,
            $log->created_at->format('Y/m/d H:i:s'),
        ];
    }
}