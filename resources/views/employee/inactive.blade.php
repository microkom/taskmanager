@extends('main')

@section('title','Personal fuera de servicio')

@show
@section('content')

<div class="title py-3">
    <h4>Personal fuera de servicio</h4>
</div>
<br>
<hr>
{{-- Result Message  --}}
@include('result_message')
<div>
    
     
    <table id="tabla_hoy">
        <thead>
            <tr><th>Empleo</th><th>Nº Esc.</th><th>Nombre</th><th>DNI</th><th>Código CIP</th>{{-- <th>email</th> --}}</tr>
        </thead><tbody>
            
            @foreach ($employees as $employee)
            <tr>
                <td>{{ $employee->position_name }}</td>
                <td>{{ $employee->scale_number }}</td>
                <td><a href="/employee/{{$employee->id}}"> {{ $employee->name  }} {{ $employee->surname }} </a></td>
                <td>{{ $employee->dni }}</td>
                <td>{{ $employee->cip_code }}</td>
                {{-- <td>{{ $employee->email }}</td> --}}
            </tr>
            @endforeach
        </tbody>
    </table>
        
        
        
    </div>
@endsection