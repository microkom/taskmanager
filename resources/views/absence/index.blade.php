@extends('main')

@section('title', 'Aunsencias')

@section('content')


<h3 class="title py-3"><span class=" p-2">Ausencias&ensp;&ensp;</span>    </h3>
<br>

<script>
    /*      $(document).ready(function(){
        var path = window.location.pathname.substring(1)
        console.log(path)
        $('#' + path).addClass('border');
    }) */
</script>
<div class="text-dark btn border col-12 bg-whitesmoke"><h5>Búsqueda</h5>
    
    <form action="/absences/search" method="post">
        @csrf
        <div class="form-group form-sm row">
            <div class="mx-auto row">
                <input class="form-control col-xl-5 col-lg-5 col-md-5 col-sm-12" type="date" name="start_date" id="start_date"  value="{{ session()->get('absence.index.sdate')}}">
                <input class="form-control col-xl-5 col-lg-5 col-md-5 col-sm-12" type="date" name="end_date" id="end_date" value="{{ session()->get('absence.index.edate')}}">
                <input class="form-control col-xl-2 col-lg-2 col-md-2 col-sm-12 btn btn-light border-dark" type="submit" value="Buscar">
            </div>
        </div>
        <div>
            
        </div>
    
</form>
</div>
<br><br>

<table id="tabla_hoy" class="table table-sm">
    <thead class="thead-dark">
        <tr><th>Nombre</th><th>F. inicio</th><th>F. fin</th><th>Notas</th></tr>
    </thead><tbody>
        @foreach ($absences as $absence)
        <tr>
            <td>{{ $absence->name }}</td>
            <td>{{ $absence->start_date_time }}</td>
            <td>{{ $absence->end_date_time}}</td>
            <td>{{ $absence->note }}</td>
            
        </tr>
        @endforeach
    </tbody>
</table>

<br><br>
<a href="/absences/create" class="btn btn-clear border border-primary col-12">Nueva ausencia</a>

@endsection
