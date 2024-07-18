<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Shopping Cart</title>

    @include('includes.style')
    @include('includes.script')
</head>

<body class="bg-[#F4F7FE]">
    <div class="">
        <div class="bg-primary px-4 py-3 text-white text-2xl"><i class="fa-solid fa-cart-shopping"></i> Cart</div>
        <div class="px-4 mt-4 md:px-40">
            <div class="md:grid md:grid-cols-3">
                @forelse ($cart as $item)
                <div id="cart-item-{{ $item->id }}" class="bg-white py-4 rounded-xl flex flex-row gap-2 items-center justify-between px-2 mb-2">
                    <div class="w-2/12">
                        <img src="{{ Storage::url($item->product->photo) }}" alt=""
                            class="w-full h-32 object-cover scale-x-110">
                    </div>
                    <div class="w-6/12">
                        <div class="font-semibold text-xl mt-2">
                            {{ $item->product->name }}
                        </div>
                        <div>{{ 'Rp ' . number_format($item->product->price, 0, ',', '.') }}</div>
                    </div>
                    <div class="w-4/12 flex items-center justify-center">
                        <div class="flex items-center justify-center">
                            <button class="w-8 h-8 bg-primary text-white rounded-l-md"
                                onclick="decrementQuantity({{ $item->id }})"
                                data-item-id="{{ $item->id }}">-</button>
                            <input type="number" id="quantity_{{ $item->id }}" name="quantity" min="1"
                                value="{{ $item->quantity }}" class="border py-1 text-center w-10 md:w-16">
                            <button class="w-8 h-8 bg-primary text-white rounded-r-md"
                                onclick="incrementQuantity({{ $item->id }})"
                                data-item-id="{{ $item->id }}">+</button>
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-red-500">Belum Ada Pesanan</div>
            @endforelse
            </div>
        </div>
        <div class="px-4 md:px-40">
            <form action="{{ route('checkout') }}" method="POST">
                @csrf
                <div class="flex flex-col gap-2 mt-2">
                    <label for="">Nama Pemesan</label>
                    <input type="text" name="name" class="w-full border px-4 py-2 rounded-md"
                        placeholder="Masukkan Nama Pemesan">
                </div>
                <div class="flex flex-col gap-2 mt-2">
                    <label for="">Nomor Meja</label>
                    <select name="table" id="" class="w-full border px-4 py-2 rounded-md">
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                        <option value="7">7</option>
                        <option value="8">8</option>
                    </select>
                </div>
                <button class="w-full bg-primary text-white px-4 py-2 rounded-md mt-4 block text-center"
                    type="submit" {{ $cart->isNotEmpty() ? '' : 'disabled' }} >Checkout</button>
            </form>
        </div>
    </div>

    <script>
        function incrementQuantity(itemId) {
            let input = document.getElementById('quantity_' + itemId);
            let currentValue = parseInt(input.value);
            let newItemQuantity = currentValue + 1;

            updateCartItemQuantity(itemId, newItemQuantity);
        }

        function decrementQuantity(itemId) {
            let input = document.getElementById('quantity_' + itemId);
            let currentValue = parseInt(input.value);
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
                    // Update input field value
                    document.getElementById('quantity_' + itemId).value = data.quantity;
                })
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
                    } else {
                        console.error('Error removing item from cart');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        }
    </script>
</body>

</html>
