<?php

use Illuminate\Support\Collection;
use App\Livewire\Forms\GastoForm;
use Livewire\Volt\Component;
use App\Models\Categoria;
use Mary\Traits\Toast;

new class extends Component {
    use Toast;

    public bool $drawer = false;
    public string $search = '';
    public $categorias = [];
    public $sortBy = ['column' => 'id', 'direction' => 'asc'];

    public GastoForm $form;

    public function mount(): void {
        $this->categorias = Categoria::all();
    }

    public function save(): void {
        $this->form->save();
        $this->success('Gasto guardado correctamente.');
    }

    public function headers(): array {
        return $this->form->headers();
    }

    public function gastos(): Collection {
        return $this->form->gastos($this->sortBy, $this->search);
    }

    public function with(): array {
        return [
            'gastos' => $this->gastos(),
            'headers' => $this->headers()
        ];
    }

    // public function delete($id): void {
    //     $this->warning("Will delete #$id", 'It is fake.', position: 'toast-bottom');
    // }
    public function edit($id): void {
        $this->info("Will edit #$id", 'It is fake.', position: 'toast-center toast-middle');
        $this->form->edit($id);
    }
};
?>

<div>
    {{-- * NAVBAR --}}
    <x-header title="Gastos" separator progress-indicator>
        <x-slot:middle class="!justify-end">
            <x-input placeholder="Buscar" wire:model.live.debounce.250="search" clearable icon="o-magnifying-glass" />
        </x-slot:middle>
    </x-header>
    {{-- * FORM --}}
    <x-card shadow>
        <x-form wire:submit.prevent="save" no-separator>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <x-input label="Folio" wire:model.live.debounce.250="form.folio" placeholder="Folio" inline first-error-only />
                </div>
                <div>
                    <x-datetime label="Fecha" wire:model="form.fecha" placeholder="Fecha" inline first-error-only/>
                </div>
                <div>
                    <x-select label="Categoría" wire:model="form.categoria_id" placeholder="Selecciona una opción" inline first-error-only :options="$categorias" option-label="nombre"/>
                </div>
                <div>
                    <x-input label="Cantidad" wire:model.live.debounce.250="form.cantidad" placeholder="Cantidad" inline first-error-only />
                </div>
                <div>
                    <x-input label="Producto" wire:model.live.debounce.250="form.producto" placeholder="Producto" inline first-error-only />
                </div>
                <div>
                    <x-input label="Monto" wire:model.live.debounce.250="form.monto" placeholder="Monto" inline first-error-only />
                </div>
                <div class="col-span-3">
                    <x-textarea label="Observaciones" wire:model.live.debounce.250="form.observaciones" placeholder="Observaciones" inline first-error-only />
                </div>
            </div>
            <x-slot:actions>
                <x-button label="Guardar" class="btn-success" type="submit" spinner="save" />
            </x-slot:actions>
        </x-form>
    </x-card>
    <hr class="border-t-[length:var(--border)] border-base-content/10 my-3">
    {{-- * TABLA --}}
    <x-card shadow>
        <x-table :headers="$headers" :rows="$gastos" :sort-by="$sortBy">
            @scope('actions', $gasto)
            <x-button icon="o-pencil" wire:click="edit({{ $gasto['id'] }})" spinner class="btn-ghost btn-sm text-info" />
            {{-- <x-button icon="o-trash" wire:click="delete({{ $gasto['id'] }})" spinner class="btn-ghost btn-sm text-error" /> --}}
            @endscope
        </x-table>
    </x-card>
</div>
