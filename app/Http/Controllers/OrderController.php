<?php
namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Display a list of all orders.
     */
    public function index()
    {
        $orders = Order::where('user_id', auth()->user()->id)->with(['user', 'product'])->get();
        return view('orders.index', compact('orders'));
    }

    /**
     * Store a new order in the database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        // Fetch the product to calculate the total price
        $product = Product::find($request->product_id);
        $totalPrice = $product->price * $request->quantity;

        $order = Order::create([
            'user_id' => $request->user_id,
            'product_id' => $request->product_id,
            'quantity' => $request->quantity,
            'total_price' => $totalPrice,
            'status' => 'pending',
            'ordered_at' => now(),
        ]);

        return response()->json([
            'message' => 'Order placed successfully',
            'order' => $order,
        ], 201);
    }

    /**
     * Update the status of an order.
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,completed,cancelled',
        ]);

        $order = Order::find($id);

        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        $order->status = $request->status;
        $order->save();

        return response()->json([
            'message' => 'Order status updated successfully',
            'order' => $order,
        ]);
    }

    /**
     * Basic analytics for orders.
     */
    public function analytics()
    {
        // Example analytics: total sales, completed orders, pending orders, etc.
        $totalSales = Order::where('status', 'completed')->sum('total_price');
        $totalOrders = Order::count();
        $pendingOrders = Order::where('status', 'pending')->count();
        $completedOrders = Order::where('status', 'completed')->count();

        return response()->json([
            'total_sales' => $totalSales,
            'total_orders' => $totalOrders,
            'pending_orders' => $pendingOrders,
            'completed_orders' => $completedOrders,
        ]);
    }
}
