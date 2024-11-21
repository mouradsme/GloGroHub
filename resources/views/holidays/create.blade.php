@extends('layouts.market')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold mb-4">Add New Holiday</h1>
    <form action="{{ route('holidays.store') }}" method="POST" class="bg-white p-6 rounded shadow-md">
        @csrf

        <div class="mb-4">
            <label for="name" class="block text-gray-700 font-bold">Name</label>
            <input type="text" name="name" id="name" class="w-full border rounded p-2" required>
        </div>

        <div class="mb-4">
            <label for="start_date" class="block text-gray-700 font-bold">Start Date</label>
            <input type="date" name="start_date" id="start_date" class="w-full border rounded p-2" required>
        </div>

        <div class="mb-4">
            <label for="end_date" class="block text-gray-700 font-bold">End Date</label>
            <input type="date" name="end_date" id="end_date" class="w-full border rounded p-2" required>
        </div>

        <div class="mb-4">
            <label for="status" class="block text-gray-700 font-bold">Status</label>
            <select name="status" id="status" class="w-full border rounded p-2" required>
                <option value="active">Active</option>
                <option value="inactive">Inactive</option>
            </select>
        </div>

        <div class="mb-4">
            <label for="category_id" class="block text-gray-700 font-bold">Category</label>
            <select name="category_id" id="category_id" class="w-full border rounded p-2" required>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="bg-orange-600 text-white px-4 py-2 rounded">Add Holiday</button>
    </form>
</div>
@stop
