<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Color;

use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class TemplateExport implements FromArray, WithHeadings, WithHeadingRow
{
    use Exportable;

    protected $items = null;
    protected $totalResult = 0;

    function __construct($items)
    {
        $this->items = $items;
    }

    public function headingRow(): int
    {
        return 1;
    }

    public function headings(): array
    {
        $cols = [
            'Nit',
            'Nombre',
            'No. Documento',
            'Fecha Documento',
            'Base',
            'Impuesto',
            'Tarifa IVA',
            'Año proceso',
            'Mes proceso',
            'Concepto de retencion',
        ];

        return $cols;
    }

    public function array(): array
    {
        $items = $this->items;

        $data = [];

        foreach($items as $item){
            $row = [
                $item->nit,
                $item->name,
                $item->doc,
                $item->date,
                $item->base,
                $item->tax,
                $item->rate,
                $item->year_process,
                $item->period_process,
                $item->concept,
            ];

            $data[] = $row;
        }

        return $data;
    }
}
