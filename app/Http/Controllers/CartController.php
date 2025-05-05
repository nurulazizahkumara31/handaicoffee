<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function addToCart(Request $request, $productId)
    {
        $product = Product::find($productId);
    
        // Retrieve the current cart from the session (ensure it's an array)
        $cart = session('cart', []);
    
        // Check if the product is already in the cart
        if (isset($cart[$productId])) {
            $cart[$productId]['quantity'] += $request->input('quantity');
        } else {
            $cart[$productId] = [
                'name' => $product->name_product,
                'price' => $product->price,
                'quantity' => $request->input('quantity'),
                'image' => $product->image,
            ];
        }
    
        // Save the cart back to the session
        session(['cart' => $cart]);
    
        return redirect()->route('menu');
    }
    
    //Pastikan method ini berada di dalam class
    public function index()
    {
        $cart = session()->get('cart', []);
        return view('cart.index', compact('cart'));
    }
    

public function updateCart(Request $request)
{
    // Ambil keranjang dari session
    $cart = session()->get('cart', []);

    // Update kuantitas untuk setiap item yang dipilih
    foreach ($request->quantity as $id => $quantity) {
        if (isset($cart[$id])) {
            $cart[$id]['quantity'] = $quantity;
        }
    }

    // Simpan kembali keranjang ke dalam session
    session()->put('cart', $cart);

    return redirect()->route('cart.index');  // Ganti dengan rute yang sesuai
}

// CartController.php

public function showMenu()
{
    // Get the cart from the session, default to an empty array if not set
    $cart = session('cart', []);

    // Calculate the total price of the items in the cart
    $total = 0;
    foreach ($cart as $item) {
        $total += $item['price'] * $item['quantity'];
    }

    // Pass the cart and total to the view
    return view('menu', compact('cart', 'total'));
}

public function destroy($id)
{
    $cart = session()->get('cart', []);

    if (isset($cart[$id])) {
        unset($cart[$id]);
        session()->put('cart', $cart);
    }

    return redirect()->back()->with('success', 'Item berhasil dihapus dari keranjang.');
}


}
