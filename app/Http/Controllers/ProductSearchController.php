<?php

namespace App\Http\Controllers;

use App\Models\AddProduct;
use Illuminate\Http\Request;

class ProductSearchController extends Controller
{
    public function index(Request $request)
    {
        $query = trim((string) $request->input('q'));

        $products = AddProduct::with(['categories', 'images'])
            ->when($query !== '', function ($productQuery) use ($query) {
                $productQuery->where(function ($searchQuery) use ($query) {
                    $searchQuery->where('name', 'like', "%{$query}%")
                        ->orWhere('description', 'like', "%{$query}%")
                        ->orWhereHas('categories', function ($categoryQuery) use ($query) {
                            $categoryQuery->where('name', 'like', "%{$query}%");
                        });
                });
            })
            ->latest()
            ->paginate(12)
            ->withQueryString();

        return view('results', compact('products', 'query'));
    }
}