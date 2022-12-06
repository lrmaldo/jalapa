<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;
    protected $fillable = [
        'id','titulo' ,'imagen',
        'is_active', 
        'contenido',
        'user_id',

    ];

    /*  $table->string('titulo')->nullable();
            $table->string('imagen')->nullable();
            $table->text('contenido')->nullable();
            $table->foreignId('user_id')->nullable()
            ->references('id')->on('users')->cascadeOnDelete()->cascadeOnUpdate(); */
}
