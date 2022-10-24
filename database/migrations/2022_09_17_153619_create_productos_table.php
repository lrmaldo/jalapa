<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('productos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre')->nullable();
            $table->text('descripcion')->nullable();
            $table->integer('existencias')->nullable();
            $table->double('precio',2)->nullable();
            $table->string('imagen_url')->nullable();
            $table->boolean('is_active')->nullable()->default(true);
            /* foreignID categoria_tienda */
            $table->foreignId('categoria_id')->nullable()->references('id')
            ->on('categoria_tiendas')->cascadeOnDelete()->cascadeOnUpdate();
            /* foreignID tienda_id */
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
        Schema::dropIfExists('productos');
    }
}
