<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Supplier;
use App\Models\Sale;
use App\Models\SaleDetail;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Chart 1: Penjualan 7 hari terakhir
        $salesChart = Sale::select(
                DB::raw('DATE(tanggal) as date'),
                DB::raw('COUNT(*) as total_transaksi'),
                DB::raw('SUM(total) as total_pendapatan')
            )
            ->where('tanggal', '>=', now()->subDays(6)->startOfDay())
            ->groupBy(DB::raw('DATE(tanggal)'))
            ->orderBy('date')
            ->get();

        // Isi hari yang kosong dengan 0
        $labels = [];
        $dataTranaksi = [];
        $dataPendapatan = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $labels[] = now()->subDays($i)->format('d M');
            $row = $salesChart->firstWhere('date', $date);
            $dataTranaksi[] = $row ? (int) $row->total_transaksi : 0;
            $dataPendapatan[] = $row ? (float) $row->total_pendapatan : 0;
        }

        // Chart 2: Top 5 produk terlaris
        $topProducts = SaleDetail::select('product_id', DB::raw('SUM(qty) as total_terjual'))
            ->with('product')
            ->groupBy('product_id')
            ->orderByDesc('total_terjual')
            ->limit(5)
            ->get();

        $topLabels = $topProducts->map(fn($d) => $d->product?->nama_produk ?? 'N/A')->toArray();
        $topData   = $topProducts->map(fn($d) => (int) $d->total_terjual)->toArray();

        return view('dashboard', [
            'totalProduk'     => Product::count(),
            'totalKategori'   => Category::count(),
            'totalSupplier'   => Supplier::count(),
            'totalPenjualan'  => Sale::count(),
            'totalPendapatan' => Sale::sum('total'),
            // Chart data (JSON-safe)
            'chartLabels'       => $labels,
            'chartTranaksi'     => $dataTranaksi,
            'chartPendapatan'   => $dataPendapatan,
            'topLabels'         => $topLabels,
            'topData'           => $topData,
        ]);
    }
}