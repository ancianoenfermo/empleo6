@extends('layouts.plantilla')
@section('title', 'Empleos en ')
@section('content')
    <div class="container mx-auto mt-5 bg-gray-100">
        @foreach ($jobs as $job)
            <x-jobCard :job=$job />
        @endforeach
        @if ($jobs->hasPages())
            <div class="bg-gray-50 px-4 py-3 mt-5 mb-5 mr-2 items-center justify-between border-t border-gray-200 sm:px-6">
                {{ $jobs->links() }}
            </div>
        @endif

    </div>
@endsection
