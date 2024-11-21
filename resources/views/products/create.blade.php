@auth
    @if (Auth::user()->role == 'wholesaler' || Auth::user()->role == 'site_manager')

    @extends('layouts.market')
    @section('content')
    <div class="home-section">
        <div class="p-5">
            <div style=";" class="flex overflow-hidden bg-white border divide-x rounded-lg rtl:flex-row-reverse dark:bg-gray-900 dark:border-gray-700 dark:divide-gray-700">
               <a href="{{ route('marketplace') }}" class="px-4 py-2 text-sm font-medium text-gray-600 transition-colors duration-200 sm:text-base sm:px-6 dark:hover:bg-orange-500 dark:text-gray-300 hover:bg-gray-100">
                  <i class='bx bx-home'></i> 
               </a>
               <a href="{{ route('products.index') }}" class="px-4 py-2 text-sm font-medium text-gray-600 transition-colors duration-200 sm:text-base sm:px-6 dark:hover:bg-orange-500 dark:text-gray-300 hover:bg-gray-100">
                    <i class='bx bx-cabinet'></i> Products 
                </a>
                <a href="#" class="px-4 py-2 text-sm font-medium text-gray-600 transition-colors duration-200 sm:text-base sm:px-6 dark:hover:bg-orange-500 dark:text-gray-300 hover:bg-gray-100">
                     <i class='bx bx-plus'></i> Adding a new product 
                 </a>
            </div>
    <div style="margin: auto; margin-top: 25px;" class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">

        <form method="POST" action="{{ route('product.store') }}" enctype="multipart/form-data">
            @csrf

            <!-- Name -->
            <div>
                <x-input-label for="name" :value="__('Name')" />
                <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <!-- Description -->
            <div class="mt-4">
                <x-input-label for="description" :value="__('Description')" />
                <textarea id="description" class="block mt-1 w-full" name="description" required>{{ old('description') }}</textarea>
                <x-input-error :messages="$errors->get('description')" class="mt-2" />
            </div>

            <!-- Category -->
            <div class="mt-4">
                <x-input-label for="category_id" :value="__('Category')" />
                <select id="category_id" class="block mt-1 w-full" name="category_id" required>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('category_id')" class="mt-2" />
            </div>

            <!-- Price -->
            <div class="mt-4">
                <x-input-label for="price" :value="__('Price')" />
                <x-text-input id="price" class="block mt-1 w-full" type="number" name="price" :value="old('price')" step="0.01" required />
                <x-input-error :messages="$errors->get('price')" class="mt-2" />
            </div>

            <!-- Discounted Price -->
            <div class="mt-4">
                <x-input-label for="discounted_price" :value="__('Discounted Price')" />
                <x-text-input id="discounted_price" class="block mt-1 w-full" type="number" name="discounted_price" :value="old('discounted_price')" step="0.01" />
                <x-input-error :messages="$errors->get('discounted_price')" class="mt-2" />
            </div>

            <!-- Stock Quantity -->
            <div class="mt-4">
                <x-input-label for="stock_quantity" :value="__('Stock Quantity')" />
                <x-text-input id="stock_quantity" class="block mt-1 w-full" type="number" name="stock_quantity" :value="old('stock_quantity')" min="0" />
                <x-input-error :messages="$errors->get('stock_quantity')" class="mt-2" />
            </div>

            <!-- Image Upload -->
            <div class="mt-4">
                <x-input-label for="image" :value="__('Product Image')" />
                <input id="image" class="block mt-1 w-full" type="file" name="image" accept="image/*" />
                <x-input-error :messages="$errors->get('image')" class="mt-2" />
            </div>

            <!-- Status -->
            <div class="mt-4">
                <x-input-label for="status" :value="__('Status')" />
                <select id="status" class="block mt-1 w-full" name="status">
                    <option value="available" {{ old('status') == 'available' ? 'selected' : '' }}>Available</option>
                    <option value="out_of_stock" {{ old('status') == 'out_of_stock' ? 'selected' : '' }}>Out of Stock</option>
                    <option value="discontinued" {{ old('status') == 'discontinued' ? 'selected' : '' }}>Discontinued</option>
                </select>
                <x-input-error :messages="$errors->get('status')" class="mt-2" />
            </div>

            <!-- Submit Button -->
            <div class="flex items-center justify-end mt-4">
                <x-primary-button class="ms-4">
                    {{ __('Add Product') }}
                </x-primary-button>
            </div>
        </form>
    </div>

    @stop
    @endif
@endauth