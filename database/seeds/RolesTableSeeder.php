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
        if (!Role::all()->count()) {
            Role::create(['name' => 'admin',]);
            Role::create(['name' => 'user',]);
        }
    }
}
