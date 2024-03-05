<?php

namespace App\Http\Livewire;

use App\Models\Category;
use App\Models\Country;
use App\Models\Product;
use Livewire\Component;
use Livewire\WithPagination;

class ProductList extends Component
{
    use WithPagination;

    public $categories = [];

    public $countries = [];

    public $searchQuery = [
        'name' => '',
        'price' => ['', ''],
        'category_id' => 0,
        'country_id' => 0,
        'description' => ''
    ];

    public function mount()
    {
        $this->categories = Category::pluck('name', 'id')->toArray();
        $this->countries = Country::pluck('name', 'id')->toArray();
    }

    public function render()
    {
        //products = Product::paginate(10);
        $products = Product::query()
            ->select(['products.*', 'countries.id as countryId', 'countries.name as countryName'])
            ->join('countries', 'countries.id', '=', 'products.country_id')
            ->with('categories');

        foreach ($this->searchQuery as $column => $value) {
            if (!empty($value)) {
                $products->when($column == 'price', function ($products) use ($value) {
                    if (is_numeric($value[0])) {
                        $products->where('products.price', '>=', $value[0] * 100);
                    }

                    if (is_numeric($value[1])) {
                        $products->where('products.price', '<=', $value[1] * 100);
                    }
                })
                ->when($column == 'category_id', fn($products) => $products->whereRelation('categories', 'category_id', $value))
                ->when($column == 'country_id', fn($products) => $products->whereRelation('country', 'id', $value))
                ->when($column == 'name', fn($products) => $products->where('products.' . $column, 'LIKE', '%'.$value.'%' ));
            }
        }
        return view(
            'livewire.product-list',
            [
                'products' => $products->paginate(10),
            ],
        );
    }
}
