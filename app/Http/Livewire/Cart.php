<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Facades\Cart as CartFacade;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class Cart extends Component
{
    public $cart;
    public $total;

    public function mount(): void
    {
        $this->cart = CartFacade::get();
    }

    public function render()
    {
        $this->total = $this->getTotal();

        return view('livewire.cart');
    }

    public function removeFromCart($productId): void
    {
        CartFacade::remove($productId);
        $this->cart = CartFacade::get();
    }

    public function getTotal(): string
    {
        $total = 0;

        foreach ($this->cart['products'] as $product) {
            $total += $product?->price * $product?->amount;
        }

        return number_format($total, 2, ',', '.');
    }
}
