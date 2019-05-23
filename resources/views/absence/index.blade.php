@extends('main')

@section('title', 'Aunsencias')

@section('content')


<h4>Ausencias</h4>
<br>
<form action="/absences/search" method="post">
    @csrf
    <input type="date" name="start_date" id="start_date">
    <input type="date" name="end_date" id="end_date">
    <input type="submit" value="Buscar">
</form>

<br>
<table id="tabla_hoy">
    <thead>
        <tr><td>Nombre</td><td>F. inicio</td><td>F. fin</td><td>Notas</td></tr>
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

@endsection
