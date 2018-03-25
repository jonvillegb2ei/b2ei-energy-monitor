<?php

namespace App\Http\Controllers;

use App\Exports\LogsExport;
use App\Http\Requests\Equipments\ChartDataRequest;
use App\Http\Requests\Equipments\LogsExportRequest;
use App\Models\Variable;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Product\SchneiderElectric\LV434000\Equipment;
use App\Contracts\Equipment as EquipmentInterface;

class EquipmentsController extends Controller
{


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function equipments()
    {
        return response()
            ->view('app.equipments', ['equipments'=> Equipment ::all()]);
    }

    /**
     * @param EquipmentInterface $equipment
     *
     * @return \Illuminate\Http\Response
     */
    public function equipment(EquipmentInterface $equipment)
    {
        return response()
            ->view('app.equipment', ['equipment'=>$equipment]);
    }

    public function export(LogsExportRequest $request)
    {
        $startDate = $request->input('date.startDate', null);
        if ($startDate) {
            $startDate = Carbon::parse($startDate);
            if (!$startDate) $startDate = null;
        }

        $endDate = $request->input('date.endDate', null);
        if ($endDate) {
            $endDate = Carbon::parse($endDate);
            if (!$endDate) $endDate = null;
        }

        $variables = Variable::whereIn('id', $request->input('variables'))->get();
        $file = "tmp/export_".uniqid().".xlsx";
        if (Excel::store(new LogsExport($variables, $startDate, $endDate), $file, 'public'))
            return response()->json(['return'=>true, 'message' => 'File ready to download.', 'url' => url(asset("storage/".$file))]);
        else
            return response()->json(['return'=>false, 'message' => 'Error during export generation.']);
    }

    public function chart(EquipmentInterface $equipment, ChartDataRequest $request) {

        $startDate = $request->input('date.startDate', null);
        if ($startDate) {
            $startDate = Carbon::parse($startDate);
            if (!$startDate) $startDate = null;
        }

        $endDate = $request->input('date.endDate', null);
        if ($endDate) {
            $endDate = Carbon::parse($endDate);
            if (!$endDate) $endDate = null;
        }

        $return = [
            'series' => [],
            'chart_data' => []
        ];
        $equipment->variables()->whereIn('id', $request->input('variables'))->get()->each(function(Variable $variable) use (&$return, $startDate, $endDate) {
            $builder = $variable->logs()->orderBy('created_at','ASC');
            if ($startDate) $builder = $builder->whereDate('created_at', '>=', $startDate);
            if ($endDate) $builder = $builder->whereDate('created_at', '<=', $endDate);
            $data = $builder->get()->map(function($log) {
                return [
                    'x' => $log->created_at->format("D M d Y H:i:s e O T"),
                    'y' => $log->value
                ];
            });
            $return['chart_data'][] = $data;
            $return['series'][] = $variable->printable_name;
        });

        return $return;

    }

}
