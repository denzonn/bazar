<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>

    @include('includes.style')
</head>

<body class="bg-gray-100">
    <div class="h-screen relative">
        <div class="hidden md:block absolute bottom-0 right-0 z-0 ">
            <img src="{{ asset('images/background.png') }}" alt="" class="w-[50vw] h-screen object-cover">
        </div>
        <div class="grid md:grid-cols-2 h-screen z-10 space-x-0 gap-0">
            <div class="flex flex-col justify-center px-8 md:px-20">
                <div class="text-7xl text-center font-bold leading-none">
                    Login
                </div>
                <div class="mt-8 md:pr-20">
                    <form action="{{ route('login') }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label for="email" class="block text-xl font-bold mb-2 text-primary">
                                Email
                            </label>
                            <input id="email" type="email"
                                class="bg-transparent border rounded-md w-full px-4 py-3 text-base font-medium @error('email') is-invalid @enderror"
                                placeholder="Email" name="email" value="{{ old('email') }}">
                            @error('email')
                                <span class="invalid-feedback font-medium text-red-500 mb-4" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="mb-6">
                            <label for="password" class="block text-xl font-bold mb-2 text-primary">
                                Password
                            </label>
                            <input id="password" type="password"
                                class="bg-transparent border rounded-md w-full px-4 py-3 text-base font-medium @error('password') is-invalid @enderror"
                                placeholder="Password" name="password">
                            @error('password')
                                <span class="invalid-feedback font-medium text-red-500  mb-4" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div>
                            <button type="submit"
                                class="bg-primary text-white px-4 py-3 w-full rounded-lg font-semibold">SUBMIT</button>
                        </div>
                    </form>
                    <div class="text-center mt-3">Dont have an account? <a href="/register" class="text-primary">
                            Register</a></div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
