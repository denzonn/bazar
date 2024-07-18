<div class="flex flex-row h-full justify-between text-gray-600">
    <!-- Dropdown for Mobile -->
    <div class="md:hidden">
        <button id="menuButton" class="py-2 px-4 bg-secondary text-third font-semibold rounded-md">
            <i class="fa-solid fa-bars"></i> Menu
        </button>
        <div id="menuItems" class="hidden flex flex-col bg-white rounded-md shadow-md mt-2">
            <a href="/admin/dashboard" class="py-2 px-4 hover:bg-secondary hover:text-third transition">Dashboard</a>
            <a href="/admin/category" class="py-2 px-4 hover:bg-secondary hover:text-third transition">Category</a>
            <a href="/admin/product" class="py-2 px-4 hover:bg-secondary hover:text-third transition">Product</a>
            <a href="/admin/transaction" class="py-2 px-4 hover:bg-secondary hover:text-third transition">Transaction</a>
            <a href="{{ route('logout') }}"
                onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                class="py-2 px-4 hover:bg-red-500 hover:text-white transition">Logout</a>
        </div>
    </div>
</div>

<script>
    const menuButton = document.getElementById('menuButton');
    const menuItems = document.getElementById('menuItems');

    menuButton.addEventListener('click', () => {
        menuItems.classList.toggle('hidden');
    });
</script>
