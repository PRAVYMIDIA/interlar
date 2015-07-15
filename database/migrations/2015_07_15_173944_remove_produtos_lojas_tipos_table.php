<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveProdutosLojasTiposTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::drop('produtos_lojas_tipos');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::create('produtos_lojas_tipos', function(Blueprint $table){
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->unsignedInteger('produto_id');
            $table->foreign('produto_id')->references('id')->on('produtos')->onDelete('CASCADE')->onUpdate('CASCADE');
            $table->unsignedInteger('loja_tipo_id');
            $table->foreign('loja_tipo_id')->references('id')->on('lojas_tipos')->onDelete('CASCADE')->onUpdate('CASCADE');
        });
    }
}
