<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Imagen extends Model {
    protected $table = 'imagenes';
    protected $fillable = [
        'path',
        'producto_id',
    ];

    public function producto() {
        return $this->belongsTo(Producto::class);
    }
}