@extends('layouts.market')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold mb-4">Holidays</h1>
    <table class="min-w-full bg-white shadow-md rounded-lg">
        <thead>
            <tr>
                <th class="px-6 py-3 border-b-2 text-left text-sm font-semibold text-gray-600">Name</th>
                <th class="px-6 py-3 border-b-2 text-left text-sm font-semibold text-gray-600">Start Date</th>
                <th class="px-6 py-3 border-b-2 text-left text-sm font-semibold text-gray-600">End Date</th>
                <th class="px-6 py-3 border-b-2 text-left text-sm font-semibold text-gray-600">Status</th>
                <th class="px-6 py-3 border-b-2 text-left text-sm font-semibold text-gray-600">Category</th>
            </tr>
        </thead>
        <tbody>
            @foreach($holidays as $holiday)
                <tr>
                    <td class="px-6 py-4 border-b text-gray-700">{{ $holiday->name }}</td>
                    <td class="px-6 py-4 border-b text-gray-700">{{ $holiday->start_date }}</td>
                    <td class="px-6 py-4 border-b text-gray-700">{{ $holiday->end_date }}</td>
                    <td class="px-6 py-4 border-b text-gray-700">{{ ucfirst($holiday->status) }}</td>
                    <td class="px-6 py-4 border-b text-gray-700">{{ $holiday->category->name }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@stop
