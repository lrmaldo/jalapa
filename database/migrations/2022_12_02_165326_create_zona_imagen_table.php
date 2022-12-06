<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateZonaImagenTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('zona_imagen', function (Blueprint $table) {
            $table->id();
            $table->foreignId('zona_id')->nullable()
            ->references('id')->on('zonas')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('imagen_id')->nullable()
            ->references('id')->on('imagen_hotspots')->cascadeOnDelete()->cascadeOnUpdate();
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
        Schema::dropIfExists('zona_imagen');
    }
}
