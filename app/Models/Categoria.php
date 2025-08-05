<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'nombre',
        'is_active',
    ];

    /**
     * Relación uno a muchos con Tienda
     * Una categoría puede tener muchas tiendas
     */
    public function tiendas()
    {
        return $this->hasMany(Tienda::class, 'categoria_id');
    }
}
