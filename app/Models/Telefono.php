<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Telefono extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'id', 'tipo',
        'is_whatsapp',
        'telefono',
        'tienda_id',
    ];

    public function tienda(){
        return $this->belongsTo(Tienda::class,'tienda_id');
    }
}
