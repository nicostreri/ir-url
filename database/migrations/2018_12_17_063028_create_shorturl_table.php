<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShorturlTable extends Migration
{

    public function up()
    {
        Schema::create('shorturls', function(Blueprint $table) {
            $table->increments('id');
            // Schema declaration
            $table->string('url',2000);
            $table->string('pass',64)->nullable();
            $table->timestamps();
            // Constraints declaration
        });
    }

    public function down()
    {
        Schema::drop('shorturls');
    }
}
