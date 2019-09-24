<?php

use App\Brand;
use Illuminate\Database\Seeder;

class BrandsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //factory(App\Brand::class, 10)->create();
        Brand::insert([
            ['name' => 'Samsung'],
            ['name' => 'iPhone'],
            ['name' => 'Vsmart'],
            ['name' => 'Xiaomi'],
            ['name' => 'N/A'],
        ]);
    }
}
