<?php

namespace App\Http\Controllers\Product;  // Correct namespace for the ProductController

use Illuminate\Http\Request;
use App\Models\Product;  // Ensure the correct Product model is being used
use App\Http\Controllers\Controller;  // Don't forget to include the base Controller class

class ProductController extends Controller
{
    /**
     * Display all products on the menu page.
     */
    public function index()
    {
        // Fetch all products from the 'produk' table
        $products = Product::all();  // Using Product model

        // Send product data to the 'menu' view
        return view('menu', compact('products'));
    }

    /**
     * Display all products on the dashboard page.
     */
    public function dashboard()
    {
        // Fetch all products from the 'produk' table
        $products = Product::all();  // Using Product model

        // Send product data to the 'menu' view
        return view('dashboard', compact('products'));
    }

    /**
     * Display product details based on the ID
     */
    public function show($id)
    {
        // Fetch product by ID
        $product = Product::findOrFail($id);  // Using Product model

        return view('product.show', compact('product'));
    }

    /**
     * Add a new product to the database
     */
    public function store(Request $request)
    {
        // Validate the form input
        $validated = $request->validate([
            'code_product' => 'required|string|max:15|unique:produk',
            'name_product' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'image' => 'required|string',
            'expire_date' => 'nullable|date',
        ]);

        // Store new product data
        Product::create($validated);  // Using Product model

        return redirect()->route('menu')->with('success', 'Product successfully added');
    }

    /**
     * Update existing product data
     */
    public function update(Request $request, $id)
    {
        // Validate input
        $validated = $request->validate([
            'code_product' => 'required|string|max:15',
            'name_product' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'image' => 'required|string',
            'expire_date' => 'nullable|date',
        ]);

        // Find product by ID
        $product = Product::findOrFail($id);  // Using Product model
        
        // Update product data
        $product->update($validated);

        return redirect()->route('menu')->with('success', 'Product successfully updated');
    }

    /**
     * Delete product from the database
     */
    public function destroy($id)
    {
        // Find and delete the product by ID
        $product = Product::findOrFail($id);  // Using Product model
        $product->delete();

        return redirect()->route('menu')->with('success', 'Product successfully deleted');
    }
}
