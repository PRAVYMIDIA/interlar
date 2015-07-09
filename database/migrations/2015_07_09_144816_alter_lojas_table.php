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
            $table->unsignedInteger('loja_tipo');
            $table->foreign('loja_tipo')->references('id')->on('lojas_tipo')->onDelete('RESTRICT')->onUpdate('CASCADE');
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
            $table->dropColumn('loja_tipo');
        });
    }
}
