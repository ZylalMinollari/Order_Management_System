<?php

namespace App\Http\Livewire;

use App\Models\Order;
use Illuminate\Support\Carbon;
use Livewire\Component;
use Livewire\WithPagination;

class OrderList extends Component
{
    use WithPagination;

    public $selected = [];

    public $sortColumn = 'orders.order_date';

    public $sortDirection = 'asc';

    public $searchQuery = [
        'order_date' => ['', ''],
        'username' => '',
        'subtotal' => ['', ''],
        'taxes' => ['', ''],
        'total' => ['', '']
    ];

    protected $listeners = ['delete', 'deleteSelected'];

    public function sortByColumn($column)
    {
        if ($this->sortColumn == $column) {
            $this->sortDirection = $this->sortDirection == 'asc' ? 'desc' : 'asc';
        } else {
            $this->reset('sortDirection');
            $this->sortColumn = $column;
        }
    }

    public function deleteConfirm($method, $id = null)
    {
        $this->dispatchBrowserEvent('swal:confirm', [
            'type' => 'warning',
            'title' => 'Are you sure',
            'text' => '',
            'id' => $id,
            'method' => $method,
        ]);
    }

    public function delete($id)
    {
        Order::findOrFail($id)->delete();
    }

    public function deleteSelected()
    {

        $orders = Order::whereIn('id', $this->selected)->get();

        $orders->each->delete();

        $this->reset('selected');
    }



    public function getSelectedCountProperty()
    {
        return count($this->selected);
    }

    public function render()
    {
        $orders = Order::query()
            ->select(['orders.*', 'users.name as username'])
            ->join('users', 'users.id', '=', 'orders.user_id')
            ->with('products');

        foreach ($this->searchQuery as $column => $value) {
            if (!empty($value)) {
                $orders->when($column == 'order_date', function ($orders) use ($value) {
                    if (!empty($value[0])) {
                        $orders->whereDate('orders.order_date', '>=', Carbon::parse($value[0])->format('Y-m-d'));
                    }

                    if (!empty($value[1])) {
                        $orders->whereDate('orders.order_date', '<=', Carbon::parse($value[1])->format('Y-m-d'));
                    }
                })
                    ->when($column == 'username', fn ($orders) => $orders->where('users.name', 'LIKE', '%' . $value . '%'))
                    ->when($column == 'subtotal', function ($orders) use ($value) {
                        if (!empty($value[0])) {
                            $orders->where('orders.subtotal', '>=', $value[0] * 100);
                        }
                        if (!empty($value[1])) {
                            $orders->where('orders.subtotal', '<=', $value[1] * 100);
                        }
                    })
                    ->when($column == 'taxes', function ($orders) use ($value) {
                        if (!empty($value[0])) {
                            $orders->where('orders.taxes', '>=', $value[0] * 100);
                        }
                        if (!empty($value[1])) {
                            $orders->where('orders.taxes', '<=', $value[1] * 100);
                        }
                    })
                    ->when($column == 'total', function ($orders) use ($value) {
                        if (!empty($value[0])) {
                            $orders->where('orders.total', '>=', $value[0] * 100);
                        }

                        if (!empty($value[1])) {
                            $orders->where('orders.total', '<=', $value[1] * 100);
                        }
                    });
            }
        }
        $orders->orderBy($this->sortColumn, $this->sortDirection);
        return view(
            'livewire.order-list',
            [
                'orders' => $orders->paginate(10),
            ]
        );
    }
}
