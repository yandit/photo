<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUploadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('uploads', function (Blueprint $table) {
            $table->id();
            $table->string('source');
            
            // local image
            $table->string('image');
            // ===================

            // gdrive image
            $table->string('disk')->nullable();
			$table->string('path')->nullable();
            // ===================

            // intervention image
            $table->string('x')->nullable();
			$table->string('y')->nullable();
			$table->string('width')->nullable();
            $table->string('height')->nullable();
            // ===================

            // canvas cropper js
            $table->string('cleft')->nullable();
			$table->string('ctop')->nullable();
			$table->string('cwidth')->nullable();
            $table->string('cheight')->nullable();
            // ===================

            $table->unsignedBigInteger('cart_id')->nullable();
            $table->foreign('cart_id')->references('id')->on('carts')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('uploads');
    }
}
