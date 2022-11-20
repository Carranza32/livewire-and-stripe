<div>
    <div class="">
        <div class="mx-auto bg-gray-100 shadow-lg rounded-lg">
            <div class="md:flex ">
                <div class="w-full p-4 px-5 py-5">
                    <div class="md:grid md:grid-cols-3 gap-2 ">
                        @if(count($cart['products']) > 0)
                            <div class="col-span-2 p-5">
                                <h1 class="text-xl font-medium ">Shopping Cart</h1>
                                @foreach($cart['products'] as $product)
                                    <div class="flex justify-between items-center mt-6 pt-6">
                                        <div class="flex  items-center">
                                            <img src="{{ $product->img }}" width="60" class="rounded-md ">
                                            <div class="flex flex-col ml-3">
                                                <span class="md:text-md font-medium">{{ $product->name }}</span>
                                                <span class="text-xs font-light text-gray-400">#41551</span>
                                            </div>
                                        </div>
                                        <div class="flex justify-center items-center">
                                            <div class="pr-8 flex ">
                                                <input type="text" class="focus:outline-none bg-gray-100 border h-6 w-8 rounded text-sm px-2 mx-2" disabled value="{{ $product['amount'] ?? 1 }}">
                                            </div>
                                            <div class="pr-8 ">
                                                <span class="text-xs font-medium">${{ $product->price }}</span>
                                            </div>
                                            <div>
                                                <a wire:click="removeFromCart({{ $product->id }})" class="text-green-600 font-bold py-1 px-3 rounded text-xs bg-green hover:bg-green-dark cursor-pointer">Remove</a>
                                                <i class="fa fa-times text-xs font-medium"></i>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach

                                <div class="flex justify-between items-center mt-6 pt-6 border-t">
                                    <a href="{{ route('dashboard') }}" class="flex items-center">
                                        <i class="fa fa-arrow-left text-sm pr-2"></i>
                                        <span class="text-md  font-medium text-blue-500">Continue Shopping</span>
                                    </a>

                                    <div class="flex justify-center items-end">
                                        <span class="text-sm font-medium text-gray-400 mr-1">Subtotal:</span>
                                        <span class="text-lg font-bold text-gray-800 "> ${{ $total }}</span>
                                    </div>
                                </div>
                            </div>

                            <form id="form" action="{{ route('checkout') }}" method="post" class=" p-5 bg-gray-800 rounded overflow-visible">
                                @csrf
                                <span class="text-xl font-medium text-gray-100 block pb-3">Card Details</span>
                                <span class="text-xs text-gray-400 ">Card Type</span>
                                <div class="overflow-visible flex justify-between items-center mt-2">
                                    <div class="rounded w-52 h-28 bg-gray-500 py-2 px-4 relative right-10">
                                        <span class="italic text-lg font-medium text-gray-200 underline">VISA</span>
                                        <div class="flex justify-between items-center pt-4 ">
                                            <span class="text-xs text-gray-200 font-medium">****</span>
                                            <span class="text-xs text-gray-200 font-medium">****</span>
                                            <span class="text-xs text-gray-200 font-medium">****</span>
                                            <span class="text-xs text-gray-200 font-medium">****</span>
                                        </div>
                                        <div class="flex justify-between items-center mt-3">
                                            <span class="text-xs  text-gray-200">Giga Tamarashvili</span>
                                            <span class="text-xs  text-gray-200">12/18</span>
                                        </div>
                                    </div>

                                    <div class="flex justify-center  items-center flex-col">
                                        <img src="https://img.icons8.com/color/96/000000/mastercard-logo.png" width="40" class="relative right-5" />
                                        <span class="text-xs font-medium text-gray-200 bottom-2 relative right-5">mastercard.</span>
                                    </div>
                                </div>

                                <input type="hidden" name="payment_method" class="payment-method">

                                <div class="flex justify-center flex-col pt-3">
                                    <label class="text-xs text-gray-400 mb-3">Name on Card</label>
                                    <input name="card_holder_name" type="text" class="focus:outline-none w-full h-6 bg-gray-800 text-white placeholder-gray-300 text-sm border-b border-gray-600 py-4" placeholder="Giga Tamarashvili">
                                </div>

                                <div class="flex justify-center flex-col pt-3">
                                    <label class="text-xs text-gray-400 mb-3">Card Details</label>
                                    <div id="card-element"></div>
                                </div>

                                <button type="submit" class="pay h-12 mt-10 w-full bg-blue-500 rounded focus:outline-none text-white hover:bg-blue-600">Check Out</button>
                            </form>
                        @else
                            <div class="text-center w-full border-collapse p-6">
                                <span class="text-lg">¡Your cart is empty!</span>
                            </div>
                        @endif
                    </div>
               </div>
            </div>
        </div>
    </div>
</div>
