<?php

namespace App\Http\Controllers;

use App\Exports\LogsExport;
use App\Http\Requests\LogsExportRequest;
use App\Models\Variable;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Product\SchneiderElectric\LV434000\Equipment;

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
     * @param Equipment $equipment
     *
     * @return \Illuminate\Http\Response
     */
    public function equipment(Equipment $equipment)
    {
        return response()
            ->view('app.equipment', ['equipment'=>$equipment]);
    }

    public function export(LogsExportRequest $request)
    {
        $variables = Variable::whereIn('id', $request->input('variables'))->get();
        return Excel::download(new LogsExport($variables), 'export.xlsx');
    }

}
