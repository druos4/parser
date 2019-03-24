<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateParserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parser', function (Blueprint $table) {
            $table->increments('id');
            $table->text('title');
            $table->text('code');
            $table->text('sourse');
            $table->float('price');
            $table->text('vendor');
            $table->text('size')->nullable();
            $table->text('color')->nullable();
            $table->text('memory')->nullable();
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
        Schema::dropIfExists('parser');
    }
}
