@extends('layouts.user')

@section('title')
    Product
@endsection

@section('content')
    <div class="mt-4 w-full mb-20">
        <div class="flex flex-row items-center gap-2 text-sm overflow-x-auto scrolling pl-9">
            @foreach ($categories as $category)
                <div onclick="setSelected('{{ $category->name }}')" class="category-button py-2 px-3 text-base rounded-xl shadow-md"
                    data-category="{{ $category->name }}">
                    {{ $category->name }}
                </div>
            @endforeach
        </div>
        <div class="mt-4 px-9">
            <div class="grid grid-cols-2 gap-x-2 gap-y-3">
                @foreach ($categories as $category)
                    @foreach ($category->products as $item)
                        @php
                            $rating = mt_rand(450, 500) / 100;
                        @endphp
                        <div class="bg-white px-1 py-4 rounded-xl h-fit relative product-card" data-category="{{ $category->name }}">
                            <div class="absolute top-3 left-3">
                                <i class="fa-solid fa-star text-yellow-400">
                                    <span class="text-xs text-gray-500">{{ $rating }}</span>
                                </i>
                            </div>
                            <div class="w-full">
                                <img src="{{ Storage::url($item->photo) }}" alt=""
                                    class="w-full h-44 md:h-60 object-cover scale-x-110">
                            </div>
                            <div class="flex flex-row justify-between gap-2 px-2 w-full">
                                <div>
                                    <div class="font-semibold text-lg mt-2">
                                        {{ $item->name }}
                                    </div>
                                    <div>{{ 'Rp ' . number_format($item->price, 0, ',', '.') }}</div>
                                </div>
                                <div>
                                    <form action="{{ route('addToCart', $item->id) }}" method="POST" class="mt-4">
                                        @csrf
                                        <div class="flex items-center justify-center gap-2">
                                            <button type="submit" class="w-8 h-8 bg-primary text-white rounded-md"><i
                                                    class="fa-solid fa-plus"></i></button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endforeach
            </div>
        </div>
    </div>
@endsection

@push('addon-script')
    <script>
        function setSelected(category) {
            const buttons = document.querySelectorAll('.category-button');
            const products = document.querySelectorAll('.product-card');

            buttons.forEach(button => {
                if (button.getAttribute('data-category') === category) {
                    button.classList.add('bg-primary', 'text-white');
                    button.classList.remove('bg-white', 'text-gray-500');
                } else {
                    button.classList.add('bg-white', 'text-gray-500');
                    button.classList.remove('bg-primary', 'text-white');
                }
            });

            products.forEach(product => {
                if (product.getAttribute('data-category') === category) {
                    product.style.display = 'block';
                } else {
                    product.style.display = 'none';
                }
            });
        }

        document.addEventListener('DOMContentLoaded', function() {
            setSelected('Minuman'); // Default selection
        });
    </script>
@endpush
