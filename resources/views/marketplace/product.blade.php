@extends('layouts.market')

@section('content')
<div class="home-section">
    <div class="p-5">
        <div style=";" class="flex overflow-hidden bg-white border divide-x rounded-lg rtl:flex-row-reverse dark:bg-gray-900 dark:border-gray-700 dark:divide-gray-700">
           <a href="{{ route('marketplace') }}" class="px-4 py-2 text-sm font-medium text-gray-600 transition-colors duration-200 sm:text-base sm:px-6 dark:hover:bg-gray-800 dark:text-gray-300 hover:bg-gray-100">
              <i class='bx bx-home'></i> 
           </a>
           <i class="px-4 py-2 text-sm font-medium text-gray-600 transition-colors duration-200 sm:text-base sm:px-6 dark:hover:bg-gray-800 dark:text-gray-300 hover:bg-gray-100">/ Products / {{ $product->name }}</i>
        </div>

        <!-- Container for the product details -->
    <div class="container mx-auto px-4 py-8">
        <div class="flex flex-wrap md:flex-nowrap bg-white shadow-md rounded-lg overflow-hidden">
            <!-- Product Image -->
            <div class="w-full md:w-1/2">
                <img src="{{ Str::startsWith($product->image, ['http://', 'https://']) ? $product->image : asset('storage/' . $product->image) }}"  alt="{{ $product->name }}" class="w-full h-96 object-cover">
            </div>

            <!-- Product Details -->
            <div class="w-full md:w-1/2 p-6">
                <h1 class="text-3xl font-bold mb-2">{{ $product->name }}</h1>
                <p class="text-gray-600 mb-4">{{ $product->description }}</p>
                
                <div class="mb-4">
                    @if($product->discounted_price)
                        <span class="text-red-600 text-2xl font-bold">${{ $product->discounted_price }}</span>
                        <span class="line-through text-gray-500 text-lg ml-2">${{ $product->price }}</span>
                    @else
                        <span class="text-gray-900 text-2xl font-bold">${{ $product->price }}</span>
                    @endif
                </div>

                <div class="mb-4">
                    <span class="text-sm text-gray-600">Stock: 
                        @if($product->stock_quantity > 0)
                            <span class="text-green-600 font-semibold">Available</span>
                        @else
                            <span class="text-red-600 font-semibold">Out of Stock</span>
                        @endif
                    </span>
                </div>

                <!-- Add to Cart Button -->
                <div class="mt-6">
                    @if($product->stock_quantity > 0)
                    <form action="{{ route('cart.add') }}" method="POST">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <input type="number" min="$product->min_order_quantity" name="quantity" value="{{ $product->min_order_quantity }}" class=""> <!-- Default quantity is 1, you can change this -->
                        
                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                            Add to cart
                        </button>
                    </form>
                    @else
                        <button class="bg-gray-400 text-white px-4 py-2 rounded cursor-not-allowed" disabled>
                            Out of Stock
                        </button>
                    @endif
                </div>
            </div>
        </div>

        <!-- Additional Information (e.g., Supplier, Category) -->
        <div class="mt-8">
            <h2 class="text-2xl font-bold mb-4">Product Details</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <h3 class="text-lg font-semibold">Category:</h3>
                    <p class="text-gray-600">{{ $product->category->name }}</p>
                </div>
                <div>
                    <h3 class="text-lg font-semibold">Supplier:</h3>
                    <p class="text-gray-600">{{ $product->supplier->name }}</p>
                </div>
                <div>
                    <h3 class="text-lg font-semibold">Ethnic Culture:</h3>
                    <p class="text-gray-600">{{ $product->ethnic_culture ?? 'N/A' }}</p>
                </div>
                <div>
                    <h3 class="text-lg font-semibold">Minimum Order Quantity:</h3>
                    <p class="text-gray-600">{{ $product->min_order_quantity }} {{ $product->unit }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@stop
