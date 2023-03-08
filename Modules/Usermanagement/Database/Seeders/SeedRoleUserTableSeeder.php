<?php

namespace Modules\UserManagement\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SeedRoleUserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        DB::table('roles')->insert([
            'slug' => 'superadmin',
            'name' => 'Superadmin',
            'permissions' => '{"admin.create":true,"admin.index":true,"admin.edit":true,"admin.delete":true,"role.create":true,"role.index":true,"role.edit":true,"role.delete":true,"rolemanagement.create":true,"dashboard.index":true,"master.supplier.create":true,"master.supplier.index":true,"master.supplier.edit":true,"master.supplier.destroy":true,"master.unit.create":true,"master.unit.index":true,"master.unit.edit":true,"master.unit.destroy":true,"master.category.create":true,"master.category.index":true,"master.category.edit":true,"master.category.destroy":true,"master.group.create":true,"master.group.index":true,"master.group.edit":true,"master.group.destroy":true,"master.item.create":true,"master.item.index":true,"master.item.edit":true,"master.item.destroy":true,"purchase.create":true,"purchase.index":true,"purchase.edit":true,"purchase.destroy":true,"cash.create":true,"cash.index":true,"cashier.create":true,"cashier.index":true,"cashier.show":true,"cashier.edit":true,"cashier.destroy":true,"admin.store":true,"admin.list":true,"admin.update":true,"role.store":true,"role.list":true,"role.update":true,"rolemanagement.store":true,"dashboard.list":true,"master.supplier.store":true,"master.supplier.list":true,"master.supplier.update":true,"master.unit.store":true,"master.unit.list":true,"master.unit.update":true,"master.category.store":true,"master.category.list":true,"master.category.update":true,"master.group.store":true,"master.group.list":true,"master.group.update":true,"master.item.store":true,"master.item.list":true,"master.item.update":true,"purchase.store":true,"purchase.list":true,"purchase.update":true,"cash.store":true,"cash.list":true,"cashier.store":true,"cashier.list":true,"cashier.update":true}',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);  
    }
}
