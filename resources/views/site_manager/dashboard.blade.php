@extends('layouts.market')

@section('content')

<div class="home-section p-5">

    <div style=";" class="flex overflow-hidden bg-white border divide-x rounded-lg rtl:flex-row-reverse dark:bg-gray-900 dark:border-gray-700 dark:divide-gray-700">
           <a href="{{ route('marketplace') }}" class="px-4 py-2 text-sm font-medium text-gray-600 transition-colors duration-200 sm:text-base sm:px-6 dark:hover:bg-orange-500 dark:text-gray-300 hover:bg-gray-100">
              <i class='bx bx-home'></i> 
           </a>
           <a href="#" class="px-4 py-2 text-sm font-medium text-gray-600 transition-colors duration-200 sm:text-base sm:px-6 dark:hover:bg-orange-500 dark:text-gray-300 hover:bg-gray-100">
                <i class='bx bx-pie-chart'></i> Analytics 
            </a>
            
        </div>
    <h1 class="mt-5 text-2xl font-bold mb-4">Analytics</h1>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {!! $chart->container() !!}
                </div>
            </div>
        </div>
    </div>

    <script src=https://cdnjs.cloudflare.com/ajax/libs/echarts/4.0.2/echarts-en.min.js charset=utf-8></script>

    {!! $chart->script() !!}


@stop