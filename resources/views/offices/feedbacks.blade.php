@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="navbar items-center w-full content-center justify-items-center">
            <a href="{{ route('offices') }}" class="bg-gray-300 text-black py-2 px-4 rounded-lg hover:bg-gray-400 hover:text-white duration-300">
                Back
            </a>
            <h1 class="text-4xl font-bold">FEEDBACKS</h1>
        </div>
        <!-- <h1 class="text-4xl font-bold mb-2 text-center">ORGANIZATIONAL CHART</h1>
        <img class="aspect-auto" src="/images/chart.png" alt="Organization Chart of LGU Tubigon"> -->
    </div>
@endsection
