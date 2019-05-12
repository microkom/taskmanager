@extends('layout')

@section('title','Asignación de Tareas')

@show
@section('content')

<div class="container mx-auto">
    
    <form action="/assingtask" method="post">
        @csrf
        
        <input type="date" name="date" id="date">
        <select id="task" name="task">
            <option value="0">- Select -</option>
            
            @foreach ($tasks as $key => $task)
            <option value="{{ $task->id }}">{{ $task->name }} </option>
            @endforeach     
            
        </select>       
        
        
        <select id="position" name="position">
            <option value="0">- Select -</option>
        </select>

        <input class="btn btn-info" type="submit" name="enviar" value="Asignar">
    </form>
    
    <script  src="js/jquery-3.3.1.js"></script>
    <script type="text/javascript" src="js/task_position.js"></script>
    <!-- JQuery must be loaded before bootstrap -->
    
</div>


</div> 

@endsection