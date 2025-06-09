<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    protected $table = 'productos';
    protected $fillable = [
        'nombre',
        'stock',
        'costo',
        'categoria_id',
        'precio',
    ];

    public function categoria() {
        return $this->belongsTo(Categoria::class);
    }

    public function imagenes() {
        return $this->hasMany(Imagen::class);
    }

}
