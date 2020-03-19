<?php

use App\Role;
use App\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::truncate();
        // $role_admin = Role::where('name', 'admin')->first();
        $admin_user = User::create([
            'name' => 'admin',
            'email' => 'admin@admin.com',
            'password' => bcrypt('admin')
        ]);
        $admin_user->roles()->attach(1);
        
        factory(App\User::class, 9)->create()->each(function ($user) {
            $user->roles()->attach(2);
        });
    }
}
