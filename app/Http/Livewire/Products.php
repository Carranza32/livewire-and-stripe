<?php

namespace App\Http\Livewire;

use App\Facades\Cart;
use App\Models\Product;
use Livewire\Component;
use Illuminate\View\View;
use Livewire\WithPagination;

class Products extends Component
{
    use WithPagination;

    public $search;

    protected $updatesQueryString = ['search'];

    public function mount(): void
    {
        $this->search = request()->query('search', $this->search);
    }

    public function render(): View
    {
        return view('livewire.products', [
            'products' => $this->search === null ?
                Product::paginate(12) :
                Product::where('name', 'like', '%' . $this->search . '%')->paginate(12)
        ]);
    }

    public function addToCart(int $productId): void
    {
        Cart::add(Product::where('id', $productId)->first());

        session()->flash('message', 'Producto agregado.');
    }
}
