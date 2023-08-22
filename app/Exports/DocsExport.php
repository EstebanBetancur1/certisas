<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class DocsExport implements FromView
{
    public function __construct($ids, $emission)
    {
        $this->ids = $ids;
        $this->emission = $emission;
    }

    public function view(): View
    {
    	$repository = repository("TemplateItem");

    	$items = $repository->findWhereIn("id", $this->ids);

        return view('backoffice.emissions.export', [
            'items'     => $items,
            'emission'  => $this->emission
        ]);
    }
}
