<?php

namespace Modules\Frames\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Frames\Entities\StickableFrame;
use Carbon\Carbon;

class StickableFrameSeederTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $datas = [
            ['title' => 'Classic Black', 'slug' => 'classic-black', 'class'=> 'classic-black', 'image'=> ' ', 'order'=> 1, 'status'=> 'publish', 'price'=>50000, 'created_by_id'=> 1, 'created_at' => Carbon::now()->format('Y-m-d H:i:s'), 'updated_at' => Carbon::now()->format('Y-m-d H:i:s')],
            ['title' => 'Classic White', 'slug' => 'classic-white', 'class'=> 'classic-white', 'image'=> ' ', 'order'=> 2, 'status'=> 'publish', 'price'=>50000, 'created_by_id'=> 1, 'created_at' => Carbon::now()->format('Y-m-d H:i:s'), 'updated_at' => Carbon::now()->format('Y-m-d H:i:s')],
            ['title' => 'Matting Black Border', 'slug' => 'matting-black', 'class'=> 'matting-black', 'image'=> ' ', 'order'=> 3, 'status'=> 'publish', 'price'=>60000, 'created_by_id'=> 1, 'created_at' => Carbon::now()->format('Y-m-d H:i:s'), 'updated_at' => Carbon::now()->format('Y-m-d H:i:s')],
            ['title' => 'Matting White Border', 'slug' => 'matting-white', 'class'=> 'matting-white', 'image'=> ' ', 'order'=> 4, 'status'=> 'publish', 'price'=>60000, 'created_by_id'=> 1, 'created_at' => Carbon::now()->format('Y-m-d H:i:s'), 'updated_at' => Carbon::now()->format('Y-m-d H:i:s')],
            ['title' => 'Frameless', 'slug' => 'frameless', 'class'=> 'frameless', 'image'=> ' ', 'order'=> 5, 'status'=> 'draft', 'created_by_id'=> 1, 'price'=>70000, 'created_at' => Carbon::now()->format('Y-m-d H:i:s'), 'updated_at' => Carbon::now()->format('Y-m-d H:i:s')]
        ];

        StickableFrame::insert($datas);
    }
}
