<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterEmailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('emails', function(Blueprint $table){
            $table->integer('ambiente_id')->unsigned()->nullable();
            $table->unsignedInteger('produto_tipo_id')->nullable();
            
            $table->string('pagina');

            $table->foreign('ambiente_id')->references('id')->on('ambientes')->onDelete('SET NULL')->onUpdate('CASCADE');
            $table->foreign('produto_tipo_id')->references('id')->on('produtos_tipos')->onDelete('SET NULL')->onUpdate('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('emails', function($table){
            $table->dropForeign('emails_ambiente_id_foreign');
            $table->dropForeign('emails_produto_tipo_id_foreign');
            $table->dropColumn('ambiente_id');
            $table->dropColumn('produto_id');
            $table->dropColumn('pagina');
        });
    }
}
