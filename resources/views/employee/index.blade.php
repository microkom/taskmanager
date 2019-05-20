@extends('main')

@section('title', 'Personal')

@section('content')
{{-- <ol>
    @foreach ($employees as $employee)
    <li>{{ $employee->name }}</li>
    @endforeach
</ol> --}}


<div ><br><hr><br>
    
    
    <table id="tabla_hoy">
        <thead>
            <tr><td>Empleo</td><td>Nº Esc.</td><td>Nombre</td><td>DNI</td><td>Código CIP</td><td>email</td></tr>
        </thead><tbody>
            
            @foreach ($employees as $employee)
            <tr>
                <td>{{$employee['position']}}</td>
                <td>{{$employee['scale_number']}}</td>
                <td>{{ $employee['name'] }} {{ $employee['surname']}} </td>
                <td>{{$employee['dni']}}</td>
                <td>{{$employee['cip_code']}}</td>
                <td>{{$employee['email']}}</td>
            </tr>
            @endforeach
        </tbody></table>
        
        
        
    </div>
    @endsection