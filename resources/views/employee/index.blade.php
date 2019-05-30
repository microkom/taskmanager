@extends('main')

@section('title', 'Personal')

@section('content')

<div class="title py-3">
<h4>Personal</h4>
</div>
<br>


<hr class="border border-info">
<div class="row  justify-content-center">
<a  href="/employee/create" class="btn btn-outline-info btn-sm col-md-3 col-sm-12 col-xs-12 mx-1" >Nuevo</a>
{{-- <a  href="/employee/promote" class="btn btn-outline-info btn-sm col-md-3 col-sm-12 col-xs-12 mx-1">Ascender</a> --}}
<a href="/employee/disable" class="btn btn-outline-info btn-sm col-md-3 col-sm-12 col-xs-12 mx-1 disabled" >Fuera de servicio</a>

</div>
<hr class="border border-info"><br><p>Para editar un empleado haga click sobre el nombre</p>
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