<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStatisticTable extends Migration
{

    public function up()
    {
        Schema::create('statistics', function(Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('shorturl_id');
            $table->ipAddress('ip');
            $table->string('browser');
            $table->string('os');
            $table->enum('type_device', ['PHONE', 'COMPUTER', 'TABLET', 'OTHER'])->default('OTHER');
            $table->string('country');
            $table->timestamps();
            // Schema declaration
            // Constraints declaration
            $table->foreign('shorturl_id')->references('id')->on('shorturls')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::drop('statistics');
    }
}
