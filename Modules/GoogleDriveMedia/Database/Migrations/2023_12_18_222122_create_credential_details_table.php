<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCredentialDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('credential_details', function (Blueprint $table) {
            $table->id();
            $table->integer('credential_id')->unsigned();
            $table->string('client_id');
            $table->string('client_secret');
            $table->string('refresh_token');
            $table->string('disk_name');
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
        Schema::dropIfExists('credential_details');
    }
}
