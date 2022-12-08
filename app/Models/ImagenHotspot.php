<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImagenHotspot extends Model
{
    use HasFactory;
    protected $fillable = [
        'id', 'is_active','imagen_url','user_id'
    ];

    public function zonas(){
        return $this->belongsToMany(Zona::class,'zona_imagen','imagen_id','zona_id');
    }
}
