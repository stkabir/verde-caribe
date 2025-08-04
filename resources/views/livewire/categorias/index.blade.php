<?php

use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use Illuminate\Support\Collection;
use Livewire\Volt\Component;
use App\Models\Categoria;

new class extends Component {

    public $nombre = '';
    public $id_categoria = '';
    public bool $drawer = false;
    public string $search = '';
    public $sortBy = ['column' => 'nombre', 'direction' => 'asc'];
    public array $expanded = [2];

    public function save(): void {
        Categoria::updateOrCreate([
            'id' => $this->id_categoria,
        ], [
            'nombre' => $this->nombre,
        ]);
        LivewireAlert::title('Exito')->text('Se guardo correctamente')->success()
        ->toast()->position('center')->timer(1500)
        ->withOptions([
            'background' => 'oklch(28.33% 0.016 252.42)',
            'color' => 'white',
        ])->show();

        $this->reset([
            'nombre',
            'id_categoria',
        ]);
    }

    public function headers(): array {
        return [
            ['key' => 'nombre', 'label' => 'Nombre', 'class' => 'w-100'],
            ['key' => 'actions', 'label' => 'Acciones', 'class' => 'w-1', 'sortable' => false],
        ];
    }

    public function categorias(): Collection {
        return Categoria::all()
            ->sortBy([[...array_values($this->sortBy)]]);

    }

    public function with(): array {
        return [
            'headers' => $this->headers(),
            'categorias' => $this->categorias(),
        ];
    }

    public function edit($id): void {
        $this->nombre = Categoria::find($id)->nombre;
        $this->id_categoria = $id;
    }
    public function cancelar(): void {
        $this->reset([
            'nombre',
            'id_categoria',
        ]);
    }
    public function delete($id): void {
        LivewireAlert::title('¿Eliminar categoría?')->withConfirmButton('Si, eliminar')->withCancelButton('No')
        ->onConfirm('deleteConfirm', ['id' => $id])
        ->withOptions([
            'background' => 'oklch(28.33% 0.016 252.42)',
            'color' => 'white',
        ])->show();
    }
    public function deleteConfirm($id): void {
        $categoria = Categoria::find($id['id']);
        $categoria->delete();
        LivewireAlert::title('Exito')->text('Se elimino correctamente')->success()
        ->toast()->position('center')->timer(1500)
        ->withOptions([
            'background' => 'oklch(28.33% 0.016 252.42)',
            'color' => 'white',
        ])->show();
    }
};
?>
<div>
    {{-- * NAVBAR --}}
    <x-header title="Gastos" separator progress-indicator>
        {{-- <x-slot:middle class="!justify-end">
            <x-input placeholder="Buscar" wire:model.live.debounce.250="search" clearable icon="o-magnifying-glass" />
        </x-slot:middle> --}}
    </x-header>
    {{-- * FORM --}}
    <x-form wire:submit.prevent="save" no-separator>
        <x-card shadow>
            <x-input label="Nombre de la categoría" wire:model="nombre" placeholder="Nombre de la categoría" inline first-error-only/>
            <x-slot:actions>
                <x-button label="Guardar" class="btn-primary" type="submit" spinner="save" />
                <x-button label="Cancelar" class="btn-error btn-soft" type="button" wire:click.prevent="cancelar" spinner="cancelar" />
            </x-slot:actions>
        </x-card>
    </x-form>
    <hr class="border-t-[length:var(--border)] border-base-content/10 my-3">
    {{-- * TABLA --}}
    <x-card shadow>
        <x-table :headers="$headers" :rows="$categorias" :sort-by="$sortBy">
            @scope('cell_nombre', $categoria)
                <p>{{ $categoria['nombre'] }}</p>
            @endscope
            @scope('cell_actions', $categoria)
                <x-button class="btn-warning btn-sm btn-soft" type="button" wire:click.prevent="edit({{ $categoria['id'] }})" spinner="edit" icon="o-pencil" tooltip="Editar"/>
                <x-button class="btn-error btn-sm btn-soft" type="button" wire:click.prevent="delete({{ $categoria['id'] }})" spinner="delete" icon="o-trash" tooltip="Eliminar"/>
            @endscope
        </x-table>
    </x-card>
</div>
