@extends('main')

@section('title', 'Aunsencias')

@section('content')

<div class="title py-3">
<h4 ><span class=" p-2">Ausencias&ensp;&ensp;</span>    </h4>
</div>
<br>
<hr class="border border-info">
<div  class="py-1   row justify-content-center">
    <a href="/absences/create" class="btn btn-outline-info btn-sm col-md-3 ">Nueva ausencia</a>
</div>
<hr class="border border-info">
<br>
{{-- Result Message  --}}
@include('result_message')

{{-- Search the database for absent users --}}
<div class="text-dark btn border col-12 bg-whitesmoke"><h5>Búsqueda en la base de datos</h5>
    
    <form action="/absences/search" method="post">
        @csrf
        <div class="form-group form-sm row">
            <div class="mx-auto row">
                <input class="form-control col-xl-5 col-lg-5 col-md-5 col-sm-12" type="date" name="start_date" id="start_date"  value="{{ session()->get('absence.index.sdate')}}">
                <input class="form-control col-xl-5 col-lg-5 col-md-5 col-sm-12" type="date" name="end_date" id="end_date" value="{{ session()->get('absence.index.edate')}}">
                <input class="form-control col-xl-2 col-lg-2 col-md-2 col-sm-12 btn btn-light border-dark" type="submit" value="Buscar">
            </div>
        </div>     
    </form>
</div>

{{-- Text --}}
<p class="text-justify">
    <ul class="py-3 l-height-normal">
        <li>Aquí se muestran las ausencias de hoy en adelante, para buscar fechas anteriores debe realizarse una búsqueda manualmente.</li>
        <li>Para ver todas las aunsecias de un usuario haga click sobre el nombre. </li>
    </ul>             
</p>
{{-- Table showing absentees --}}
<table id="tabla_hoy" class="table table-sm">
    <thead  >
        <tr><th>Nombre</th><th>F. inicio</th><th>F. fin</th><th>Notas</th></tr>
    </thead><tbody>

        @foreach ($absences as $absence)
        <tr>
            <td ><a href="/absences/show/{{ $absence->employee_id}}" class="eraseable" data-toggle="tooltip" data-placement="right" title="Ver usuario">{{ $absence->name }}</a></td>
            <td>{{ $absence->start_date_time }}</td>
            <td>{{ $absence->end_date_time}}</td>
            <td>{{ $absence->note }}</td>
            
        </tr>
        @endforeach
    </tbody>
</table>

<br><br>




@endsection
