<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProdutosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('produtos', function(Blueprint $table){
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->unsignedInteger('user_id_created');
            $table->foreign('user_id_created')->references('id')->on('users')->onDelete('RESTRICT')->onUpdate('CASCADE');
            $table->unsignedInteger('fornecedor_id')->nullable();
            $table->foreign('fornecedor_id')->references('id')->on('fornecedores')->onDelete('RESTRICT')->onUpdate('CASCADE');
            
            $table->unsignedInteger('produto_tipo_id')->nullable();
            $table->foreign('produto_tipo_id')->references('id')->on('produtos_tipos')->onDelete('RESTRICT')->onUpdate('CASCADE');
            $table->string('nome', 255);
            $table->decimal('valor', 19,2);
            $table->smallInteger('parcelas');
            $table->text('descricao')->nullable();
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
        Schema::drop('produtos');
    }
}
