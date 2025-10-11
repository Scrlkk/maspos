<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CartController extends Controller
{
    /**
     * Display cart page
     */
    public function index()
    {
        $carts = Cart::with('product.category')
            ->where('user_id', request()->user()->id)
            ->get()
            ->map(function ($cart) {
                return [
                    'id' => $cart->id,
                    'product_id' => $cart->product_id,
                    'name' => $cart->product->nama,
                    'price' => $cart->price,
                    'quantity' => $cart->quantity,
                    'subtotal' => $cart->price * $cart->quantity,
                    'image' => $cart->product->gambar ? asset('storage/' . $cart->product->gambar) : null,
                ];
            });

        $total = $carts->sum('subtotal');

        return Inertia::render('CartView', [
            'carts' => $carts,
            'total' => $total,
        ]);
    }

    /**
     * Add product to cart (quantity = 1)
     */
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);

        $product = Product::findOrFail($request->product_id);

        // Check if product already in cart
        $cart = Cart::where('user_id', request()->user()->id)
            ->where('product_id', $product->id)
            ->first();

        if ($cart) {
            // Increase quantity by 1
            $cart->quantity += 1;
            $cart->save();

            return redirect()->back();
        }

        // Create new cart item with quantity 1
        Cart::create([
            'user_id' => request()->user()->id,
            'product_id' => $product->id,
            'quantity' => 1,
            'price' => $product->harga,
        ]);

        return redirect()->back();
    }

    /**
     * Decrease quantity by 1 or delete if quantity = 1
     */
    public function decrease(Cart $cart)
    {
        // Check if cart belongs to authenticated user
        if ($cart->user_id !== request()->user()->id) {
            abort(403);
        }

        if ($cart->quantity > 1) {
            // Decrease quantity by 1
            $cart->quantity -= 1;
            $cart->save();
        } else {
            // Delete if quantity = 1
            $cart->delete();
        }

        return redirect()->back();
    }

    /**
     * Remove entire cart item (delete completely)
     */
    public function destroy(Cart $cart)
    {
        // Check if cart belongs to authenticated user
        if ($cart->user_id !== request()->user()->id) {
            abort(403);
        }

        // Delete the entire cart item
        $cart->delete();

        return redirect()->back();
    }

    /**
     * Clear all cart items
     */
    public function clear()
    {
        Cart::where('user_id', request()->user()->id)->delete();

        // Redirect back tanpa error
        return redirect()->back();
    }

    /**
     * Show payment page
     */
    public function payment()
    {
        $carts = Cart::with('product.category')
            ->where('user_id', request()->user()->id)
            ->get()
            ->map(function ($cart) {
                return [
                    'id' => $cart->id,
                    'product_id' => $cart->product_id,
                    'name' => $cart->product->nama,
                    'price' => $cart->price,
                    'quantity' => $cart->quantity,
                    'subtotal' => $cart->price * $cart->quantity,
                ];
            });

        $total = $carts->sum('subtotal');

        return Inertia::render('PaymentView', [
            'carts' => $carts,
            'total' => $total,
            'isEmpty' => $carts->isEmpty(),
        ]);
    }
}
