<?php

namespace App\Http\Controllers;

use App\Models\AddProduct;
use App\Models\Category;

class WelcomeController extends Controller
{
    public function index()
    {
        $heroProduct = AddProduct::with(['categories', 'images'])
            ->inRandomOrder()
            ->first();

        $products = AddProduct::with(['categories', 'images'])
            ->when($heroProduct, function ($query) use ($heroProduct) {
                $query->where('id', '!=', $heroProduct->id);
            })
            ->latest()
            ->paginate(8);

        $allCategories = Category::whereHas('products')
            ->orderBy('name')
            ->get();

        return view('welcome', [
            'heroProduct'   => $heroProduct,
            'products'      => $products,
            'allCategories' => $allCategories,
        ]);
    }
}
