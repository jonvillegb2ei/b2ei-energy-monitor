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
        return [
            'labels' => ["January", "February", "March", "April", "May", "June", "July"],
            'series' => ['Series A', 'Series B'],
            'chart_data' => [
                [65, 59, 80, 81, 56, 55, 40],
                [28, 48, 40, 19, 86, 27, 90]
            ]
        ];
    }

}
