<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cep', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string("cep");
            $table->string("label")->nullable();
            $table->string("logradouro")->nullable();
            $table->string("complemento")->nullable();
            $table->string("bairro")->nullable();
            $table->string("localidade")->nullable();
            $table->string("uf")->nullable();
            $table->biginteger("ibge")->nullable();
            $table->biginteger("gia")->nullable();
            $table->integer("ddd")->nullable();
            $table->biginteger("siafi")->nullable();
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
        Schema::dropIfExists('cep');
    }
};
