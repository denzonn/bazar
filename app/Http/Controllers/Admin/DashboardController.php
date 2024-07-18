<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Mengambil total transaksi yang berstatus "PAID" dan menjumlahkannya
        $totalPaidTransactions = Transaction::where('status', 'PAID')->sum('total');
        $totalUnPaidTransactions = Transaction::where('status', 'PROSES')->sum('total');

        // Menghitung total quantity per produk
        $productQuantities = TransactionDetail::select('product_id', DB::raw('SUM(quantity) as total_quantity'))
            ->groupBy('product_id')
            ->with('product')
            ->get();

        // Mengirimkan data total ke view
        return view('pages.dashboard', compact('totalPaidTransactions', 'totalUnPaidTransactions', 'productQuantities'));
    }
}
