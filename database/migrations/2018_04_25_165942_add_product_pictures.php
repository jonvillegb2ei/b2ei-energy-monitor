<?php

use App\Models\Product;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddProductPictures extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Product::where('code', 'SchneiderElectricTRV00210')->update(['picture' => 'NSX.png']);
        Product::where('code', 'SchneiderElectricLV434000')->update(['picture' => 'LV434000.png']);
        Product::where('code', 'SchneiderElectricMTZ220H15')->update(['picture' => 'MTZ2.png']);
        Product::where('code', 'SchneiderElectricPM8000')->update(['picture' => 'PM8000.png']);
        Product::where('code', 'SchneiderElectricPM1200')->update(['picture' => 'PM1200.png']);
        Product::where('code', 'SchneiderElectricIEM3250')->update(['picture' => 'IEM3250.png']);
        Product::where('code', 'SchneiderElectricIEM3350')->update(['picture' => 'IEM3250.png']);
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
