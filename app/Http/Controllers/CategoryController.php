<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::orderBy('name')->get();

        return view('addProduct', compact('categories'));
    }

    public function show(Category $category)
    {
        $products = $category->products()
            ->with(['categories', 'images'])
            ->latest()
            ->paginate(12);

        return view('categories.show', compact('category', 'products'));
    }

    public function store(Request $request)
    {
        abort_unless(Auth::check() && Auth::user()->is_admin, 403);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:categories,name'],
        ]);

        $baseSlug = Str::slug($validated['name']);
        $slug = $baseSlug;
        $counter = 1;

        while (Category::where('slug', $slug)->exists()) {
            $slug = $baseSlug . '-' . $counter++;
        }

        Category::create([
            'name' => $validated['name'],
            'slug' => $slug,
        ]);

        $this->clearHomeCache();

        return redirect()
            ->back()
            ->with('success', __('messages.category_added_successfully'));
    }

    public function destroy(Category $category)
    {
        abort_unless(Auth::check() && Auth::user()->is_admin, 403);

        $category->products()->detach();
        $category->delete();

        $this->clearHomeCache();

        return redirect()
            ->back()
            ->with('success', __('messages.category_deleted_successfully'));
    }

    private function clearHomeCache(): void
    {
        Cache::forget('hero_product');
        Cache::forget('home_products');
        Cache::forget('home_categories');
    }
}
