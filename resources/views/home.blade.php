@extends('layouts.plantilla')
@section('title', 'Empleos en ')
@section('content')
    <div class="container mx-auto">
        @foreach ($jobs as $job)
            <x-jobCard :job=$job/>
        @endforeach
        {{ $jobs->links() }}
    </div>
@endsection
