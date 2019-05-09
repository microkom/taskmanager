@extends('layout')

@section('content')

    <ul>
    {{-- @if($employees[0]->count()) --}}
    @foreach ($employees as $item)
    <li>{{ $item }}</li>
    @endforeach
    </ul>
    {{-- @endif --}}
@endsection