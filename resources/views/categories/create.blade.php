@auth
    @if (Auth::user()->role == 'site_manager')

    @extends('layouts.market')
    @section('content')
    <div class="home-section">
        <div class="p-5">
            <div style=";" class="flex overflow-hidden bg-white border divide-x rounded-lg rtl:flex-row-reverse dark:bg-gray-900 dark:border-gray-700 dark:divide-gray-700">
               <a href="{{ route('marketplace') }}" class="px-4 py-2 text-sm font-medium text-gray-600 transition-colors duration-200 sm:text-base sm:px-6 dark:hover:bg-gray-800 dark:text-gray-300 hover:bg-gray-100">
                  <i class='bx bx-home'></i> 
               </a>
               <a href="{{ route('categories') }}" class="px-4 py-2 text-sm font-medium text-gray-600 transition-colors duration-200 sm:text-base sm:px-6 dark:hover:bg-gray-800 dark:text-gray-300 hover:bg-gray-100">
                    <i class='bx bx-cabinet'></i> Categories 
                </a>
                <a href="#" class="px-4 py-2 text-sm font-medium text-gray-600 transition-colors duration-200 sm:text-base sm:px-6 dark:hover:bg-gray-800 dark:text-gray-300 hover:bg-gray-100">
                     <i class='bx bx-plus'></i> Adding a new category 
                 </a>
            </div>
    <div style="margin: auto; margin-top: 25px;" class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">

        <form method="POST" action="{{ route('category.post') }}">
            @csrf
    
            <!-- Name -->
            <div>
                <x-input-label for="name" :value="__('Name')" />
                <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div> 
    
            <div class="mt-4">
                <x-input-label for="parent_id" :value="__('Parent')" />
                <select id="parent_id" class="block mt-1 w-full" name="parent_id" :value="old('parent_id')" required >
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>                        
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('select')" class="mt-2" />
            </div>
            
            <!-- Description -->
            <div class="mt-4">
                <x-input-label for="description" :value="__('Description')" />
                <x-text-input id="description" class="block mt-1 w-full" type="text" name="description" :value="old('description')" required  />
                <x-input-error :messages="$errors->get('description')" class="mt-2" />
            </div> 
    
            <div class="flex items-center justify-end mt-4"> 
    
                <x-primary-button class="ms-4">
                    {{ __('Add') }}
                </x-primary-button>
            </div>
        </form>
    </div>

    @stop
    @endif
@endauth