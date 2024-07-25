<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Category;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BerandaController extends Controller
{
    public function index()
    {
        $categories = Category::with('products')->get();

        return view('pages.product', compact('categories'));
    }

    public function cart()
    {
        $cart = Cart::where('user_id', Auth::user()->id)->with(['product'])->get();

        return view('pages.cart', compact('cart'));
    }

    public function addToCart(Request $request, $id)
    {
        $product = Product::find($id);

        $cart = Cart::where('user_id', Auth::user()->id)->get();

        if ($cart->where('product_id', $product->id)->count() > 0) {
            $cartItem = $cart->where('product_id', $product->id)->first();
            $cartItem->quantity++;
            $cartItem->save();

            return redirect()->back()->with('toast_success', 'Menu sudah ada di keranjang, berhasil menambahkan quantity.');
        } else {
            Cart::create([
                'product_id' => $product->id,
                'quantity' => 1,
                'user_id' => Auth::user()->id,
            ]);
            return redirect()->back()->with('toast_success', 'Menu berhasil ditambahkan ke keranjang.');
        }
    }

    public function updateCartItem($itemId)
    {
        $data = request()->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        $cartItem = Cart::findOrFail($itemId);
        $cartItem->quantity = $data['quantity'];
        $cartItem->save();

        return response()->json([
            'quantity' => $cartItem->quantity
        ]);
    }

    public function checkout(Request $request)
    {
        $cart = Cart::where('user_id', Auth::user()->id)->with(['product'])->get();

        $date = date('d');
        $time = date('His');
        $transactionCode = 'TRX' . $date . $time;

        $total = 0;
        foreach ($cart as $item) {
            $total += $item->product->price * $item->quantity;
        }

        $transaction = Transaction::create([
            'name' => $request->input('name'),
            'total' => $total,
            'status' => 'PROSES',
            'code' => $transactionCode
        ]);

        foreach ($cart as $item) {
            TransactionDetail::create([
                'transaction_id' => $transaction->id,
                'product_id' => $item->product_id,
                'quantity' => $item->quantity,
            ]);
        }

        Cart::where('user_id', Auth::user()->id)->delete();

        return redirect()->route('product')->with('toast_success', 'Transaksi berhasil dilakukan. Silahkan tunggu pesanan anda.');
    }

    public function removeCartItem($id)
    {
        $cartItem = Cart::find($id);
        if ($cartItem) {
            $cartItem->delete();
            return response()->json(['message' => 'Item removed successfully']);
        } else {
            return response()->json(['message' => 'Item not found'], 404);
        }
    }
}
