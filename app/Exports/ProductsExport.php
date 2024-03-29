<?php

namespace App\Exports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ProductsExport implements FromCollection, WithHeadings, WithMapping
{
    /**
     * @return \Illuminate\Support\Collection
     */

    public function __construct(private array $productIds)
    {
    }

    public function headings(): array
    {
        return [
            'Name',
            'Categories',
            'Country',
            'Price',
        ];
    }

    public function map($product): array
    {

        return [
            $product->name,
            $product->categories->pluck('name')->implode(','),
            $product->country->name,
            '$' . number_format($product->price, 2),
        ];
    }

    public function collection()
    {
        return Product::with('categories', 'country')->find($this->productIds);
    }
}
