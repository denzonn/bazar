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
        $totalPaidTransactions = Transaction::where('status', 'Paid')->sum('total');
        $totalUnPaidTransactions = Transaction::where('status', 'Proses')->sum('total');

        $productQuantities = TransactionDetail::select('product_id', DB::raw('SUM(quantity) as total_quantity'))
            ->join('transactions', 'transaction_details.transaction_id', '=', 'transactions.id')
            ->where('transactions.status', '!=', 'Cancel') // Filter transaksi yang bukan 'Cancel'
            ->groupBy('product_id')
            ->with('product')
            ->get();


        // Ambil 6 transaksi terbaru
        $latestTransactions = Transaction::orderBy('updated_at', 'desc')->take(6)->get();

        // Klasifikasikan transaksi
        $transactionsByStatus = [
            'new' => [],
            'delivered' => [],
            'waiting_for_payment' => [],
            'paid' => [],
            'cancelled' => []
        ];

        foreach ($latestTransactions as $transaction) {
            if ($transaction->status == 'PAID') {
                $transactionsByStatus['paid'][] = $transaction;
            } elseif ($transaction->status == 'Cancel') {
                $transactionsByStatus['cancelled'][] = $transaction;
            } elseif ($transaction->isComplete()) {
                $transactionsByStatus['waiting_for_payment'][] = $transaction;
            } elseif ($transaction->transactionDetails()->where('arrive', true)->exists()) {
                $transactionsByStatus['delivered'][] = $transaction;
            } else {
                $transactionsByStatus['new'][] = $transaction;
            }
        }

        $allTransactions = array_merge(
            $transactionsByStatus['new'],
            $transactionsByStatus['delivered'],
            $transactionsByStatus['waiting_for_payment'],
            $transactionsByStatus['paid'],
            $transactionsByStatus['cancelled']
        );

        usort($allTransactions, function ($a, $b) {
            return $b->updated_at <=> $a->updated_at;
        });

        $latestTransactions = array_slice($allTransactions, 0, 6);

        return view('pages.dashboard', compact('totalPaidTransactions', 'totalUnPaidTransactions', 'productQuantities', 'latestTransactions'));
    }
}
