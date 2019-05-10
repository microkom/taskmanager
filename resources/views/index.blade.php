@extends('layout')

@section('title','Asignación de Tareas')
    
@show
@section('content')

<p>Listado de Presentes <br>{{ $date }} </p>
    <ul>
    {{-- @if($employees[0]->count()) --}}
    @foreach ($employees[0] as $key => $value)
        <li>{{ $value->name }}, {{ $value->scale_number}}</li>
    @endforeach
    </ul>
    {{-- @endif --}}
@endsection