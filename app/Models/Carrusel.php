<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Carrusel extends Model
{
    use HasFactory;

    protected $fillable = [
        'id', 'imagen_url',
        'is_active', 

    ];
}
