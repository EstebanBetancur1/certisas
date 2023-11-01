<?php

namespace App\Imports;

use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class TemplatesImport implements ToModel, WithValidation, WithHeadingRow{
    use Importable;

    protected $data = [];
    protected $template = null;

    private $duplicateDetails = [];
    
    private $rows = 0;
    private $duplicate = 0;

    function __construct($data, $template)
    {
        $this->data = $data;
        $this->template = $template;
    }

    public function model(array $row)
    {
        $templateItemRepository = Repository("TemplateItem");

        $nit            = current($row);
        $name           = next($row);
        $doc            = next($row);
        $date           = next($row);
        $base           = next($row);
        $tax            = next($row);
        $rate           = next($row);
        $year_process   = next($row);
        $period_process = next($row);
        $concept        = next($row);

        if($nit){

            //Validación para evitar registros duplicados que ya existan con el mismo nit y documento
            $query = $templateItemRepository->where([
                ['nit', 'LIKE', $nit],
                ['doc', 'LIKE', $doc],
                ['concept', 'LIKE', $concept],
            ])->count();

            if ($query < 1) {
                
                $this->rows++;

                $row = $templateItemRepository->create([
                    'nit'           => $nit,
                    'name'          => $name,
                    'doc'           => $doc,
                    'date'          => $date,
                    'base'          => $base,
                    'tax'           => $tax,
                    'rate'          => $rate,
                    'year_process'  => $year_process,
                    'period_process'=> $period_process,
                    'concept'       => $concept,
                    'type'          => $this->data["type"],
                    'status'        => 1,
                    'company_id'    => $this->template->company_id,
                    'user_id'       => $this->template->user_id,
                    'template_id'   => $this->template->id,
                    'period_type'   => $this->template->period_type,
                    'city_id'       => $this->template->city_id,
                ]);
            } else {
                ++$this->duplicate;

                $this->duplicateDetails[] = [
                    'nit'           => $nit,
                    'name'          => $name,
                    'doc'           => $doc,
                    'date'          => $date,
                    'base'          => $base,
                    'tax'           => $tax,
                    'rate'          => $rate,
                    'year_process'  => $year_process,
                    'concept'       => $concept,
                ];
            }
        }
        return null;
    }

    public function rules(): array
    {
        return [];
    }

    public function headingRow(): int
    {
        return 1;
    }

    public function getRowCount(): int
    {
        return $this->rows;
    }

    public function getDuplicateRows(): int
    {
        return $this->duplicate;
    }

    public function getDuplicateDetails(): array {
        return $this->duplicateDetails;
    }
}
