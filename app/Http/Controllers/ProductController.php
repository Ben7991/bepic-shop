<?php

namespace App\Http\Controllers;

use App\Http\Requests\Dashboard\ProductRequest;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function index(): View
    {
        return view('dashboard.product.index', [
            'products' => Product::orderBy('id', 'desc')->get()
        ]);
    }

    public function create(): View
    {
        return view('dashboard.product.create');
    }

    public function store(ProductRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        try {
            $imagePath = $request->file('image')->store('products');
            Product::create([
                'name' => $validated['name'],
                'image' => $imagePath,
                'price' => $validated['price'],
                'details' => $validated['details']
            ]);

            return redirect('/dashboard/products')->with([
                'message' => 'Product added successfully',
                'variant' => 'success'
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->with([
                'message' => 'Something went wrong',
                'variant' => 'error'
            ]);
        }
    }

    public function edit(int $id): View | RedirectResponse
    {
        try {
            $product = Product::findOrFail($id);

            return view('dashboard.product.edit', [
                'product' => $product
            ]);
        } catch (\Exception $e) {
            return redirect()->back();
        }
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|regex:/^[a-zA-Z ]*$/',
            'price' => 'required|regex:/^[0-9]*(\.[0-9]{2})*$/',
            'details' => 'required'
        ]);

        try {
            $product = Product::findorFail($id);
            $product->name = $validated['name'];
            $product->price = $validated['price'];
            $product->details = $validated['details'];
            $product->save();

            return redirect('/dashboard/products')->with([
                'message' => 'Product updated successfully',
                'variant' => 'success'
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->with([
                'message' => 'Something went wrong',
                'variant' => 'error'
            ]);
        }
    }
}
