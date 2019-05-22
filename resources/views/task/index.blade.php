@extends('settings')


@section('setting_content')

<h4>Tareas <==> Empleo</h4>

<br>

<hr>

    <table class="table table-hover col-xl-6 col-lg-6 col-md-12 col-sm-12">
        <thead class="thead-dark">
            <tr><th scope="col">Tarea</th><th scope="col">Empleo</th></tr>
        </thead><tbody>
            
            @foreach ($task as $t)
            <tr scope="row">
                <td>{{ $t->task_name }}</td>
                <td>{{ $t->position_name }}</td>
               
            </tr>
            @endforeach
        </tbody>
    </table>    
    
        
        
@endsection