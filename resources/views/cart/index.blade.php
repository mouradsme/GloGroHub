@extends('layouts.market')

@section('content')
<div class="home-section">
    <!-- Header Section -->
    <div class="bg-blue-100 p-6 text-center rounded-lg shadow-md">
        <h1 class="text-4xl font-bold text-gray-800">GloGroHub Marketplace</h1>
        <p class="text-lg mt-2 text-gray-600">This is the Orders page where you can find all your orders.</p>
    </div>

    <!-- Navigation Section -->
    <div class="p-5">
        <div class="flex overflow-hidden bg-white border divide-x rounded-lg rtl:flex-row-reverse dark:bg-gray-900 dark:border-gray-700 dark:divide-gray-700">
            <a href="{{ route('marketplace') }}" class="px-4 py-2 text-sm font-medium text-gray-600 transition-colors duration-200 sm:text-base sm:px-6 dark:hover:bg-gray-800 dark:text-gray-300 hover:bg-gray-100">
                <i class='bx bx-home'></i> {{ __('Home') }}
            </a>
            <a class="px-4 py-2 text-sm font-medium text-gray-600 transition-colors duration-200 sm:text-base sm:px-6 dark:hover:bg-gray-800 dark:text-gray-300 hover:bg-gray-100">
                <i class='bx bx-cart-alt'></i> {{ __('Cart') }}
            </a>
        </div>
    </div>

    <!-- Cart Section -->
    <div class="m-5 mt-8" style="max-width: 1000px; margin: auto;">
 
        @if(session('success'))
            <div class="mt-4 p-4 text-white bg-green-500 rounded-lg">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="mt-4 p-4 text-white bg-red-500 rounded-lg">
                {{ session('error') }}
            </div>
        @endif

        @if($cartItems->isEmpty())
            <p class="mt-4 text-gray-600">Your cart is empty.</p>
        @else
            <div class="mt-4 overflow-x-auto bg-white shadow-md rounded-lg">
                <table class="min-w-full table-auto text-left">
                    <thead class="bg-gray-200 text-gray-700">
                        <tr>
                            <th class="px-4 py-2 text-sm font-semibold">Product</th>
                            <th class="px-4 py-2 text-sm font-semibold">Quantity</th>
                            <th class="px-4 py-2 text-sm font-semibold">Total Price</th>
                            <th class="px-4 py-2 text-sm font-semibold">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($cartItems as $item)
                            <tr class="border-t">
                                <td class="px-4 py-2 text-sm text-gray-800">{{ $item->product->name }}</td>
                                <td class="px-4 py-2 text-sm text-gray-800">{{ $item->quantity }}</td>
                                <td class="px-4 py-2 text-sm text-gray-800">${{ number_format($item->total_price, 2) }}</td>
                                <td class="px-4 py-2 text-sm">
                                    <form action="{{ route('cart.remove', $item->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('POST')
                                        <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition-colors">
                                            Remove
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Complete Order Button -->
            <form action="{{ route('cart.complete') }}" method="POST" class="mt-6">
                @csrf
                <button type="submit" class="w-full px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                    Complete Order
                </button>
            </form>
        @endif
    </div>
</div>
@endsection
