<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContatosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contatos', function(Blueprint $table){
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->string('nome', 255);
            $table->string('email', 255);
            $table->string('celular',15)->nullable();
            $table->text('mensagem')->nullable();
            $table->integer('loja_id')->unsigned()->nullable();
            $table->integer('produto_id')->unsigned()->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('produto_id')->references('id')->on('produtos')->onDelete('CASCADE')->onUpdate('CASCADE');
            $table->foreign('loja_id')->references('id')->on('lojas')->onDelete('RESTRICT')->onUpdate('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('contatos');
    }
}
