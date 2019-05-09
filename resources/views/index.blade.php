@extends('layout')

@section('title', 'Tareas')

@section('content')
    <ol>
    @foreach ($employees as $item)
    <li>{{ $item->name }}</li>
    @endforeach
    </ol>
@endsection