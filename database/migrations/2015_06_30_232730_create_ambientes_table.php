<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAmbientesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ambientes', function(Blueprint $table){
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->unsignedInteger('user_id_created');
            $table->foreign('user_id_created')->references('id')->on('users')->onDelete('RESTRICT')->onUpdate('CASCADE');
            $table->string('nome', 255);
            $table->string('descricao', 255)->nullable();
            $table->string('imagem', 255)->nullable();
            $table->unsignedInteger('user_id_updated')->nullable();
            $table->foreign('user_id_updated')->references('id')->on('users')->onDelete('set null');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('ambientes');
    }
}
