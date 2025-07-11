<?php

namespace App\Exports;

use App\Models\Gasto;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class GastosExport implements FromCollection, WithHeadings, WithCustomStartCell, ShouldAutoSize, WithStyles {
    public $gastos = [];

    public function __construct($gastos) {
        $this->gastos = $gastos;
    }
    public function headings(): array {
        return ["Folio", "Fecha", "Categoria", "Monto", "Producto", "Cantidad", "Observaciones"];
    }
    public function startCell(): string {
        return 'B2';
    }

    public function collection() {
        return $this->gastos;
    }

    public function styles(Worksheet $sheet) {
        return [
            // Styling a specific cell by coordinate.
            // 'B2' => ['font' => ['italic' => true]],

            // Styling an entire column.
            'B' => ['font' => ['bold' => true, 'size' => 14]],
            // Styling an entire row
            2 => ['font' => ['bold' => true, 'size' => 24]],
        ];
    }
}