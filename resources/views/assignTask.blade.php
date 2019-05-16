@extends('layout')

@section('title','Asignación de Tareas')

@show
@section('content')

<div class="container mx-auto">

    @if(isset($error))
        <div class="text-center alert alert-warning">
            <h5>{{$error}}</h5>
        </div>

    @endif
 @if(isset($counter))
        <div class="text-center alert alert-success">
            <h5>You've added {{ $counter}} tasks</h5>
        </div>

    @endif

    {{-- Form to asign a task --}}
    <form action="/assigntask" method="post">

        {{-- laravel security measure --}}
        @csrf

        <div class="form-row">
            {{-- Task option selectors --}}
            <input class="form-control col-md-3  col-sm-6 col-xs-12" type="date" name="date" id="date" required="required">
            <select class="form-control col-md-4 col-sm-6 col-xs-12" id="task" name="task" required>
                <option value="">- Tarea -</option>

                {{-- [landing] Task list extracted from the database --}}
                @foreach ($tasks as $key => $task)
                <option value="{{ $task->id }}">{{ $task->name }} </option>
                @endforeach

            </select>

            {{-- Position list based on task selected previously  [upon request][task_position.js] --}}
            <select class="form-control col-md-2 col-sm-6 col-xs-12" id="position" name="position" required>
                <option value="">- Empleo -</option>
            </select>

            {{-- how many people will do the task --}}
            <select class="form-control col-md-1 col-sm-6 col-xs-12" name="quantity" id="quantity" required>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
                <option value="10">10</option>
                <option value="15">15</option>
            </select>

            {{-- submit button --}}
            <input class="btn btn-info col-md-2" type="submit" name="enviar" value="Asignar">
        </div>
    </form>

    <script type="text/javascript" src="/js/task_position.js"></script>
    <!-- JQuery must be loaded before bootstrap -->

</div>


</div>
<script>
    $(document).ready( function () {
        $('#table_id').DataTable();
    } );
</script>
@endsection
