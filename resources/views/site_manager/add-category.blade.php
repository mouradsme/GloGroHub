@auth
    @if (Auth::user()->role == 'site_manager')
<x-app-layout>

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
</x-app-layout>
@endif
@endauth