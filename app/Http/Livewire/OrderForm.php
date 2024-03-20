<?php

namespace App\Http\Livewire;

use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use Carbon\Carbon;
use Livewire\Component;
use Illuminate\Database\Eloquent\Collection;

class OrderForm extends Component
{
    public Order $order;

    public Collection $allProducts;

    public array $orderProducts = [];

    public bool $editing = false;

    public array $listsForFields = [];

    public int $taxesPercent = 0;

    public function mount(Order $order)
    {
        $this->order = $order;

        if ($this->order->exists) {
            $this->editing = true;

            foreach ($this->order->products()->get() as $product) {
                $this->orderProducts[] = [
                    'product_id' => $product->id,
                    'quantity' => $product->pivot->quantity,
                    'product_name' => $product->name,
                    'product_price' => number_format($product->pivot->price / 100, 2),
                    'is_saved' => 'true'
                ];
            }
        } else {
            $this->order->order_date = date('m-d-Y');
        }

        $this->inListsForFields();


        $this->taxesPercent = config('app.orders.taxes');
    }

    public function addProduct()
    {
        foreach ($this->orderProducts as $key => $product) {
            if (!$product['is_saved']) {
                $this->addError('orderProducts.' . $key, 'This line must be saved before creating a new one.');
                return;
            }
        }

        $this->orderProducts[] = [
            'product_id' => '',
            'quantity' => 1,
            'is_saved' => false,
            'product_id' => '',
            'product_price' => 0,
        ];
    }

    public function saveProduct($index)
    {
        $this->resetErrorBag();
        $product = $this->allProducts->find($this->orderProducts[$index]['product_id']);
        $this->orderProducts[$index]['product_name'] = $product->name;
        $this->orderProducts[$index]['product_price'] = $product->price;
        $this->orderProducts[$index]['is_saved'] = true;
    }

    public function editProduct($index)
    {
        foreach ($this->orderProducts as $key => $editProduct) {
            if (!$editProduct['is_saved']) {
                $this->addError('$this->orderProducts' . $key, 'This line must be saved before creating a new one.');
                return;
            }
        }

        $this->orderProducts[$index]['is_saved'] = false;
    }

    public function removeProduct($index)
    {
        unset($this->orderProducts[$index]);
        $this->orderProducts == array_values($this->orderProducts);
    }

    public function save()
    {
        $this->validate();

        $this->order->subtotal = $this->order->subtotal * 100;

        $this->order->total = $this->order->total * 100;

        $this->order->taxes = $this->order->taxes * 100;

        $this->order->order_date = Carbon::parse($this->order->order_date)->format('Y-m-d');

        $this->order->save();

        $products = [];

        foreach ($this->orderProducts as $product) {
            $products[$product['product_id']] = ['price' => $product['product_price'] * 100, 'quantity' => $product['quantity']];
        }

        $this->order->products()->sync($products);

        return redirect()->route('orders.index');
    }

    public function render()
    {
        $this->order->subtotal = 0;

        foreach ($this->orderProducts as $orderProduct) {
            if ($orderProduct['is_saved'] && $orderProduct['quantity'] && $orderProduct['product_price']) {
                $this->order->subtotal +=  $orderProduct['quantity'] * $orderProduct['product_price'];
            }
        }

        $this->order->total = $this->order->subtotal * (1 + $this->taxesPercent / 100);
        $this->order->taxes  = $this->order->total - $this->order->subtotal;

        return view('livewire.order-form');
    }

    public function rules()
    {
        return [
            'order.user_id' => ['required', 'integer', 'exists:users,id'],
            'order.order_date' => ['required', 'date'],
            'order.subtotal' => ['required', 'numeric'],
            'order.taxes' => ['required', 'numeric'],
            'order.total' => ['required', 'numeric'],
            'orderProducts' => ['array']
        ];
    }

    protected function inListsForFields()
    {
        $this->listsForFields['users'] = User::pluck('name', 'id')->toArray();

        $this->allProducts = Product::all();
    }
}
