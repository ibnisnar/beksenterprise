<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(){
        $products = Product::all();
        return view('product.index', compact('products'));
    }

    public function create(){
        return view('product.add');
    }

    public function store(Request $request){
        $request->validate([
            'name' => 'required|string|max:255',
            'quantity' => 'required|integer',
            'price' => 'required|numeric',
        ]);

        Product::create([
            'name' => $request->name,
            'quantity' => $request->quantity,
            'price' => $request->price,
        ]);

        return redirect()->route('product.index')->with('message', 'Product added successfully!');
    }

    public function edit($id){
        $product = Product::findOrFail($id);
        return view('product.edit', compact('product'));
    }

    public function update(Request $request, $id){
        $product = Product::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'quantity' => 'required|integer',
            'price' => 'required|numeric',
        ]);

        $product->update([
            'name' => $request->name,
            'quantity' => $request->quantity,
            'price' => $request->price,
        ]);

        return redirect()->route('product.index')->with('message', 'Product updated successfully');
    }

    public function destroy($id){
        $product = Product::findOrFail($id);
        $product->delete();

        return redirect()->route('product.index')->with('message', 'Product deleted successfully');
    }
}
