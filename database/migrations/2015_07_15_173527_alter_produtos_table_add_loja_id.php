<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterProdutosTableAddLojaId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('produtos', function (Blueprint $table){
            $table->integer('loja_id')->unsigned()->nullable();
            $table->foreign('loja_id')->references('id')->on('lojas')->onDelete('SET NULL')->onUpdate('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
         Schema::table('produtos', function($table){
            $table->dropForeign('produtos_loja_id_foreign');
            $table->dropColumn('loja_id');
        });
    }
}
