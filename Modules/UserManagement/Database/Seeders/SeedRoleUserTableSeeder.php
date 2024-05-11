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
            'permissions' => '{"admin.create":true,"admin.index":true,"admin.edit":true,"admin.delete":true,"role.create":true,"role.index":true,"role.edit":true,"role.delete":true,"rolemanagement.create":true,"setting.create":true,"setting.view":true,"setting.edit":true,"setting.delete":true,"googledrivegallery.index":true,"googledrivegallery.edit":true,"googledrivegallery.delete":true,"googledrivegallery.create":true,"googledrivecredential.index":true,"googledrivecredential.edit":true,"googledrivedisk.create":true,"googledrivedisk.index":true,"googledrivedisk.edit":true,"googledrivedisk.delete":true,"stickableframe.create":true,"stickableframe.index":true,"stickableframe.edit":true,"stickableframe.delete":true,"faq.create":true,"faq.index":true,"faq.edit":true,"faq.delete":true,"customer.create":true,"customer.index":true,"customer.edit":true,"customer.delete":true,"company.create":true,"company.index":true,"company.edit":true,"company.delete":true,"admin.store":true,"admin.list":true,"admin.update":true,"role.store":true,"role.list":true,"role.update":true,"rolemanagement.store":true,"setting.store":true,"setting.update":true,"googledrivegallery.list":true,"googledrivegallery.update":true,"googledrivegallery.store":true,"googledrivecredential.list":true,"googledrivecredential.update":true,"googledrivedisk.store":true,"googledrivedisk.list":true,"googledrivedisk.update":true,"stickableframe.store":true,"stickableframe.list":true,"stickableframe.update":true,"faq.store":true,"faq.list":true,"faq.update":true,"customer.store":true,"customer.list":true,"customer.update":true,"company.store":true,"company.list":true,"company.update":true}',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);  

        DB::table('roles')->insert([
            'slug' => 'admin',
            'name' => 'Admin',
            'permissions' => '{"setting.create":true,"setting.view":true,"setting.edit":true,"setting.delete":true,"googledrivegallery.index":true,"googledrivegallery.edit":true,"googledrivegallery.delete":true,"googledrivegallery.create":true,"googledrivedisk.create":true,"googledrivedisk.index":true,"googledrivedisk.edit":true,"googledrivedisk.delete":true,"stickableframe.create":true,"stickableframe.index":true,"stickableframe.edit":true,"stickableframe.delete":true,"faq.create":true,"faq.index":true,"faq.edit":true,"faq.delete":true,"customer.create":true,"customer.index":true,"customer.edit":true,"customer.delete":true,"company.create":true,"company.index":true,"company.edit":true,"company.delete":true,"setting.store":true,"setting.update":true,"googledrivegallery.list":true,"googledrivegallery.update":true,"googledrivegallery.store":true,"googledrivedisk.store":true,"googledrivedisk.list":true,"googledrivedisk.update":true,"stickableframe.store":true,"stickableframe.list":true,"stickableframe.update":true,"faq.store":true,"faq.list":true,"faq.update":true,"customer.store":true,"customer.list":true,"customer.update":true,"company.store":true,"company.list":true,"company.update":true}',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        DB::table('roles')->insert([
            'slug' => 'company',
            'name' => 'Company',
            'permissions' => '{"googledrivegallery.index":true,"googledrivegallery.edit":true,"googledrivegallery.delete":true,"googledrivegallery.create":true,"googledrivecredential.index":true,"googledrivecredential.edit":true,"googledrivedisk.create":true,"googledrivedisk.index":true,"googledrivedisk.edit":true,"googledrivedisk.delete":true,"customer.create":true,"customer.index":true,"customer.edit":true,"customer.delete":true,"googledrivegallery.list":true,"googledrivegallery.update":true,"googledrivegallery.store":true,"googledrivecredential.list":true,"googledrivecredential.update":true,"googledrivedisk.store":true,"googledrivedisk.list":true,"googledrivedisk.update":true,"customer.store":true,"customer.list":true,"customer.update":true}',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);
    }
}
