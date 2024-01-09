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

    private $errors = [];
    
    private $rows = 0;
    private $currentRow = 1;
    
    function __construct($data, $template)
    {
        $this->data = $data;
        $this->template = $template;
    }

    
    public function model(array $row)
    {
        $this->currentRow++;

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

           
            // Verificar si alguna de las columnas requeridas está vacía
            if (empty($nit) || empty($name) || empty($doc) || empty($date) || empty($base) || empty($tax) || empty($rate) || empty($year_process) || empty($period_process) || empty($concept)) {
                $this->errors[] = "Error en la línea {$this->currentRow}: Campos vacíos [Documento: {$doc}]";
                return null;
            }
            $date = $this->convertExcelDateToTimestamp($date);
         

            // Verificar el formato de la fecha
            if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $date)) {
                $this->errors[] = "Error en la línea {$this->currentRow}: Formato de fecha incorrecto [Documento: {$doc}]";
                return null;
            }
            
            // Con esto:
            // Convertir el número de Excel a una cadena de fecha


            // Verificar registros duplicados
            $query = $templateItemRepository->where([
                ['nit', '=', $nit],
                ['doc', '=', $doc],
                ['concept', '=', $concept],
            ])->exists();

            if ($query) {
                $this->errors[] = "Error en la línea {$this->currentRow}: Registro duplicado [Documento: {$doc}]";
                return null;
            }

            
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
              
                $this->errors[] = "Error en la línea {$this->currentRow}: Registro duplicado [Documento: {$doc}]";
                return null;

                

               
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

    public function getErrors(): array
    {
        return $this->errors;
    }

    private function convertExcelDateToTimestamp($excelDate){
    // La fecha de referencia para las fechas de Excel (1 de enero de 1900)
    $excelBaseDate = strtotime('1899-12-31');

    // Convierte el número de días a segundos y suma a la fecha de referencia
    $timestamp = $excelBaseDate + ($excelDate - 1) * 24 * 60 * 60;

    // Formatea el timestamp como una cadena de fecha (YYYY-MM-DD)
    return date('Y-m-d', $timestamp);
    }
}
