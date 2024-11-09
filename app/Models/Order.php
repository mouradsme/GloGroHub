<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'product_id',
        'quantity',
        'total_price',
        'status',
        'ordered_at',
    ];
    protected $dates = ['ordered_at'];

    // Relationship to the User model
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relationship to the Product model
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Add an item to the cart
    public static function addToCart($productId, $quantity)
    {
        $user = Auth::user(); // Get the current authenticated user
        $product = Product::find($productId); // Get the product

        if (!$product) {
            return null; // If product doesn't exist, return null
        }

        // Check if the product is already in the cart
        $existingOrder = self::where('user_id', $user->id)
            ->where('product_id', $productId)
            ->where('status', 'cart') // Assuming 'cart' status indicates cart items
            ->first();

        if ($existingOrder) {
            // Update the quantity and total price if the product is already in the cart
            $existingOrder->quantity += $quantity;
            $existingOrder->total_price = $existingOrder->quantity * $product->price;
            $existingOrder->save();
            return $existingOrder;
        } else {
            // Create a new order item for the cart
            return self::create([
                'user_id' => $user->id,
                'product_id' => $productId,
                'quantity' => $quantity,
                'total_price' => $quantity * $product->price,
                'status' => 'cart', // Set status as 'cart' for cart items
                'ordered_at' => now(),
            ]);
        }
    }

    // Update cart item quantity
    public static function updateCartItem($orderId, $quantity)
    {
        $order = self::find($orderId);

        if ($order && $order->status == 'cart') {
            $product = $order->product;
            $order->quantity = $quantity;
            $order->total_price = $quantity * $product->price;
            $order->save();
            return $order;
        }

        return null; // Return null if the order is not found or not a cart item
    }

    // Get the current user's cart
    public static function getCart()
    {
        $user = Auth::user(); // Get the current authenticated user

        // Get all orders for the user where the status is 'cart'
        return self::where('user_id', $user->id)
            ->where('status', 'cart')
            ->get();
    }

    // Remove an item from the cart
    public static function removeFromCart($orderId)
    {
        $order = self::find($orderId);

        if ($order && $order->status == 'cart') {
            $order->delete();
            return true;
        }

        return false; // Return false if the order is not found or not a cart item
    }

    // Complete the order and change status
    public static function completeOrder()
    {
        $user = Auth::user(); // Get the current authenticated user

        // Get all cart items for the user
        $orders = self::where('user_id', $user->id)
            ->where('status', 'cart')
            ->get();

        // Change status to 'completed' for each item
        foreach ($orders as $order) {
            $order->status = 'completed'; // Assuming 'completed' is the final status
            $order->ordered_at = now();
            $order->save();
        }

        return $orders;
    }
}
