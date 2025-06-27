<?php

namespace App\Livewire\Forms;

use Illuminate\Support\Collection;
use Livewire\Attributes\Validate;
use App\Models\Gasto;
use Livewire\Form;

class GastoForm extends Form {
    #[Validate]
    public string $folio = '';

    #[Validate]
    public string $fecha = '';

    #[Validate]
    public string $categoria_id ='';

    #[Validate]
    public string $monto = '';

    #[Validate]
    public string $producto = '';

    #[Validate]
    public string $cantidad = '';

    #[Validate]
    public string $observaciones = '';

    public $id = null;

    public function rules(): array {
        return [
            'folio' => 'required|max:10',
            'fecha' => 'required',
            'categoria_id' => 'required',
            'monto' => 'required|numeric',
            'producto' => 'required|max:75',
            'cantidad' => 'required|numeric',
            'observaciones' => 'required|max:255',
        ];
    }

    public function save(): void {
        $this->validate();
        Gasto::updateOrCreate(['id' => $this->id], [
            'folio' => $this->folio,
            'fecha' => $this->fecha,
            'categoria_id' => $this->categoria_id,
            'monto' => $this->monto,
            'producto' => $this->producto,
            'cantidad' => $this->cantidad,
            'observaciones' => $this->observaciones,
        ]);
    }

    public function headers(): array {
        return [
            ['key' => 'folio', 'label' => 'Folio', 'class' => 'text-lg font-bold'],
            // ['key' => 'fecha', 'label' => 'Fecha', 'class' => 'w-30', 'format' => ['date', 'd-M-Y']],
            // ['key' => 'categoria.nombre', 'label' => 'Categoria', 'class' => 'w-20'],
            // ['key' => 'monto', 'label' => 'Monto', 'class' => 'w-20', 'format' => ['currency', '2,.', '$ ']],
            // ['key' => 'producto', 'label' => 'Producto', 'class' => 'w-20'],
            // ['key' => 'cantidad', 'label' => 'Cantidad', 'class' => 'w-20'],
            // ['key' => 'observaciones', 'label' => 'Observaciones', 'class' => 'w-20'],
        ];
    }
    public function gastos($sortBy, $search): Collection {
        $gasto = Gasto::where('folio', 'like', "%{$search}%")
        ->orderBy($sortBy['column'], $sortBy['direction'])
        ->get();
        $array = $gasto->toArray();
        $collection = collect($array);
        $grouped = $collection->groupBy(function (array $item, int $key) {
            return $item['folio'];
        });
        // // dd($collection);
        // dd($grouped);
        return $grouped;
    }

    public function edit($id): void {
        $this->reset();
        $gasto = Gasto::findOrFail($id);
        $this->folio = $gasto->folio;
        $this->fecha = $gasto->fecha;
        $this->categoria_id = $gasto->categoria_id;
        $this->monto = $gasto->monto;
        $this->producto = $gasto->producto;
        $this->cantidad = $gasto->cantidad;
        $this->observaciones = $gasto->observaciones;
        $this->id = $gasto->id; //? id del registro a editar
    }
}