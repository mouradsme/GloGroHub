@extends('layouts.market')

@section('content')

<div class="home-section">
    <div class="p-5">
        <div style=";" class="flex overflow-hidden bg-white border divide-x rounded-lg rtl:flex-row-reverse dark:bg-gray-900 dark:border-gray-700 dark:divide-gray-700">
           <a href="{{ route('marketplace') }}" class="px-4 py-2 text-sm font-medium text-gray-600 transition-colors duration-200 sm:text-base sm:px-6 dark:hover:bg-orange-500 dark:text-gray-300 hover:bg-gray-100">
              <i class='bx bx-home'></i> 
           </a>
           <a href="#" class="px-4 py-2 text-sm font-medium text-gray-600 transition-colors duration-200 sm:text-base sm:px-6 dark:hover:bg-orange-500 dark:text-gray-300 hover:bg-gray-100">
                <i class='bx bx-cabinet'></i> Products 
            </a>
            <a href="{{ route('products.create') }}" class="px-4 py-2 text-sm font-medium text-gray-600 transition-colors duration-200 sm:text-base sm:px-6 dark:hover:bg-orange-500 dark:text-gray-300 hover:bg-gray-100">
                 <i class='bx bx-plus'></i> Add a new product
             </a>
        </div>
    
    <table class="min-w-full bg-white shadow-md rounded-lg overflow-hidden">
        <thead class="bg-gray-200">
            <tr>
                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Name</th>
                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Price</th>
                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Description</th>
                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Category</th>
            </tr>
        </thead>
        <tbody>
            @foreach($Products as $Product)
                <tr class="border-b">
                    <td class="px-6 py-4 text-gray-700">{{ $Product->name }}</td>
                    <td class="px-6 py-4 text-gray-700">{{ $Product->price }}</td>
                    <td class="px-6 py-4 text-gray-700">{{ $Product->description }}</td>
                    <td class="px-6 py-4 text-gray-700 capitalize">{{ $Product->category?->name }}</td>
                    
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="p-5">
        {{ $Products->links() }}

    </div>
</div>
@stop
