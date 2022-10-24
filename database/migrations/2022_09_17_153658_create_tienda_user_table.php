<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTiendaUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tienda_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tienda_id')->nullable()->references('id')
            ->on('tiendas')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('user_id')->nullable()->references('id')
            ->on('users')->cascadeOnDelete()->cascadeOnUpdate();
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
        Schema::dropIfExists('tienda_user');
    }
}
