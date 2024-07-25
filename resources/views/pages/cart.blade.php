@extends('layouts.user')

@section('title')
    Cart
@endsection

@section('content')
    <div class="mb-28 mt-4 text-gray-500">
        <div class="px-4 mt-4 md:px-40">
            <div class="md:grid md:grid-cols-3">
                @forelse ($cart as $item)
                    <div id="cart-item-{{ $item->id }}"
                        class="bg-white py-4 rounded-xl flex flex-row gap-2 items-center justify-between px-4 mb-3 shadow-sm">
                        <div class="w-6/12 leading-1">
                            <div class="font-semibold text-lg">
                                {{ $item->product->name }}
                            </div>
                            <div class="text-sm">{{ 'Rp ' . number_format($item->product->price, 0, ',', '.') }}</div>
                        </div>
                        <div class="w-4/12 flex items-center justify-center">
                            <div class="flex items-center justify-center">
                                <button class="w-6 h-6 bg-white border rounded-full flex justify-center items-center"
                                    onclick="decrementQuantity({{ $item->id }})" data-item-id="{{ $item->id }}"><i
                                        class="fa-solid fa-minus text-xs"></i></button>
                                <div id="quantity_{{ $item->id }}" class="px-4">
                                    {{ $item->quantity }}
                                </div>
                                <button class="w-6 h-6 bg-white border rounded-full flex justify-center items-center"
                                    onclick="incrementQuantity({{ $item->id }})" data-item-id="{{ $item->id }}"><i
                                        class="fa-solid fa-plus text-xs"></i></button>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="flex flex-col gap-2 justify-center mt-10 text-center">
                        <img src="{{ asset('images/empty.png') }}" alt="">
                        <div class="text-red-500 text-xl tracking-widest font-semibold">Tidak ada Menu. <br>
                            <span class="text-lg tracking-normal">
                                Silahkan memilih Menu terlebih dahulu!
                            </span>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
        @if ($cart->isNotEmpty())
            <div class="px-4 md:px-40">
                <form action="{{ route('checkout') }}" method="POST">
                    @csrf
                    <div class="flex flex-col gap-2 mt-2">
                        <label for="">Nama Pemesan</label>
                        <input type="text" name="name" class="w-full border px-4 py-2 rounded-md"
                            placeholder="Masukkan Nama Pemesan">
                    </div>
                    <button id="checkout-button"
                        class="w-full bg-primary text-white px-4 py-2 rounded-md mt-4 block text-center"
                        type="submit">Checkout</button>
                </form>
            </div>
        @endif
    </div>
@endsection

@push('addon-script')
    <script>
        function incrementQuantity(itemId) {
            let quantityDiv = document.getElementById('quantity_' + itemId);
            let currentValue = parseInt(quantityDiv.textContent);
            let newItemQuantity = currentValue + 1;

            updateCartItemQuantity(itemId, newItemQuantity);
        }

        function decrementQuantity(itemId) {
            let quantityDiv = document.getElementById('quantity_' + itemId);
            let currentValue = parseInt(quantityDiv.textContent);
            if (currentValue > 1) {
                let newItemQuantity = currentValue - 1;
                updateCartItemQuantity(itemId, newItemQuantity);
            } else {
                removeCartItem(itemId);
            }
        }

        function updateCartItemQuantity(itemId, newQuantity) {
            fetch(`/update-cart-item/${itemId}`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        quantity: newQuantity
                    })
                })
                .then(response => response.json())
                .then(data => {
                    // Update the quantity display
                    document.getElementById('quantity_' + itemId).textContent = data.quantity;
                })
                .then(checkCartStatus)
                .catch(error => {
                    console.error('Error:', error);
                });
        }

        function removeCartItem(itemId) {
            fetch(`/remove-cart-item/${itemId}`, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                })
                .then(response => {
                    if (response.ok) {
                        // Remove item from the DOM
                        document.getElementById('cart-item-' + itemId).remove();
                        checkCartStatus();
                    } else {
                        console.error('Error removing item from cart');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        }

        function checkCartStatus() {
            const cartItems = document.querySelectorAll('.md:grid .bg-white');
            const checkoutButton = document.getElementById('checkout-button');

            if (cartItems.length === 0) {
                checkoutButton.disabled = true;
            } else {
                checkoutButton.disabled = false;
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            checkCartStatus();
        });
    </script>
@endpush
