<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTiendasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tiendas', function (Blueprint $table) {
            $table->id();
            $table->string('nombre')->nullable();
            $table->string('direccion')->nullable();
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->string('logo_url')->nullable();
            $table->string('facebook_url')->nullable();
            $table->string('tipo_tienda')->nullable()->comment('tipo de tienda','directorio o con comercio con producto');
            $table->foreignId('categoria_id')->nullable()
            ->references('id')->on('categorias')->cascadeOnDelete()->cascadeOnUpdate();
            $table->boolean('is_active')->nullable()->default(true);

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
        Schema::dropIfExists('tiendas');
    }
}
