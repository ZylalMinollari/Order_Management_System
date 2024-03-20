<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Orders') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{-- <x-primary-button class="mb-4">
                        Create Order
                    </x-primary-button> --}}
                    <a href="{{ route('order.create') }}"
                    class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">Add
                    Order</a>
                    <div class="mb-4 mt-4">
                        <button wire:click="deleteConfirm('deleteSelected')"
                                wire:loading.atr="disabled"
                                @disabled(!$this->selectedCount)
                                class="px-4 py-2 mr-5 text-xs text-red-500 uppercase bg-red-200 rounded-md border border-transparent hover:text-red-700 hover:bg-red-300 disabled:opacity-50 disabled:cursor-not-allowed">
                            Delete Selected
                        </button>
                    </div>

                    <div class="overflow-hidden overflow-x-auto mb-4 min-w-full align-middle sm:rounded-md">
                        <table class=" min-w-full border divide-y divide-gray-200">
                            <thead>
                                <tr>
                                    <th class="px-6 py-3 w-10 text-left bg-gray-50">
                                    </th>
                                    <th wire:click="sortByColumn('orders.order_date')"
                                        class="px-6 py-3 text-left bg-gray-50">
                                        <span
                                            class="text-xs font-medium tracking-wider leading-4 text-gray-500 uppercase">Order
                                            Date</span>
                                        @if ($sortColumn == 'orders.order_date')
                                            @include('svg.sort-' . $sortDirection)
                                        @else
                                            @include('svg.sort')
                                        @endif    
                                    </th>

                                    <th
                                        class="px-6 py-3 text-left bg-gray-50">
                                        <span
                                            class="text-xs font-medium tracking-wider leading-4 text-gray-500 uppercase">User
                                            Name</span>   
                                    </th>
                                    <th class="px-6 py-3 text-left bg-gray-50 w-fit">
                                        <span
                                            class="text-xs font-medium tracking-wider leading-4 text-gray-500 uppercase">Products</span>
                                    </th>
                                    <th wire:click="sortByColumn('orders.subtotal')"
                                        class="px-6 py-3 text-left bg-gray-50">
                                        <span
                                            class="text-xs font-medium tracking-wider leading-4 text-gray-500 uppercase">Subtotal</span>
                                        @if ($sortColumn == 'orders.subtotal')
                                            @include('svg.sort-' . $sortDirection)
                                        @else
                                            @include('svg.sort')
                                        @endif 
                                    </th>
                                    <th wire:click="sortByColumn('orders.taxes')"
                                        class="px-6 py-3 text-left bg-gray-50">
                                        <span
                                            class="text-xs font-medium tracking-wider leading-4 text-gray-500 uppercase">Taxes</span>
                                        @if ($sortColumn == 'orders.taxes')
                                            @include('svg.sort-' . $sortDirection)
                                        @else
                                            @include('svg.sort')
                                        @endif    
                                    </th>
                                    <th wire:click="sortByColumn('orders.total')"
                                        class="px-6 py-3 text-left bg-gray-50">
                                        <span
                                            class="text-xs font-medium tracking-wider leading-4 text-gray-500 uppercase">Total</span>
                                        @if ($sortColumn == 'orders.total')
                                            @include('svg.sort-' . $sortDirection)
                                        @else
                                            @include('svg.sort')
                                        @endif    
                                    </th>
                                    <th class="px-6 py-3 text-left bg-gray-50 w-44">
                                    </th>
                                </tr>
                                <tr class="bg-gray-50">
                                    <td></td>
                                    <td class="px-1 py-1 text-sm">
                                        <div class="text-black">
                                            From
                                            <input x-data x-init="new Pikaday({ field: $el, format: 'MM/DD/YYYY' })"
                                                wire:model.lazy="searchQuery.order_date.0" type="text"
                                                placeholder="MM/DD/YYYY"
                                                class="mr-2 w-full text-sm text-black rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                        </div>
                                        <div class="text-black">
                                            to
                                            <input x-data x-init="new Pikaday({ field: $el, format: 'MM/DD/YYYY' })"
                                                wire:model.lazy="searchQuery.order_date.1" type="text"
                                                placeholder="MM/DD/YYYY"
                                                class="w-full text-sm text-black rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                        </div>
                                    </td>
                                    <td class="px-2 py-1">
                                        <input wire:model.lazy="searchQuery.username" placeholder="Search..."
                                            type="text"
                                            class="w-full text-sm text-black rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                    </td>
                                    <td></td>
                                    <td class="px-1 py-1 text-sm">
                                        <div class="text-black">
                                            From
                                            <input wire:model.lazy="searchQuery.subtotal.0" type="number"
                                                class="mr-2 w-full text-sm text-black rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                        </div>
                                        <div class="text-black">
                                            to
                                            <input wire:model="searchQuery.subtotal.1" type="number"
                                                class="w-full text-sm text-black rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                        </div>
                                    </td>
                                    <td class="px-1 py-1 text-sm">
                                        <div class="text-black">
                                            From
                                            <input wire:model="searchQuery.taxes.0" type="number"
                                                class="mr-2 w-full text-sm text-black rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                        </div>
                                        <div class="text-black">
                                            to
                                            <input wire:model="searchQuery.taxes.1" type="text"
                                                class="w-full text-sm text-black rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                        </div>
                                    </td>
                                    <td class="px-1 py-1 text-sm">
                                        <div class="text-black">
                                            From
                                            <input wire:model="searchQuery.total.0" type="number"
                                                class="mr-2 w-full text-sm text-black rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                        </div>
                                        <div class="text-black">
                                            to
                                            <input wire:model="searchQuery.total.1" type="text"
                                                class="w-full text-sm text-black rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                        </div>
                                    </td>
                                    <td></td>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200 divide-solid">
                                @foreach ($orders as $order)
                                    <tr class="bg-white">
                                        <td class="px-4 py-2 text-sm leading-5 text-gray-900 whitespace-no-wrap">
                                            <input type="checkbox" value="{{ $order->id }}" wire:model="selected">
                                        </td>
                                        <td class="px-6 py-4 text-sm leading-5 text-gray-900 whitespace-no-wrap">
                                            {{ $order->order_date }}
                                        </td>
                                        <td class="px-6 py-4 text-sm leading-5 text-gray-900 whitespace-no-wrap">
                                            {{ $order->username }}
                                        </td>
                                        <td class="px-6 py-4 text-sm leading-5 text-gray-900 whitespace-no-wrap">
                                            @foreach ($order->products as $product)
                                                <span
                                                    class="px-2 py-1 text-xs text-indigo-700 bg-indigo-200 rounded-md">{{ $product->name }}</span>
                                            @endforeach
                                        </td>
                                        <td class="px-6 py-4 text-sm leading-5 text-gray-900 whitespace-no-wrap">
                                            ${{ number_format($order->subtotal / 100, 2) }}
                                        </td>
                                        <td class="px-6 py-4 text-sm leading-5 text-gray-900 whitespace-no-wrap">
                                            ${{ number_format($order->taxes / 100, 2) }}
                                        </td>
                                        <td class="px-6 py-4 text-sm leading-5 text-gray-900 whitespace-no-wrap">
                                            ${{ number_format($order->total / 100, 2) }}
                                        </td>
                                        <td>
                                            <a href="{{route('order.edit', $order->id)}}"
                                                class="inline-flex items-center px-4 py-2 text-xs font-semibold tracking-widest text-white uppercase bg-gray-800 rounded-md border border-transparent hover:bg-gray-700">
                                                Edit
                                            </a>
                                            <button wire:click="deleteConfirm('delete', {{ $order->id }})"
                                                class="px-4 py-2 text-xs text-red-500 uppercase bg-red-200 rounded-md border border-transparent hover:text-red-700 hover:bg-red-300">
                                                Delete
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                    </div>
                    {!! $orders->links() !!}
                </div>
            </div>
            <div class="overflow-hidden overflow-x-auto mb-4 min-w-full align-middle sm:rounded-md">

            </div>
        </div>
    </div>
</div>
@push('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/pikaday/pikaday.js"></script>
@endpush
