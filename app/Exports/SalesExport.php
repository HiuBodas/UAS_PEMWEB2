<?php

namespace App\Exports;

use App\Models\Sale;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class SalesExport implements FromView
{
    public function view(): View
    {
        return view('exports.sales', [
            'sales' => Sale::with(['user', 'details.product'])->get()
        ]);
    }
}