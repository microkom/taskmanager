@extends('settings')


@section('setting_content')


<h5>Empleos asignados a las tareas</h5>

<br>
<p>Qué tareas puede hacer quién.</p>

<br>

<div class="mx-auto col-xl-6 col-xl-6 col-lg-6 col-md-12 col-sm-12">
    <table id="tabla_hoy" class="table  table-sm  table-setting">
        <thead >
            <tr><th scope="col">Tarea</th><th scope="col">Empleo</th></tr>
        </thead>
        <tbody>
            
            @foreach ($task as $t)
            <tr scope="row" >
                <td >{{ $t->task_name }}</td>
                <td >{{ $t->position_name }}</td>
                
            </tr>
            @endforeach
        </tbody>
    </table>    
    
    
</div>
@endsection