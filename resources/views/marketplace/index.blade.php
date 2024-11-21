@php
   use Illuminate\Support\Str;
@endphp
@extends('layouts.market')
@section('content')
   <div class="home-section">
      <div class="bg-orange-100 p-6 text-center">
         <h1 class="text-3xl font-bold">Welcome to GloGroHub Marketplace</h1>
         <p class="text-lg mt-2">Explore the best ethnic grocery products from trusted suppliers.</p>
 

      <div class="p-5">
         <div style="width: min-content;" class="flex overflow-hidden bg-white border divide-x rounded-lg rtl:flex-row-reverse dark:bg-gray-900 dark:border-gray-700 dark:divide-gray-700">
            <a href="{{ route('marketplace') }}" class="px-4 py-2 text-sm font-medium text-gray-600 transition-colors duration-200 sm:text-base sm:px-6 dark:hover:bg-orange-500 dark:text-gray-300 hover:bg-gray-100">
               <i class='bx bx-home'></i>
            </a>
            @foreach ($Categories as $Category)
            <a href="{{ route('category', $Category->id) }}" class="px-4 py-2 text-sm font-medium text-gray-600 transition-colors duration-200 sm:text-base sm:px-6 dark:hover:bg-orange-500 dark:text-gray-300 hover:bg-gray-100">
                {{ $Category->name }}
            </a>
               
            @endforeach
        </div>
        @if (isset($SubCategories))
        <h1 class="font-bold text-left mt-3 mb-3 ml-3">{{ __('Sub Categories') }}</h1>
               <div style="width: min-content;" class="flex overflow-hidden bg-white border divide-x rounded-lg rtl:flex-row-reverse dark:bg-gray-900 dark:border-gray-700 dark:divide-gray-700">
         
                  @foreach ($SubCategories as $Category)
                  <a href="{{ route('category', $Category->id) }}" class="px-4 py-2 text-sm font-medium text-gray-600 transition-colors duration-200 sm:text-base sm:px-6 dark:hover:bg-orange-500 dark:text-gray-300 hover:bg-gray-100">
                        {{ $Category->name }}
                  </a>
                     
                  @endforeach
               </div>
         @endif


        
        <div class="mt-5 grid gap-6 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 products"> 

         @foreach ($Products as $Product)
         <x-product 
               name="{{ $Product->name }}" 
               description="{{ $Product->description }}" 
               price="{{ $Product->price }}" 
               src="{{ Str::startsWith($Product->image, ['http://', 'https://']) ? $Product->image : asset('storage/' . $Product->image) }}" 
               min="{{ $Product->min_order_quantity }}"
               id="{{ $Product->id }}"
               />
            
         @endforeach

        </div>
        <div class="mt-5 "> 

         {{ $Products->links() }}
        </div>
      </div>
   </div>
@stop