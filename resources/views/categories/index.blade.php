@extends('layouts.market')

@section('content')

<div class="home-section">
    <div class="p-5">
        <div style=";" class="flex overflow-hidden bg-white border divide-x rounded-lg rtl:flex-row-reverse dark:bg-gray-900 dark:border-gray-700 dark:divide-gray-700">
           <a href="{{ route('marketplace') }}" class="px-4 py-2 text-sm font-medium text-gray-600 transition-colors duration-200 sm:text-base sm:px-6 dark:hover:bg-gray-800 dark:text-gray-300 hover:bg-gray-100">
              <i class='bx bx-home'></i> 
           </a>
           <a href="#" class="px-4 py-2 text-sm font-medium text-gray-600 transition-colors duration-200 sm:text-base sm:px-6 dark:hover:bg-gray-800 dark:text-gray-300 hover:bg-gray-100">
                <i class='bx bx-cabinet'></i> Categories 
            </a>
            <a href="{{ route('add_category') }}" class="px-4 py-2 text-sm font-medium text-gray-600 transition-colors duration-200 sm:text-base sm:px-6 dark:hover:bg-gray-800 dark:text-gray-300 hover:bg-gray-100">
                 <i class='bx bx-plus'></i> Add a new category
             </a>
        </div>
    
    <table class="min-w-full bg-white shadow-md rounded-lg overflow-hidden">
        <thead class="bg-gray-200">
            <tr>
                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Name</th>
                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Slug</th>
                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Description</th>
                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Parent</th>
            </tr>
        </thead>
        <tbody>
            @foreach($categories as $category)
                <tr class="border-b">
                    <td class="px-6 py-4 text-gray-700">{{ $category->name }}</td>
                    <td class="px-6 py-4 text-gray-700">{{ $category->slug }}</td>
                    <td class="px-6 py-4 text-gray-700 capitalize">{{ $category->description }}</td>
                    <td class="px-6 py-4 text-gray-700 capitalize">{{ $category->parent?->name }}</td>
                    
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@stop
