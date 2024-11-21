@extends('layouts.market')

@section('content')

<div class="home-section">
    <div class="p-5">
        <div style="position: sticky; top: 5px;" class="flex overflow-hidden bg-white border divide-x rounded-lg rtl:flex-row-reverse dark:bg-gray-900 dark:border-gray-700 dark:divide-gray-700">
           <a href="{{ route('marketplace') }}" class="px-4 py-2 text-sm font-medium text-gray-600 transition-colors duration-200 sm:text-base sm:px-6 dark:hover:bg-orange-500 dark:text-gray-300 hover:bg-gray-100">
              <i class='bx bx-home'></i> 
           </a>
           <a href="#" class="px-4 py-2 text-sm font-medium text-gray-600 transition-colors duration-200 sm:text-base sm:px-6 dark:hover:bg-orange-500 dark:text-gray-300 hover:bg-gray-100">
                <i class='bx bx-user'></i> Users 
            </a>
            <a href="{{ route('add_user') }}" class="px-4 py-2 text-sm font-medium text-gray-600 transition-colors duration-200 sm:text-base sm:px-6 dark:hover:bg-orange-500 dark:text-gray-300 hover:bg-gray-100">
                 <i class='bx bx-plus'></i> Add a new user 
             </a>
        </div>
    
    <table class="min-w-full bg-white shadow-md rounded-lg overflow-hidden">
        <thead class="bg-gray-200">
            <tr>
                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Name</th>
                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Email</th>
                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Role</th>
                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
                <tr class="border-b">
                    <td class="px-6 py-4 text-gray-700">{{ $user->name }}</td>
                    <td class="px-6 py-4 text-gray-700">{{ $user->email }}</td>
                    <td class="px-6 py-4 text-gray-700 capitalize">{{ $user->role }}</td>
                    <td class="px-6 py-4">
         
                        <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500 hover:underline">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@stop
