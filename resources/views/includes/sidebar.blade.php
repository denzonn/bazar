<div class="flex flex-col h-full justify-between text-gray-600 relative">
    <ul class="flex flex-col gap-4 menu text-base">
        <a href="/admin/dashboard"
            class="{{ request()->is('admin/dashboard*') ? 'bg-primary text-white' : '' }} py-2 px-6 rounded-md  hover:bg-primary hover:text-white transition">
            <div class="flex flex-row gap-2 items-center"><i class="fa-solid fa-house"></i> Dashboard</div>
        </a>
        <a href="/admin/category"
            class="{{ request()->is('admin/category') ? 'bg-primary text-white' : '' }} py-2 px-6 rounded-md  hover:bg-primary hover:text-white transition">
            <div class="flex flex-row gap-2 items-center"><i class="fa-solid fa-clipboard-list"></i> Category</div>
        </a>
        <a href="/admin/product"
            class="{{ request()->is('admin/product*') ? 'bg-primary text-white' : '' }} py-2 px-6 rounded-md  hover:bg-primary hover:text-white transition">
            <div class="flex flex-row gap-2 items-center"><i class="fa-solid fa-mug-saucer"></i>Product</div>
        </a>
        <a href="/admin/transaction"
            class="{{ request()->is('admin/transaction*') ? 'bg-primary text-white' : '' }} py-2 px-6 rounded-md  hover:bg-primary hover:text-white transition">
            <div class="flex flex-row gap-2 items-center"><i class="fa-solid fa-clock-rotate-left"></i>Transaction</div>
        </a>
    </ul>
    <div>
        <ul>
            <li class="py-2 rounded-md px-6 hover:bg-red-500 hover:text-white  transition">
                <a href="{{ route('logout') }}"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i
                        class="fa-solid fa-right-from-bracket pr-1"></i> Logout</a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </li>
        </ul>
    </div>
    <div class="absolute top-1/2 left-0">
        <img src="{{ asset('images/logo.png') }}" alt="">
    </div>
</div>
