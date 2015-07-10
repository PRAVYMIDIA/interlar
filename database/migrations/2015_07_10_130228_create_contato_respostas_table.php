<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContatoRespostasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contato_respostas', function(Blueprint $table){
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();

            $table->unsignedInteger('user_id_created');
            $table->foreign('user_id_created')->references('id')->on('users')->onDelete('RESTRICT')->onUpdate('CASCADE');
            
            $table->text('mensagem')->nullable();

            $table->integer('contato_id')->unsigned();
            $table->foreign('contato_id')->references('id')->on('contatos')->onDelete('CASCADE')->onUpdate('CASCADE');
            
            $table->string('tipo',5); // SMS ou EMAIL
            $table->tinyInteger('enviada')->default('0');

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
        Schema::drop('contato_respostas');
    }
}
