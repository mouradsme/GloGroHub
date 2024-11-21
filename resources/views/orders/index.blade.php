

    
    @extends('layouts.market')
@section('content')
   <div class="home-section">
    <div class="bg-orange-100 p-6 text-center rounded-lg shadow-md">
        <h1 class="text-4xl font-bold text-gray-800">GloGroHub Marketplace</h1>
        <p class="text-lg mt-2 text-gray-600">This is the Orders page where you can find all your orders.</p>
    </div>
         <div class="p-5">
            <div  class="flex overflow-hidden bg-white border divide-x rounded-lg rtl:flex-row-reverse dark:bg-gray-900 dark:border-gray-700 dark:divide-gray-700">
               <a href="{{ route('marketplace') }}" class="px-4 py-2 text-sm font-medium text-gray-600 transition-colors duration-200 sm:text-base sm:px-6 dark:hover:bg-orange-500 dark:text-gray-300 hover:bg-gray-100">
                  <i class='bx bx-home'></i> {{ __('Home') }}
               </a>
               <a  class="px-4 py-2 text-sm font-medium text-gray-600 transition-colors duration-200 sm:text-base sm:px-6 dark:hover:bg-orange-500 dark:text-gray-300 hover:bg-gray-100">
                <i class='bx bx-cart-alt'></i> {{ __('Orders') }}
             </a>
           </div>
         </div>

         <div class="container mx-auto mt-8">

            <table class="min-w-full bg-white">
                <thead class="overflow-hidden bg-white border divide-x rounded-lg rtl:flex-row-reverse dark:bg-gray-900 dark:border-gray-700 dark:divide-gray-700">
                    <tr>
                        <th class="px-6 py-3 border-b-2 border-gray-300 text-left text-sm leading-4 text-gray-600 dark:text-white">User</th>
                        <th class="px-6 py-3 border-b-2 border-gray-300 text-left text-sm leading-4 text-gray-600 dark:text-white">Product</th>
                        <th class="px-6 py-3 border-b-2 border-gray-300 text-left text-sm leading-4 text-gray-600 dark:text-white">Quantity</th>
                        <th class="px-6 py-3 border-b-2 border-gray-300 text-left text-sm leading-4 text-gray-600 dark:text-white">Total Price</th>
                        <th class="px-6 py-3 border-b-2 border-gray-300 text-left text-sm leading-4 text-gray-600 dark:text-white">Status</th>
                        <th class="px-6 py-3 border-b-2 border-gray-300 text-left text-sm leading-4 text-gray-600 dark:text-white">Ordered At</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                        <tr>
                            <td class="px-6 py-3 border-b text-left border-gray-300">{{ $order->user->name }}</td>
                            <td class="px-6 py-3 border-b text-left border-gray-300">{{ $order->product->name }}</td>
                            <td class="px-6 py-3 border-b text-left border-gray-300">{{ $order->quantity }}</td>
                            <td class="px-6 py-3 border-b text-left border-gray-300">${{ $order->total_price }}</td>
                            <td class="px-6 py-3 border-b text-left border-gray-300">{{ ucfirst($order->status) }}</td>
                            <td class="px-6 py-3 border-b text-left border-gray-300">{{ \Carbon\Carbon::parse($order->ordered_at)->format('d/m/Y H:i') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
   </div>
@stop