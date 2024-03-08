<?php

namespace App\Http\Livewire;

use App\Models\Category;
use App\Models\Country;
use App\Models\Product;
use Livewire\Component;

class ProductForm extends Component
{
    public Product $product;

    public bool $editing = false;

    public $categories = [];

    public $listForFields = [];

    public function mount(Product $product)
    {
        $this->product = $product;

        $this->inlistForFields();

        if ($this->product->exists) {
            $this->editing = true;

            $this->product->price = number_format($this->product->price / 100, 2);

            $this->categories = $this->product->categories()->pluck('category_id')->toArray();
        }
    }

    public function save()
    {

        $this->validate();

        $this->product->price  = $this->product->price * 100;

        $this->product->save();

        $this->product->categories()->sync($this->categories);

        return redirect()->route('products.index');
    }

    public function render()
    {
        return view('livewire.product-form');
    }

    public function rules()
    {
        return [
            'product.name' => ['required', 'string'],
            'product.description' => ['required'],
            'product.price' => ['required'],
            'product.country_id' => ['required', 'integer', 'exists:countries,id'],
            'categories' => ['array']
        ];
    }
    protected function inlistForFields()
    {
        $this->listForFields['countries'] = Country::pluck('name', 'id')->toArray();
        $this->listForFields['categories'] = Category::where('is_active', true)->pluck('name', 'id')->toArray();
    }
}
