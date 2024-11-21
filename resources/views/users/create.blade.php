@auth
    @if (Auth::user()->role == 'site_manager')

    @extends('layouts.market')
    @section('content')
    <div class="home-section">
        <div class="p-5">
            <div style=";" class="flex overflow-hidden bg-white border divide-x rounded-lg rtl:flex-row-reverse dark:bg-gray-900 dark:border-gray-700 dark:divide-gray-700">
               <a href="{{ route('marketplace') }}" class="px-4 py-2 text-sm font-medium text-gray-600 transition-colors duration-200 sm:text-base sm:px-6 dark:hover:bg-orange-500 dark:text-gray-300 hover:bg-gray-100">
                  <i class='bx bx-home'></i> 
               </a>
               <a href="{{ route('users') }}" class="px-4 py-2 text-sm font-medium text-gray-600 transition-colors duration-200 sm:text-base sm:px-6 dark:hover:bg-orange-500 dark:text-gray-300 hover:bg-gray-100">
                    <i class='bx bx-user'></i> Users 
                </a>
                <a href="#" class="px-4 py-2 text-sm font-medium text-gray-600 transition-colors duration-200 sm:text-base sm:px-6 dark:hover:bg-orange-500 dark:text-gray-300 hover:bg-gray-100">
                     <i class='bx bx-plus'></i> Adding a new user 
                 </a>
            </div>

            <div  class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">

        <form method="POST" action="{{ route('add_user.post') }}">
            @csrf
    
            <!-- Name -->
            <div>
                <x-input-label for="name" :value="__('Name')" />
                <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>
    
            <!-- Email Address -->
            <div class="mt-4">
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>
    
    
            <div class="mt-4">
                <x-input-label for="role" :value="__('Role')" />
                <select id="role" class="block mt-1 w-full" name="role" :value="old('role')" required >
                    <option value="site_manager">Admin</option>
                    <option value="wholesaler">Wholesaler/Supplier</option>
                    <option value="retailer">Retailer</option>
                </select>
                <x-input-error :messages="$errors->get('select')" class="mt-2" />
            </div>
    
            <!-- Password -->
            <div class="mt-4">
                <x-input-label for="password" :value="__('Password')" />
    
                <x-text-input id="password" class="block mt-1 w-full"
                                type="password"
                                name="password"
                                required autocomplete="new-password" />
    
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>
    
            <!-- Confirm Password -->
            <div class="mt-4">
                <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
    
                <x-text-input id="password_confirmation" class="block mt-1 w-full"
                                type="password"
                                name="password_confirmation" required autocomplete="new-password" />
    
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>
    
            <div class="flex items-center justify-end mt-4"> 
    
                <x-primary-button class="ms-4">
                    {{ __('Add') }}
                </x-primary-button>
            </div>
        </form>
    </div>
    </div>
    @stop
@endif
@endauth