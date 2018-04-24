<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPM1200Product extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('products')->insert([
            'code' => 'SchneiderElectricPM1200',
            'brand' => 'Schneider Electric',
            'reference' => 'PM1200',
            'class_name' => Product\SchneiderElectric\PM1200\Equipment::class,
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
