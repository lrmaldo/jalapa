<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tienda extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'id',
        'nombre', 'direccion', 'latitude',
        'longitude', 'logo_url',
        'facebook_url',
        'tipo_tienda',
        'categoria_id',
        'is_active',
    ];

    public function categoria(){
        return $this->belongsTo(Categoria::class,'categoria_id','id');
    }

    public function telefonos(){
        return $this->hasMany(Telefono::class);
    }

    public function User(){
        return $this->belongsToMany(User::class,'tienda_user','tienda_id','user_id');
    }

}
