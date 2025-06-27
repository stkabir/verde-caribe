<?php

use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use Illuminate\Support\Collection;
use App\Livewire\Forms\GastoForm;
use Livewire\Volt\Component;
use App\Models\Categoria;

new class extends Component {


    public bool $drawer = false;
    public string $search = '';
    public $categorias = [];
    public $sortBy = ['column' => 'folio', 'direction' => 'asc'];
    public array $expanded = [2];

    public GastoForm $form;

    public function mount(): void {
        $this->categorias = Categoria::all();
    }

    public function save(): void {
        $this->form->save();

        LivewireAlert::title('Exito')->text('Se guardo correctamente')->success()
        ->toast()->position('center')->timer(1500)
        ->withOptions([
            'background' => 'oklch(28.33% 0.016 252.42)',
            'color' => 'white',
        ])->show();

        $this->reset([
            'form.categoria_id',
            'form.monto',
            'form.producto',
            'form.cantidad',
            'form.observaciones',
        ]);
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

    public function edit($id): void {
        $this->form->edit($id);
    }
    public function end(): void {
        LivewireAlert::title('Terminar orden?')->withConfirmButton('Terminar')->withCancelButton('Cancelar')
        ->onConfirm('endOrder')
        ->withOptions([
            'background' => 'oklch(28.33% 0.016 252.42)',
            'color' => 'white',
        ])->show();
    }
    public function endOrder(): void {
        $this->form->reset();
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
    <x-form wire:submit.prevent="save" no-separator>
        <x-card shadow>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <x-input label="Folio" wire:model.live.debounce.250="form.folio" placeholder="Folio" inline first-error-only />
                </div>
                <div>
                    <x-datetime label="Fecha" wire:model="form.fecha" placeholder="Fecha" inline first-error-only/>
                </div>
            </div>
        </x-card>
        <x-card shadow>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
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
                <div class="col-span-4">
                    <x-textarea label="Observaciones" wire:model.live.debounce.250="form.observaciones" placeholder="Observaciones" inline first-error-only />
                </div>
            </div>
            <x-slot:actions>
                <x-button label="Guardar" class="btn-success" type="submit" spinner="save" />
                <x-button label="Terminar orden" class="btn-primary" type="button" wire:click.prevent="end" spinner="end" />
            </x-slot:actions>
        </x-card>
    </x-form>
    <hr class="border-t-[length:var(--border)] border-base-content/10 my-3">
    {{-- * TABLA --}}
    <x-card shadow>
        <x-table :headers="$headers" :rows="$gastos" :sort-by="$sortBy">
            {{-- @foreach($gastos as $gasto)
                @foreach($gasto as $item)
                    {{ $item['folio'] }}
                @endforeach
            @endforeach --}}
            @scope('cell_folio', $gasto)
                {{ $gasto[0]['folio'] }}
                @foreach($gasto as $item)
                    <li>{{ $item['fecha'] }}</li>
                @endforeach
            @endscope

        </x-table>
    </x-card>
</div>
