@extends('layouts.market')
@section('content')
   <div class="home-section">
      <div class="p-5">
         <div class="flex overflow-hidden bg-white border divide-x rounded-lg rtl:flex-row-reverse dark:bg-gray-900 dark:border-gray-700 dark:divide-gray-700">
            <a href="{{ route('marketplace') }}" class="px-4 py-2 text-sm font-medium text-gray-600 transition-colors duration-200 sm:text-base sm:px-6 dark:hover:bg-gray-800 dark:text-gray-300 hover:bg-gray-100">
               <i class='bx bx-home'></i>
            </a>
            @foreach ($Categories as $Category)
            <a href="{{ route('category', $Category->id) }}" class="px-4 py-2 text-sm font-medium text-gray-600 transition-colors duration-200 sm:text-base sm:px-6 dark:hover:bg-gray-800 dark:text-gray-300 hover:bg-gray-100">
                {{ $Category->name }}
            </a>
               
            @endforeach
        </div>

        <div class="mt-5 grid gap-6 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 products"> 

         @foreach ($Products as $Product)
         <x-product 
               name="{{ $Product->name }}" 
               description="{{ $Product->description }}" 
               price="{{ $Product->price }}" 
               src="{{ asset('storage/' . $Product->image) }}"
               min="{{ $Product->stock_quantity }}"
               
               />
            
         @endforeach
        </div>
      </div>
   </div>
@stop