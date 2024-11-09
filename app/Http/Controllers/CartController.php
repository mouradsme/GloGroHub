<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class CartController extends Controller
{
    // Add a product to the cart
    public function addToCart(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $order = Order::addToCart($request->product_id, $request->quantity);

        if ($order) {
            return redirect()->route('cart.index')->with('success', 'Product added to cart.');
        }

        return redirect()->route('cart.index')->with('error', 'Failed to add product to cart.');
    }

    // View the cart
    public function index()
    {
        $cartItems = Order::getCart();

        return view('cart.index', compact('cartItems'));
    }

    // Remove a product from the cart
    public function removeFromCart($orderId)
    {
        $success = Order::removeFromCart($orderId);

        if ($success) {
            return redirect()->route('cart.index')->with('success', 'Product removed from cart.');
        }

        return redirect()->route('cart.index')->with('error', 'Failed to remove product from cart.');
    }

    // Complete the order (checkout)
    public function completeOrder()
    {
        $orders = Order::completeOrder();

        return redirect()->route('orders.index')->with('success', 'Order completed successfully.');
    }
}
