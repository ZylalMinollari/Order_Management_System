<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Product') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <x-primary-button class="mb-4">
                        Add Product
                    </x-primary-button>
                    <div class="overflow-hidden overflow-x-auto mb-4 min-w-full align-middle sm:rounded-md">
                        <table class="min-w-full border divide-y divide-gray-200">
                            <thead>
                                <tr>
                                    <th class="px-6 py-3 w-10 text-left bg-gray-50">
                                    </th>
                                    <th class="px-6 py-3 text-left bg-gray-50">
                                        <span
                                            class="text-xs font-medium tracking-wider leading-4 text-gray-500 uppercase">Name</span>
                                    </th>
                                    <th class="px-6 py-3 text-left bg-gray-50">
                                        <span
                                            class="text-xs font-medium tracking-wider leading-4 text-gray-500 uppercase">Categories</span>
                                    </th>
                                    <th class="px-6 py-3 text-left bg-gray-50">
                                        <span
                                            class="text-xs font-medium tracking-wider leading-4 text-gray-500 uppercase">Country</span>
                                    </th>
                                    <th class="px-6 py-3 text-left bg-gray-50">
                                        <span
                                            class="text-xs font-medium tracking-wider leading-4 text-gray-500 uppercase">Pice</span>
                                    </th>
                                    <th class="px-6 py-3 w-10 text-left bg-gray-50 w-56">
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white devide-y devide-gray-200 devide-solid">
                                @foreach ($products as $product)
                                    <tr class="bg-white">
                                        <td class="px-6">
                                            <input type="checkbox" value="{{ $product->id }}">
                                        </td>
                                        <td class="px-6 py-4 text-sm leading-5 text-gray-900 whitespace-no-wrap">
                                            {{$product->name}}
                                        </td>
                                        <td class="px-6 py-4 text-sm leading-5 text-gray-900 whitespace-no-wrap">
                                            @foreach ($product->categories as $category)
                                            <span
                                            class="px-2 py-1 text-xs text-indigo-700 bg-indigo-200 rounded-md">{{$category->name}}</span>
                                            @endforeach
                                        </td>
                                        <td class="px-6 py-4 text-sm leading-5 text-gray-900 whitespace-no-wrap">
                                            {{$product->country->name}}
                                        </td>
                                        <td class="px-6 py-4 text-sm leading-5 text-gray-900 whitespace-no-wrap">
                                            ${{number_format ($product->price / 100 , 2)}}
                                        </td>
                                        <td>
                                            <a
                                                class="inline-flex items-center px-4 py-2 text-xs font-semibold tracking-widest text-white uppercase bg-gray-800 rounded-md border border-transparent hover:bg-gray-700">
                                                Edit
                                            </a>
                                            <button
                                                class="px-4 py-2 text-xs text-red-500 uppercase bg-red-200 rounded-md border border-transparent hover:text-red-700 hover:bg-red-300">
                                                Delete
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    {!!$products->links()!!}
                </div>
            </div>
        </div>

    </div>
</div>
