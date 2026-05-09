<?php

namespace App\Http\Controllers;

use App\Models\AddProduct;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class AddProductController extends Controller
{
    public function create()
    {
        abort_unless(Auth::check() && Auth::user()->is_admin, 403);

        return view('addProduct', [
            'categories' => Category::orderBy('name')->get(),
        ]);
    }

    public function store(Request $request)
    {
        abort_unless(Auth::check() && Auth::user()->is_admin, 403);

        $validated = $request->validate([
            'name'         => ['required', 'string', 'max:255'],
            'price'        => ['required', 'numeric', 'min:0'],
            'stock'        => ['nullable', 'integer', 'min:0'],
            'description'  => ['nullable', 'string'],
            'delivery_fee' => ['nullable', 'numeric', 'min:0'],

            'categories'   => ['required', 'array', 'min:1'],
            'categories.*' => ['exists:categories,id'],

            'images'       => ['nullable', 'array'],
            'images.*'     => ['image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
        ]);

        $product = AddProduct::create([
            'name'         => $validated['name'],
            'price'        => $validated['price'],
            'description'  => $validated['description'] ?? null,
            'stock'        => $validated['stock'] ?? 0,
            'delivery_fee' => $validated['delivery_fee'] ?? 0,
        ]);

        $product->categories()->sync($validated['categories']);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('products', 'public');

                $product->images()->create([
                    'path' => $path,
                ]);
            }
        }

        $this->clearHomeCache();

        return redirect()
            ->route('home')
            ->with('success', __('messages.product_added_successfully'));
    }

    public function show(AddProduct $product)
    {
        $product->load(['categories', 'images']);

        $relatedProducts = AddProduct::with(['categories', 'images'])
            ->whereHas('categories', function ($query) use ($product) {
                $query->whereIn('categories.id', $product->categories->pluck('id'));
            })
            ->where('id', '!=', $product->id)
            ->latest()
            ->take(4)
            ->get();

        return view('product', [
            'product' => $product,
            'isAdmin' => Auth::check() && Auth::user()->is_admin,
            'canAddToCart' => Auth::check() && ! Auth::user()->is_admin,
            'relatedProducts' => $relatedProducts,
        ]);
    }

    public function edit(AddProduct $product)
    {
        abort_unless(Auth::check() && Auth::user()->is_admin, 403);

        return view('edit', [
            'product'    => $product->load(['images', 'categories']),
            'categories' => Category::orderBy('name')->get(),
        ]);
    }

    public function update(Request $request, AddProduct $product)
    {
        abort_unless(Auth::check() && Auth::user()->is_admin, 403);

        $validated = $request->validate([
            'name'         => ['required', 'string', 'max:255'],
            'price'        => ['required', 'numeric', 'min:0'],
            'stock'        => ['required', 'integer', 'min:0'],
            'description'  => ['nullable', 'string'],
            'delivery_fee' => ['nullable', 'numeric', 'min:0'],

            'categories'   => ['required', 'array', 'min:1'],
            'categories.*' => ['exists:categories,id'],

            'images'       => ['nullable', 'array'],
            'images.*'     => ['image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
        ]);

        $product->update([
            'name'         => $validated['name'],
            'price'        => $validated['price'],
            'stock'        => $validated['stock'],
            'description'  => $validated['description'] ?? null,
            'delivery_fee' => $validated['delivery_fee'] ?? 0,
        ]);

        $product->categories()->sync($validated['categories']);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('products', 'public');

                $product->images()->create([
                    'path' => $path,
                ]);
            }
        }

        $this->clearHomeCache();

        return redirect()
            ->route('products.show', $product)
            ->with('success', __('messages.product_updated_successfully'));
    }

    public function destroy(AddProduct $product)
    {
        abort_unless(Auth::check() && Auth::user()->is_admin, 403);

        $product->load('images');

        foreach ($product->images as $image) {
            if ($image->path) {
                Storage::disk('public')->delete($image->path);
            }
        }

        $product->images()->delete();
        $product->categories()->detach();
        $product->delete();

        $this->clearHomeCache();

        return redirect()
            ->route('home')
            ->with('success', __('messages.product_deleted_successfully'));
    }

    private function clearHomeCache(): void
    {
        Cache::forget('hero_product');
        Cache::forget('home_products');
        Cache::forget('home_categories');
    }
}
