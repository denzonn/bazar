<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @stack('prepend-style')
    @include('includes.style')
    @stack('addon-style')

    <title>
        @yield('title')
    </title>

</head>

<body class="bg-[#F4F7FE]">
    <div class="hidden md:block fixed top-0 left-0 w-[16vw] h-screen">
        <div class="bg-white w-full h-full rounded-lg px-6 pt-12 pb-6">
            @include('includes.sidebar')
        </div>
    </div>

    <div class="block md:hidden fixed top-0 left-0 w-full h-16 z-50">
        <div class="bg-white w-full h-full px-4 py-2">
            @include('includes.navbar')
        </div>
    </div>

    <div class="relative top-20 md:top-0 md:left-[19vw] px-4 md:py-10 min-h-screen md:max-w-[76vw]">
        @yield('content')
    </div>

    @stack('prepend-script')
    @include('includes.script')
    @stack('addon-script')

    @include('sweetalert::alert')
</body>

</html>
