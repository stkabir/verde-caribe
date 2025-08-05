<?php

use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\GastosExport;
use Illuminate\Support\Collection;
use App\Livewire\Forms\GastoForm;
use Livewire\Volt\Component;
use App\Models\Categoria;
use App\Models\Gasto;

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

    public function gastos($export = false): Collection {
        return $this->form->gastos($this->sortBy, $this->search, $export);
    }

    public function with(): array {
        return [
            'gastos' => $this->gastos(),
            'headers' => $this->headers()
        ];
    }

    public function edit($id): void {
        // hacer scroll al formulario
        $this->form->edit($id);
        $this->dispatch('scrollTo', id: 'form');
    }
    public function end(): void {
        LivewireAlert::title('¿Terminar orden?')->withConfirmButton('Si, terminar')->withCancelButton('No')
        ->onConfirm('endOrder')
        ->withOptions([
            'background' => 'oklch(28.33% 0.016 252.42)',
            'color' => 'white',
        ])->show();
    }
    public function endOrder(): void {
        $this->form->reset();
    }
    public function export() {
        return Excel::download(new GastosExport($this->gastos(true)), 'gastos.xlsx');
        // $this->form->export();
    }
    public function delete($id): void {
        LivewireAlert::title('¿Eliminar gasto?')->withConfirmButton('Si, eliminar')->withCancelButton('No')
        ->onConfirm('deleteConfirm', ['id' => $id])
        ->withOptions([
            'background' => 'oklch(28.33% 0.016 252.42)',
            'color' => 'white',
        ])->show();
    }
    public function deleteConfirm($id): void {
        $gasto = Gasto::find($id['id']);
        $gasto->delete();
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
        <x-slot:middle class="!justify-end">
            <x-input placeholder="Buscar" wire:model.live.debounce.250="search" clearable icon="o-magnifying-glass" />
        </x-slot:middle>
    </x-header>
    {{-- * FORM --}}
    <x-form wire:submit.prevent="save" no-separator>
        <x-card shadow>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4" id="form">
                <div>
                    <x-input label="Folio" wire:model.live.debounce.250="form.folio" placeholder="Folio" inline first-error-only />
                </div>
                <div>
                    <x-datetime label="Fecha" wire:model="form.fecha" placeholder="Fecha" inline first-error-only/>
                </div>
            </div>
        </x-card>
        <x-card shadow>
            <div class="grid grid-cols-4 gap-4">
                <div class="col-span-4 md:col-span-2">
                    <x-select label="Categoría" wire:model="form.categoria_id" placeholder="Selecciona una opción" inline first-error-only :options="$categorias" option-label="nombre"/>
                </div>
                <div class="col-span-4 md:col-span-2">
                    <x-input label="Producto" wire:model.live.debounce.250="form.producto" placeholder="Producto" inline first-error-only />
                </div>
                <div class="col-span-2">
                    <x-input label="Monto" wire:model.live.debounce.250="form.monto" placeholder="Monto" inline first-error-only />
                </div>
                <div class="col-span-2">
                    <x-input label="Cantidad" wire:model.live.debounce.250="form.cantidad" placeholder="Cantidad" inline first-error-only />
                </div>
            </div>
            <div class="grid grid-cols-1 mt-4">
                <div class="col-span-1">
                    <x-textarea label="Observaciones" wire:model.live.debounce.250="form.observaciones" placeholder="Observaciones" inline first-error-only />
                </div>
            </div>
            <x-slot:actions>
                <x-button label="Guardar" class="btn-primary" type="submit" spinner="save" />
                <x-button label="Terminar orden" class="btn-error btn-soft" type="button" wire:click.prevent="end" spinner="end" />
            </x-slot:actions>
        </x-card>
    </x-form>
    <hr class="border-t-[length:var(--border)] border-base-content/10 my-3">
    {{-- * TABLA --}}
    <x-card shadow>
        <div class="flex justify-end">
            <x-button class="btn-success" type="button" wire:click.prevent="export" spinner="export" icon="o-arrow-down-tray" tooltip="Exportar"/>
        </div>
        <x-table :headers="$headers" :rows="$gastos" :sort-by="$sortBy">
            @scope('cell_folio', $gasto)
                <p class="text-2xl uppercase text-emerald-700">{{ $gasto['folio'] . ' - ' . $gasto['total'] }}</p>
                <div class="rounded-md font-medium">
                    @foreach($gasto['gastos'] as $item)
                        <div class="grid md:grid-flow-row lg:grid-flow-col lg:grid-cols-13 my-4 items-center bg-base-content/10">
                            <div class="lg:col-span-2">
                                <p>{{ $item['fecha'] }}</p>
                            </div>
                            <div class="lg:col-span-2">
                                <p>{{ $item['nombre'] }}</p>
                            </div>
                            <div class="lg:col-span-2">
                                <p>{{ $item['monto'] }}$</p>
                            </div>
                            <div class="lg:col-span-2">
                                <p>{{ $item['producto'] }}</p>
                            </div>
                            <div class="lg:col-span-1">
                                <p>{{ $item['cantidad'] }}</p>
                            </div>
                            <div class="lg:col-span-5">
                                <p>{{ $item['observaciones'] }}</p>
                            </div>
                            <div class="lg:col-span-1 text-end">
                                <x-button class="btn-warning btn-sm btn-soft" type="button" wire:click.prevent="edit({{ $item['id'] }})" spinner="edit" icon="o-pencil" tooltip="Editar"/>
                                <x-button class="btn-error btn-sm btn-soft" type="button" wire:click.prevent="delete({{ $item['id'] }})" spinner="delete" icon="o-trash" tooltip="Eliminar"/>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endscope
        </x-table>
    </x-card>
</div>
<script>
    window.addEventListener('scrollTo', function (event) {
        const element = document.getElementById(event.detail.id);
        element.scrollIntoView({ behavior: 'smooth' });
    });
</script>