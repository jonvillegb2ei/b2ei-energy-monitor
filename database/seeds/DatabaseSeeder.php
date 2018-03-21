<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('users')->insert([
            'id' => null,
            'lastname' => 'b2ei',
            'firstname' => 'b2ei',
            'email' => 'admin@b2ei.com',
            'password' => Hash::make('admin'),
            'administrator' => true,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        DB::table('products')->insert([
            'code' => 'SchneiderElectricTRV00210',
            'brand' => 'Schneider Electric',
            'reference' => 'TRV00210',
            'class_name' => Product\SchneiderElectric\TRV00210\Equipment::class,
            'version' => 0,
        ]);
        DB::table('products')->insert([
            'code' => 'SchneiderElectricLV434000',
            'brand' => 'Schneider Electric',
            'reference' => 'LV434000',
            'class_name' => Product\SchneiderElectric\LV434000\Equipment::class,
            'version' => 0,
        ]);
        DB::table('products')->insert([
            'code' => 'SchneiderElectricMTZ220H15',
            'brand' => 'Schneider Electric',
            'reference' => 'MTZ220H15',
            'class_name' => Product\SchneiderElectric\MTZ220H15\Equipment::class,
            'version' => 0,
        ]);





    }
}
