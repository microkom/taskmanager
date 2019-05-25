@extends('main')

@section('title', 'Personal')

@section('content')

<h4>Personal</h4>

<br>
<p>Para editar un empleado haga click sobre el nombre</p>

<hr>
<div class="row btn-group col-md-12" role="group">
<a  href="/employee/create" class="btn btn-primary btn-lg col-md-3 col-sm-12 col-xs-12 " >Nuevo</a>
<a  href="/employee/promote" class="btn btn-primary btn-lg col-md-3 col-sm-12 col-xs-12 disabled" >Ascender</a>
<a href="/employee/disable" class="btn btn-primary btn-lg col-md-3 col-sm-12 col-xs-12 disabled" >Desactivar</a>
<a href="/employee/exclude" class="btn btn-primary btn-lg col-md-3 col-sm-12 col-xs-12 disabled" >Excluir</a>
</div>
<br><hr><br>
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