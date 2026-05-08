<div>
    <nav class="bg-white shadow">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <div class="flex items-center space-x-8">
                    <a href="{{ url('/') }}" class="text-2xl font-bold text-indigo-600">FyberShop</a>
                    <a href="{{ url('/') }}" class="text-gray-700 hover:text-indigo-600">Home</a>
                    <a href="{{ url('/products') }}" class="text-gray-700 hover:text-indigo-600">Products</a>

                    <!-- Add Products Button only for Admin -->
                    @if(auth()->check() && auth()->user()->is_admin)
                    <a href="{{ url('/addProducts') }}"
                        class="bg-indigo-600 text-white px-3 py-2 rounded-md hover:bg-indigo-700">
                        Add Products
                    </a>
                    @endif
                </div>
                <div class="flex items-center space-x-4">
                    <form class="flex">
                        <input type="text" placeholder="Search"
                            class="rounded-l-md border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                        <button type="submit"
                            class="bg-indigo-600 text-white px-4 rounded-r-md hover:bg-indigo-700">Search</button>
                    </form>

                    <!-- Livewire Navbar Component -->
                    <livewire:navbar />
                </div>
            </div>
        </div>
    </nav>
</div>