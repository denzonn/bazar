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
        <div class="text-center bg-primary text-white text-3xl font-semibold py-2">
            Menu Bazar
            <div class="text-lg tracking-widest font-medium text-gray-200">Road to Festival</div>
        </div>
        @foreach ($categories as $category)
            <div class="p-6">
                <div class="text-2xl font-semibold text-primary mb-4">{{ $category->name }}</div>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    @foreach ($category->products as $item)
                        @php
                            $rating = mt_rand(450, 500) / 100;
                        @endphp
                        <div class="bg-white px-1 py-4 rounded-xl text-center relative">
                            <div class="absolute top-3 left-3">
                                <i class="fa-solid fa-star text-yellow-400">
                                    <span class="text-xs text-gray-500">{{ $rating }}</span>
                                </i>
                            </div>
                            <div class="w-full">
                                <img src="{{ Storage::url($item->photo) }}" alt=""
                                    class="w-full h-44 object-cover scale-x-110">
                            </div>
                            <div class="font-semibold text-lg">
                                {{ $item->name }}
                            </div>
                            <div>{{ 'Rp ' . number_format($item->price, 0, ',', '.') }}</div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>
</body>

</html>
