<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Bazaar</title>
    @include('includes.style')
</head>

<body>
    <div class="relative w-screen h-screen bg-black">
        <div class="relative">
            <img src="{{ asset('images/welcome.png') }}" alt="" class="-translate-y-10">
            <div class="absolute translate-y-10 inset-0 bg-gradient-to-t from-black to-transparent"></div>
        </div>
        <div
            class="absolute bottom-0 left-0 w-screen h-[40%] bg-[#1bae7686] text-white text-center px-6 flex flex-col items-center justify-center">
            <div class="text-3xl">
                Elevate your coffee experience at Bazaar
            </div>
            <div class="text-sm mt-2 text-gray-300">
                Where coffee meets comfort.
            </div>
            <div class="mt-8">
                <a href="/login" class="bg-white text-primary font-semibold px-8 py-3 rounded-lg">
                    Get Started
                </a>
            </div>
        </div>
    </div>

    @include('includes.script')
    @include('sweetalert::alert')
</body>

</html>
