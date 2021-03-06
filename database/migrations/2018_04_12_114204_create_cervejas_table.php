<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCervejasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cervejas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nome',150);
            $table->smallInteger('IBU')->nullable();
            $table->float('ABV', 9, 2)->nullable();
            $table->float('SRM', 9, 2)->nullable();
            $table->float('EBC', 9, 2)->nullable();
            $table->text('descricao')->nullable();
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
        Schema::dropIfExists('cervejas');
    }
}
