<?php

namespace App\Http\Livewire;

use App\Models\Product;
use Livewire\Component;
use Livewire\WithPagination;

class ProductList extends Component
{
    use WithPagination;

    public function render()
    {
        $products = Product::paginate(10);
        return view(
            'livewire.product-list',
            [
                'products' => $products,
            ],
        );
    }
}