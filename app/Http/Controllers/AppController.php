<?php

namespace App\Http\Controllers;

use App\Models\Equipment;
use Illuminate\Http\Request;

class AppController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function dashboard()
    {
        $equipments = Equipment::all();
        return response()
            ->view('app.dashboard', ['equipments' => $equipments]);
    }


}
