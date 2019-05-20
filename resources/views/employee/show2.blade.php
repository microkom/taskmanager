@extends('main')

@section('title', 'Expediente personal')

@show
@section('content')

<h4 class="text-black">{{ $employee->name}} {{ $employee->surname}}</h4>

    
@endsection