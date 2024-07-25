<div class="fixed bottom-4 left-0 px-6 w-screen">
    <div class="bg-white w-full h-16 rounded-2xl shadow-lg flex flex-row justify-between items-center px-2 text-lg">
        <div class="">
            <a href="/" class="{{ request()->is('/*') ? 'bg-primary text-white' : '' }} text-gray-500 p-5">
                <i class="fa-solid fa-house"></i>
            </a>
        </div>
        <div class="">
            <a href="/product"
                class="{{ request()->is('product') ? 'bg-primary text-white shadow-lg' : '' }} text-gray-500 p-5 rounded-lg">
                <i class="fa-solid fa-mug-saucer"></i>
            </a>
        </div>
        <div class="">
            <a href="/cart"
                class="{{ request()->is('cart') ? 'bg-primary text-white shadow-lg' : '' }} text-gray-500 p-5 rounded-lg">
                <i class="fa-solid fa-cart-shopping"></i>
            </a>
        </div>
        <div class="">
            <a href="{{ route('logout') }}"
                onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i
                    class="fa-solid fa-right-from-bracket text-gray-500 p-5"></i></a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
        </div>
    </div>
</div>
