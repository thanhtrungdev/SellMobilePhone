<?php

use App\Role;
use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //factory(App\Role::class, 10)->create();

        Role::insert([
            ['name' => 'Admin'],
            ['name' => 'User'],
        ]);
    }
}
