<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gasto extends Model {
    protected $table = 'gastos';
    protected $fillable = [
        'folio',
        'fecha',
        'categoria_id',
        'monto',
        'producto',
        'cantidad',
        'observaciones',
    ];

    public function categoria() {
        return $this->belongsTo(Categoria::class);
    }
}