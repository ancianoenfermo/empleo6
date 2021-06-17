@extends('layouts.plantilla')
@section('title', 'Empleos en ')
@section('content')

    @foreach ($jobs as $job )
       {{$job->title}}-{{$job->provincia}}-{{$job->localidad}}<br>
    @endforeach
{{$jobs->links()}}
@endsection
