<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AddSearchIndexesToTiendasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Crear índices usando SQL directo para mejor control de errores
        try {
            DB::statement('CREATE INDEX tiendas_nombre_index ON tiendas (nombre)');
        } catch (\Exception $e) {
            // Índice ya existe
        }

        try {
            DB::statement('CREATE INDEX tiendas_is_active_index ON tiendas (is_active)');
        } catch (\Exception $e) {
            // Índice ya existe
        }

        try {
            DB::statement('CREATE INDEX tiendas_categoria_id_index ON tiendas (categoria_id)');
        } catch (\Exception $e) {
            // Índice ya existe
        }

        try {
            DB::statement('CREATE INDEX tiendas_active_categoria_index ON tiendas (is_active, categoria_id)');
        } catch (\Exception $e) {
            // Índice ya existe
        }

        // Crear índice de texto completo
        if (config('database.default') === 'mysql') {
            try {
                DB::statement('ALTER TABLE tiendas ADD FULLTEXT tiendas_fulltext_search (nombre, direccion)');
            } catch (\Exception $e) {
                // El índice ya existe
            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Eliminar índices usando SQL directo
        try {
            DB::statement('DROP INDEX tiendas_fulltext_search ON tiendas');
        } catch (\Exception $e) {
            // Índice no existe
        }

        try {
            DB::statement('DROP INDEX tiendas_active_categoria_index ON tiendas');
        } catch (\Exception $e) {
            // Índice no existe
        }

        try {
            DB::statement('DROP INDEX tiendas_categoria_id_index ON tiendas');
        } catch (\Exception $e) {
            // Índice no existe
        }

        try {
            DB::statement('DROP INDEX tiendas_is_active_index ON tiendas');
        } catch (\Exception $e) {
            // Índice no existe
        }

        try {
            DB::statement('DROP INDEX tiendas_nombre_index ON tiendas');
        } catch (\Exception $e) {
            // Índice no existe
        }
    }
}
