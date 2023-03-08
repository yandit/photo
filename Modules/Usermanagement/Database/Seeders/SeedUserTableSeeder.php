<?php

namespace Modules\UserManagement\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Cartalyst\Sentinel\Native\Facades\Sentinel;

class SeedUserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $credentials = [
            'email'    => 'wayanyuditya@gmail.com',
            'password' => 'password',
            'name' => 'Super Admin',
        ];

        $user = Sentinel::register($credentials, true);
        $role = Sentinel::findRoleBySlug('superadmin');
        $role->users()->attach($user);
        
        $user->permissions = [
            'user.create' => true,
            'user.delete' => false,
        ];
        
        $user->save();
    }
}
