<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>

    @include('includes.style')
    @include('includes.script')
</head>

<body class="bg-[#F4F7FE]">
    <div class="">
        <div class="bg-primary px-4 py-3 text-white text-2xl text-end">
            <a href="/cart" class="text-end"><i class="fa-solid fa-cart-shopping"></i></a>
        </div>
        @foreach ($categories as $category)
            <div class="p-6">
                <div class="text-2xl font-semibold text-primary mb-4">{{ $category->name }}</div>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    @foreach ($category->products as $item)
                        @php
                            $rating = mt_rand(450, 500) / 100;
                        @endphp
                        <div class="bg-white px-1 py-4 rounded-xl h-fit relative">
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
                </div>
            </div>
        @endforeach
    </div>
</body>
@include('sweetalert::alert')

</html>
