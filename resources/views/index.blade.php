@extends('layout')

@section('title','Asignación de Tareas')
    
@show
@section('content')

<p>Listado de Presentes <br>{{ $date }} </p>
    <ul>
    {{-- @if($employees[0]->count()) --}}
    @foreach ($employees as $key => $value)
        <li>{{ $value->id }},{{ $value->name }}, {{ $value->scale_number}}, {{ $value->rank_id}}</li>
    @endforeach
    </ul>
    {{-- @endif --}}

@endsection