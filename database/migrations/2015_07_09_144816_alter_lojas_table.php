<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterLojasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('lojas', function(Blueprint $table){
            $table->integer('loja_tipo_id')->unsigned();
            $table->foreign('loja_tipo_id')->references('id')->on('lojas_tipos')->onDelete('CASCADE')->onUpdate('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('lojas', function(Blueprint $table){
            $table->dropForeign('fk_lojas_loja_tipo_id');
            $table->dropColumn('loja_tipo');
        });
    }
}
