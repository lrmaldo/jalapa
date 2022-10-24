<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;
    protected $fillable = [
        'id', 'nombre',
        'descripcion',
        'existencias',
        'precio',
        'imagen_url',
        'is_active',
        'categria_id',
        'tienda_id',

    ];

    public function categoria(){
        return $this->belongsTo(Categoria_tienda::class,'tienda_id');
    }
    public function tienda(){
        return $this->belongsTo(Tienda::class,'tienda_id');
    }
}
