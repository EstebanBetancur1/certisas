<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class DocsExportAll implements FromView
{
    public function __construct($docs)
    {
        $this->docs = $docs;
    }

    public function view(): View
    {
        return view('backoffice.emissions.export_all', [
            'docs'     => $this->docs
        ]);
    }
}
