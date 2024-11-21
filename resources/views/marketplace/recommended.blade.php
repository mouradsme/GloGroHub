@php
   use Illuminate\Support\Str;
@endphp
@extends('layouts.market')
@section('content')
   <div class="home-section">
      <div class="bg-orange-100 p-6 text-center">
         <h1 class="text-3xl font-bold">AI recommended Products</h1>
         <p class="text-lg mt-2">Explore the best ethnic grocery products from trusted suppliers.</p>
 

      <div class="p-5">
     

        
        @if (count($Products) > 0)
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
        @else
        <div style="margin: auto;" class="text-center">
            The Recommender AI may need more Data in order to start making relevant recommandations

        </div>
        @endif  
        <div class="mt-5 "> 

         {{ $Products->links() }}
        </div>
      </div>
   </div>
@stop