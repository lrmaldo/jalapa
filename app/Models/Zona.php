<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Zona extends Model
{
    use HasFactory;

    protected $fillable = [
        'id', 'nombre','user_id'
    ];

    public function imagenes(){
        return $this->belongsToMany(ImagenHotspot::class,'zona_imagen','zona_id','imagen_id');
    }

}
