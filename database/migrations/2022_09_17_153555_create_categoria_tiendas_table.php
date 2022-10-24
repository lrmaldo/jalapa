<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriaTiendasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categoria_tiendas', function (Blueprint $table) {
            $table->id();
            $table->string('nombre')->nullable();
            $table->string('imagen_url')->nullable();

            $table->boolean('is_active')->nullable()->default(true);
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
        Schema::dropIfExists('categoria_tiendas');
    }
}
