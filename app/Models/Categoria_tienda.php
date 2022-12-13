<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categoria_tienda extends Model
{
    use HasFactory;
    protected $fillable = [
        'id', 'nombre',
        'is_active',
        'tienda_id',
        
    ];
}
