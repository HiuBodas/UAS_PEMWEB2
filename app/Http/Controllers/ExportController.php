<?php

namespace App\Http\Controllers;

use App\Exports\SalesExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Sale;


class ExportController extends Controller
{
    public function exportExcel()
    {
        return Excel::download(new SalesExport, 'laporan-penjualan.xlsx');
    }

    public function exportPdf()
    {
        $sales = Sale::with(['user', 'details.product'])->get();

        $pdf = Pdf::loadView('exports.sales_pdf', compact('sales'));

        return $pdf->download('laporan-penjualan.pdf');
    }
}
