<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVariablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('variables', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('equipment_id')->unsigned();
            $table->string('name');
            $table->decimal('value', 16, 4)->default(0);
            $table->string('unit');
            $table->integer('log_expiration')->default(0);
            $table->integer('log_interval')->default(1);
            $table->enum('type', ['boolean', 'float', 'int'])->default('float');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('variables');
    }
}
