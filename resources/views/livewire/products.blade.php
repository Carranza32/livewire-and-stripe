<div>
    <div>
        @if (session()->has('message'))
            <div class="w-full text-white bg-emerald-500">
                <div class="container flex items-center justify-between px-6 py-4 mx-auto">
                    <div class="flex">
                        <svg viewBox="0 0 40 40" class="w-6 h-6 fill-current">
                            <path d="M20 3.33331C10.8 3.33331 3.33337 10.8 3.33337 20C3.33337 29.2 10.8 36.6666 20 36.6666C29.2 36.6666 36.6667 29.2 36.6667 20C36.6667 10.8 29.2 3.33331 20 3.33331ZM16.6667 28.3333L8.33337 20L10.6834 17.65L16.6667 23.6166L29.3167 10.9666L31.6667 13.3333L16.6667 28.3333Z">
                            </path>
                        </svg>

                        <p class="mx-3">{{ session('message') }}</p>
                    </div>

                    <button class="p-1 transition-colors duration-300 transform rounded-md hover:bg-opacity-25 hover:bg-gray-600 focus:outline-none">
                        <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M6 18L18 6M6 6L18 18" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </button>
                </div>
            </div>
        @endif
    </div>

    <div class="w-full flex justify-center">
        <input wire:model="search" type="text" class="shadow appearance-none border rounded w-1/2 py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Search products by name...">
    </div>

    <section class="w-fit mx-auto grid grid-cols-1 lg:grid-cols-3 md:grid-cols-3 gap-y-20 gap-x-14 justify-items-center justify-center mt-10 mb-5">
        @foreach ($products as $product)
            <div class="w-72 bg-white shadow-md rounded-xl duration-500 hover:scale-105 hover:shadow-xl">
                <img src="https://images.unsplash.com/photo-1646753522408-077ef9839300?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwcm9maWxlLXBhZ2V8NjZ8fHxlbnwwfHx8fA%3D%3D&auto=format&fit=crop&w=500&q=60" alt="Product" class="h-80 w-72 object-cover rounded-t-xl" />
                <div class="px-4 py-3 w-72 rounded-b-xl">
                    <span class="text-gray-400 mr-3 uppercase text-xs">Brand</span>
                    <p class="text-lg font-bold text-black truncate block capitalize">{{ $product->name }}</p>
                    <div class="flex item-center justify-between mt-3">
                        <p class="text-lg font-semibold text-black cursor-auto my-3">${{ $product->price }}</p>
                        <button wire:click="addToCart({{ $product->id }})" class="px-3 py-0 bg-gray-800 text-white text-xs font-bold uppercase rounded-lg">
                            Agregar
                        </button>
                    </div>
                </div>
            </div>
        @endforeach
    </section>

    <div class="w-full flex justify-center pb-6">
        {{ $products->links() }}
    </div>
</div>
