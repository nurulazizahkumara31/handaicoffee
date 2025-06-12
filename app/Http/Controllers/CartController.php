<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
//tambahan
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Produk;
use App\Models\Pelanggan;
use Illuminate\Support\Facades\DB;

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


public function checkout(Request $request)
{
    $cart = session()->get('cart', []);

    if (empty($cart)) {
        return redirect()->route('cart.index')->with('error', 'Keranjang Anda kosong.');
    }

    // Validasi stok
    foreach ($cart as $productId => $item) {
        $product = Produk::find($productId);
        if (!$product || $product->stock < $item['quantity']) {
            return back()->with('error', 'Stok tidak cukup untuk produk: ' . $item['name']);
        }
    }

    // Hitung total + shipping
    $shipping = 5000;
    $total = collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']) + $shipping;

    // Ambil data pelanggan dari user login
    $user = auth()->user();

    // Baris ini adalah tempat kode pelanggan berada
    $pelanggan = Pelanggan::firstOrCreate(
        ['nama' => $user->name],
        [
            'email' => $user->email ?? null,
            'telepon' => '0000000000',
            'alamat' => 'Alamat default',
            'user_id' => $user->id,
        ]
    );
    

    DB::beginTransaction();
    try {
        $order = Order::create([
            'user_id' => $user->id,
            'pelanggan_id' => $pelanggan->id,
            'items' => json_encode($cart),
            'total_price' => $total,
            'status' => 'pending',
        ]);

        foreach ($cart as $productId => $item) {
            OrderDetail::create([
                'order_id' => $order->id,
                'product_id' => $productId,
                'quantity' => $item['quantity'],
                'price' => $item['price'],
                'subtotal' => $item['price'] * $item['quantity'],
            ]);

            // Kurangi stok
            $product = Produk::find($productId);
            $product->stock -= $item['quantity'];
            $product->save();
        }

        DB::commit();
        session()->forget('cart');

        return redirect()->route('payment.show', ['orderId' => $order->id])->with('success', 'Silakan lanjutkan pembayaran.');

    } catch (\Exception $e) {
        DB::rollBack();
        return back()->with('error', 'Gagal checkout: ' . $e->getMessage());
    }
}
}
