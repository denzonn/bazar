<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(){
        // Mengambil total transaksi yang berstatus "PAID" dan menjumlahkannya
        $totalPaidTransactions = Transaction::where('status', 'PAID')->sum('total');
        $totalUnPaidTransactions = Transaction::where('status', 'PROSES')->sum('total');

        // Mengirimkan data total ke view
        return view('pages.dashboard', compact('totalPaidTransactions', 'totalUnPaidTransactions'));
    }
}
