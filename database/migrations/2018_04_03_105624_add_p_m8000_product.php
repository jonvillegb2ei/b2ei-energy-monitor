<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPM8000Product extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        DB::table('products')->insert([
            'code' => 'SchneiderElectricPM8000',
            'brand' => 'Schneider Electric',
            'reference' => 'PM8000',
            'class_name' => Product\SchneiderElectric\PM8000\Equipment::class,
            'version' => 0,
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
