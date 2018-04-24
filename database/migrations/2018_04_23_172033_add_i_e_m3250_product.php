<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIEM3250Product extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        DB::table('products')->insert([
            'code' => 'SchneiderElectricIEM3250',
            'brand' => 'Schneider Electric',
            'reference' => 'IEM3250',
            'class_name' => Product\SchneiderElectric\IEM3250\Equipment::class,
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
