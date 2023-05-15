<?php

namespace App\Repositories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class ProductRepository
{
    /**
     * Get all products
     *
     * @param Request $request
     * @return Collection
     */
    public function getAllProducts(Request $request): Collection
    {
        // base query
        $query = Product::with('category')
            ->withAvg('reviews', 'rating');

        $query = $this->applyFilters($request, $query);

        // when the sort query parameter is exist
        if ($request->has('sort')) {
            [$queryColumn, $order] = explode(':', $request->query('sort'));

            // using join since the category is a relation
            if ($queryColumn === 'category') {
                $query->join('categories', 'categories.id', '=', 'products.category_id')
                    ->select('products.*');
            }

            $sortColumn = $this->mapSortColumn($queryColumn);
            $query->orderBy($sortColumn, $order);
        }
        return $query->get();
    }

    /**
     * Apply filter
     *
     * @param Request $request
     * @param Builder $query
     * @return mixed
     */
    private function applyFilters(Request $request, Builder $query): mixed
    {
        $request->whenHas('category', function (string $input) use ($query) {
            $query->whereIn('category_id', explode(",", $input));
        });
        $request->whenHas('price', function (string $input) use ($query) {
            $query->whereBetween('price', explode(",", $input));
        });
        $request->whenHas('availability', function (string $input) use ($query) {
            $query->where('units', '>', $input);
        });
        return $query;
    }

    /**
     * Map the query param with table column
     *
     * @param string $column
     * @return string
     */
    private function mapSortColumn(string $column): string
    {
        return match ($column) {
            'category' => 'categories.name',
            'price' => 'price',
            'availability' => 'units'
        };
    }

    /**
     * Find the product by ID
     *
     * @param int $id
     * @return Product
     */
    public function findById(int $id): Product
    {
        return Product::where('id', $id)
            ->with(['reviews.user'])
            ->withAvg('reviews', 'rating')
            ->first();
    }
}
