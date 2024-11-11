@props(['name', 'description', 'price', 'src', 'min', 'id'])

<div class="max-w-xs overflow-hidden bg-white rounded-lg shadow-lg dark:bg-gray-800">
    <div class="px-4 py-2">
        <h1 class="text-xl font-bold text-gray-800 uppercase dark:text-white">{{ $name }}</h1>
        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">{{ $description }}</p>
    </div>

    <img class="object-cover w-full h-48 mt-2" src="{{ $src }}" alt="{{ $name }}">

    <div class="flex items-center justify-between px-4 py-2 bg-gray-900">
        <div class="grid">
            <h1 class="text-lg font-bold text-white">{{ $price }} {{ __('per unit') }}</h1>
            <h2 class="text-sm  text-gray-100">{{ __('min: ') }} {{ $min }}</h2>

        </div>
        <a href="{{ route('product.show', array('id' => $id)) }}" class="px-2 py-1 text-xs font-semibold text-gray-900 uppercase transition-colors duration-300 transform bg-white rounded hover:bg-gray-200 focus:bg-gray-400 focus:outline-none">See Product</a>

            </div>
</div>