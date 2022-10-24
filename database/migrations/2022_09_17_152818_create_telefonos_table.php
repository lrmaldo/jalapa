<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTelefonosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('telefonos', function (Blueprint $table) {
            $table->id();
            $table->enum('tipo',['fijo','celular'])->nullable()->comment("tipo de telefono");
            $table->boolean('is_whatsapp')->nullable()->default(true);
            $table->string('telefono')->nullable();
            $table->foreignId('tienda_id')->nullable()->references('id')
            ->on('tiendas')->cascadeOnDelete()->cascadeOnUpdate();
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
        Schema::dropIfExists('telefonos');
    }
}
