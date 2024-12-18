<?php

namespace App\Http\Controllers;
use App\Models\Product;
use App\Models\Category;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;



class ProductController extends Controller
{  
    
    public function index() {

        $user_id = null;
        $Products = Product::with(['category', 'supplier']);
        if ($user_id) 
            $Products = $Products->where('user_id', $user_id);
        
        $Products = $Products->paginate(10);
        return view('products.index', compact('Products'));
    }

    
    /**
    * Display the specified product.
    *
    * @param  int  $id
    * @return \Illuminate\View\View
    */
   public function show($id)
   {
        $product = Product::with(['category', 'supplier'])->findOrFail($id);
        $flaskApiUrl = env('AI_RECOMMENDER_BASE_API_URL') . "/recommend-products/$id";

        $response = Http::get($flaskApiUrl);
        $recommendedIds = array();
        if ($response->successful()) 
            $recommendedIds = $response->json(); 
        if (is_array($recommendedIds)) {
            $similar_products = Product::with(['category', 'supplier'])->whereIn('id', $recommendedIds)->get();
        } else {
            $similar_products = collect(); 
        } 
       return view('marketplace.product', compact('product', 'similar_products'));
   }

   public function create() {
     $user_role = auth()->user()->role;
    $categories = Category::all();

    return view('products.create', compact('categories'));
    

   }
    /**
     * Store a newly created product in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'discounted_price' => 'nullable|numeric|min:0',
            'stock_quantity' => 'integer|min:0',
            'ethnic_culture' => 'nullable|string|max:255',
            'seasonal_demand' => 'boolean',
            'min_order_quantity' => 'integer|min:1',
            'unit' => 'nullable|string|max:50',
            'sku' => 'nullable|string|max:100|unique:products,sku',
            'status' => 'in:available,out_of_stock,discontinued',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validate image file
        ]);

        $imagePath = $request->file('image') 
            ? $request->file('image')->store('images/products', 'public') 
            : null;
        $Supplier = Supplier::where('user_id', auth()->user()['id'])->first();
        $supplier = $Supplier->id;
        
        $product = Product::create([
            'name' => $request->name,
            'description' => $request->description,
            'category_id' => $request->category_id,
            'supplier_id' => $supplier,
            'price' => $request->price,
            'discounted_price' => $request->discounted_price,
            'stock_quantity' => $request->stock_quantity ?? 0,
            'ethnic_culture' => $request->ethnic_culture,
            'seasonal_demand' => $request->seasonal_demand ?? false,
            'min_order_quantity' => $request->min_order_quantity ?? 1,
            'unit' => $request->unit ?? 'piece',
            'sku' => $request->sku ?? Str::random(10),
            'status' => $request->status ?? 'available',
            'image' => $imagePath,
        ]);

        if ($product->exists) {
            return view('wholesaler.dashboard');
        }

        return view('wholesaler.add-product');
    }

    /**
     * Update the specified product in storage.
     */
    public function update(Request $request, $id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'supplier_id' => 'required|exists:suppliers,id',
            'price' => 'required|numeric|min:0',
            'discounted_price' => 'nullable|numeric|min:0',
            'stock_quantity' => 'integer|min:0',
            'ethnic_culture' => 'nullable|string|max:255',
            'seasonal_demand' => 'boolean',
            'min_order_quantity' => 'integer|min:1',
            'unit' => 'nullable|string|max:50',
            'sku' => 'nullable|string|max:100|unique:products,sku,' . $product->id,
            'status' => 'in:available,out_of_stock,discontinued',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validate image file
        ]);

        // Check if a new image is uploaded
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            // Store new image
            $imagePath = $request->file('image')->store('images/products', 'public');
        } else {
            $imagePath = $product->image;
        }

        $product->update([
            'name' => $request->name,
            'description' => $request->description,
            'category_id' => $request->category_id,
            'supplier_id' => $request->supplier_id,
            'price' => $request->price,
            'discounted_price' => $request->discounted_price,
            'stock_quantity' => $request->stock_quantity ?? 0,
            'ethnic_culture' => $request->ethnic_culture,
            'seasonal_demand' => $request->seasonal_demand ?? false,
            'min_order_quantity' => $request->min_order_quantity ?? 1,
            'unit' => $request->unit ?? 'piece',
            'sku' => $request->sku ?? $product->sku,
            'status' => $request->status ?? 'available',
            'image' => $imagePath,
        ]);

        return response()->json([
            'message' => 'Product updated successfully',
            'product' => $product,
        ]);
    }
}
