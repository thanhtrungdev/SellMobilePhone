<?php

use App\Brand;
use App\Category;
use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //factory(App\Category::class, 10)->create();
        Category::insert([
            ['name' => 'Điện Thoại'],
            ['name' => 'Phụ Kiện'],
        ]);
    }
}
