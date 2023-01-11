<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIosInstalls extends Migration
{
    public function up()
    {
        Schema::create('ios_installs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id');
            $table->integer('buy_days');
            $table->string('udid')->nullable();
            $table->integer('begin_time')->nullable();
            $table->integer('end_time')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('ios_installs');
    }
}
