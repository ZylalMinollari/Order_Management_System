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

    protected $listeners = ['delete', 'deleteSelected'];

    public $selected = [];

    public string $sortColumn = 'products.name';

    public string $sortDirections = 'asc';

    public $searchQuery = [
        'name' => '',
        'price' => ['', ''],
        'category_id' => 0,
        'country_id' => 0,
        'description' => ''
    ];

    public $queryToSort = [
        'sortColumn' => [
            'except' => 'products.name'
        ],
        'sortDirections' => [
            'except' => 'asc'
        ],
    ];

    public function mount()
    {
        $this->categories = Category::pluck('name', 'id')->toArray();
        $this->countries = Country::pluck('name', 'id')->toArray();
    }

    public function sortByColumn($column)
    {
        if ($this->sortColumn == $column) {
            $this->sortDirections = $this->sortDirections == 'asc' ? 'desc' : 'asc';
        } else {
            $this->reset('sortDirections');
            $this->sortColumn = $column;
        }
    }

    public function getSelectedCountProperty()
    {
        return count($this->selected);
    }

    public function deleteConfirm($method, $id = null)
    {
        $this->dispatchBrowserEvent('swal:confirm', [
            'type' => 'warning',
            'title' => 'Are you sure ?',
            'text' => '',
            'id' => $id,
            'method' => $method,
        ]);
    }

    public function delete($id)
    {
        Product::findOrFail($id)->delete();
    }

    public function deleteSelected()
    {

        //dd($this->selected);
        $products = Product::whereIn('id', $this->selected)->get();
        
        $products->each->delete();

        $this->reset('selected');
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
                    ->when($column == 'category_id', fn ($products) => $products->whereRelation('categories', 'category_id', $value))
                    ->when($column == 'country_id', fn ($products) => $products->whereRelation('country', 'id', $value))
                    ->when($column == 'name', fn ($products) => $products->where('products.' . $column, 'LIKE', '%' . $value . '%'));
            }
        }

        $products->orderBy($this->sortColumn, $this->sortDirections);

        return view(
            'livewire.product-list',
            [
                'products' => $products->paginate(10),
            ],
        );
    }
}
