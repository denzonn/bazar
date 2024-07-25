<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionDetail;
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
        $transactions = Transaction::with('transactionDetails')->orderBy('created_at', 'desc')->get();

        $transactions->each(function ($transaction) {
            if ($transaction->status !== 'Paid' && $transaction->status !== 'Cancel' && $transaction->isComplete()) {
                $transaction->status = 'Complete';
            }

            $transaction->transaction_not_yet_deliver = $transaction->transactionDetails->where('arrive', 0)->count();
            $transaction->transaction_details_count = $transaction->transactionDetails->count();

            // Check if all items are delivered
            $transaction->allDelivered = $transaction->transactionDetails->every(function ($detail) {
                return $detail->arrive;
            });
        });

        return DataTables::of($transactions)->make(true);
    }

    public function detailTransaction($id)
    {
        $transaction = Transaction::where('id', $id)->with(['transactionDetails'])->first();

        if ($transaction) {
            $transaction->allDelivered = $transaction->transactionDetails->every(function ($detail) {
                return $detail->arrive;
            });

            $transaction->anyDelivered = $transaction->transactionDetails->contains(function ($detail) {
                return $detail->arrive;
            });
        }

        return view('pages.transaction.detail', compact('transaction'));
    }

    public function paidTransaction(Request $request, $id)
    {
        $transaction = Transaction::find($id);
        $transaction->payment_method = $request->input('payment_method');
        $transaction->status = 'Paid';
        $transaction->save();

        return redirect()->route('transaction.index')->with('toast_success', 'Transaction status has been updated to paid');
    }

    public function arriveTransaction(Request $request)
    {
        $deliveredItemIds = $request->input('delivered_items', []);

        foreach($deliveredItemIds as $ids){
            $transactionDetail = TransactionDetail::where('id', $ids)->first();
            $transactionDetail->arrive = true;
            $transactionDetail->save();

            $transaction = Transaction::where('id', $transactionDetail->transaction_id)->first();
            $transaction->updated_at = now();
            $transaction->save();
        }

        return redirect()->route('transaction.index')->with('toast_success', 'Selected items have been marked as delivered.');
    }

    public function cancelTransaction($id){
        $transaction = Transaction::find($id)->first();
        $transaction->status = 'Cancel';
        $transaction->save();

        return redirect()->route('transaction.index')->with('toast_success', 'Transaction status has been updated to cancelled.');
    }
}
