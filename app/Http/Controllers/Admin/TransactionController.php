<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class TransactionController extends Controller
{
    public function index()
    {
        return view('pages.transaction.index');
    }

    public function getData()
    {
        $transaction = Transaction::all();

        return DataTables::of($transaction)->make(true);
    }

    public function detailTransaction($id){
        $transaction = Transaction::where('id', $id)->with(['transactionDetails'])->first();

        return view('pages.transaction.detail', compact('transaction'));
    }

    public function paidTransaction($id){
        $transaction = Transaction::find($id);
        $transaction->status = 'PAID';
        $transaction->save();

        return redirect()->route('transaction.index')->with('success', 'Transaction status has been updated to paid');
    }
}
