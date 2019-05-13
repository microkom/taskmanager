@extends('layout')

@section('title','Asignación de Tareas')

@show
@section('content')

<div class="container mx-auto">

    {{-- Form to asign a task --}}
    <form action="/addtask" method="post">

        {{-- laravel security measure --}}
        @csrf

        {{-- Task option selectors --}}
        <input type="date" name="date" id="date" required="required">
        <select id="task" name="task">
            <option value="0">- Tarea -</option>

            {{-- [landing] Task list extracted from the database --}}
            @foreach ($tasks as $key => $task)
            <option value="{{ $task->id }}">{{ $task->name }} </option>
            @endforeach

        </select>

        {{-- Position list based on task selected previously  [upon request][task_position.js] --}}
        <select id="position" name="position">
            <option value="0">- Empleo -</option>
        </select>

        {{-- how many people will do the task --}}
        <select name="quantity" id="quantity">
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
        </select>

        {{-- submit button --}}
        <input class="btn btn-info" type="submit" name="enviar" value="Asignar">
    </form>

    <script type="text/javascript" src="js/task_position.js"></script>
    <!-- JQuery must be loaded before bootstrap -->

</div>


</div>

@endsection
