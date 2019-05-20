@extends('main')

@section('title','Asignación de Tareas')

@show
@section('content')

<div class="container mx-auto">
    
    <h1 class="text-center">Asignación de tareas</h1>
    <hr>
    @if(isset($error))
    <div class="text-center alert alert-danger">
        <h5>{{$error}}</h5>
    </div>
    
    @endif
    @if(isset($counter))
    
    <div class="text-center alert alert-success alert-dismissible fade show" role="alert">
        @if($counter==1)
        <h5>Se ha añadido {{ $counter}} tarea </h5>
        @else
        <h5>Se han añadido {{ $counter}} tareas </h5>
        @endif
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    
    @endif

    
    {{-- Form to asign a task --}}
    <form action="/assigntask" method="post">
        
        {{-- laravel security measure --}}
        @csrf
        
        <div class="form-row">
            {{-- Task option selectors --}}
            <div class="col-md-4 col-sm-6 col-xs-12">
                <label for="date">Fecha</label>
                <input class="form-control " type="date" name="date" id="date" placeholder="Fecha 2015-01-31" required="required">
            </div>
            <div class="col-md-3 col-sm-6 col-xs-12">
                <label for="task">Tarea</label>
                <select class="form-control"  id="task" name="task" required>
                    <option value="">- Tarea -</option>
                    
                    {{-- [landing] Task list extracted from the database --}}
                    @foreach ($tasks as $key => $task)
                    <option value="{{ $task->id }}">{{ $task->name }} </option>
                    @endforeach
                    
                </select>
            </div>
            
            {{-- Position list based on task selected previously  [upon request][task_position.js] --}}
            <div class="col-md-3 col-sm-4 col-xs-12">
                <label for="position">Empleo</label>
                <select class="form-control " id="position" name="position" required>
                    <option value="">- Empleo -</option>
                </select>
            </div>
            
            {{-- how many people will do the task --}}
            <div class="col-md-2 col-sm-4 col-xs-12">
                <label for="quantity">PAX.</label>
                <select class="form-control " name="quantity" id="quantity" required>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                    <option value="10">10</option>
                    <option value="15">15</option>
                </select>
            </div>
            
            {{-- submit button --}}
            <div class="col-md-2 col-sm-4 col-xs-12">
                <br>
                <button class="btn btn-info " type="submit" name="enviar" value="Asignar" id="asignar">Asignar</button>
            </div>
        </div>
    </form>
    
    <div ><br><hr><br>
        @if(isset($today_tasks))
        
        {{--  <div class="alert alert-primary text-center" role="alert">
            <h4 class="">{{ $today_tasks[0]['date']}}</h4>
        </div> --}}
        
        <table id="tabla_hoy">
            <thead>
                <tr><td>Empleo</td><td>Nombre</td><td>Servicio</td><td>Fecha</td></tr>
            </thead><tbody>
                
                @foreach ($today_tasks as $task)
                <tr>
                    <td>{{$task['position']}}</td>
                    <td>{{$task['employee']}}</td>
                    <td>{{$task['task']}}</td>
                    <td>{{ date('d M Y', strtotime($task['date'])) }}</td>
                </tr>
                @endforeach
            </tbody></table>
            
            @else 
            <div class="alert alert-primary text-center" role="alert">
                <h4 >No hay Servicios en esta fecha</h4>
            </div> 
            @endif
            
        </div>
        
        <script type="text/javascript" src="/js/task_position.js"></script>
        <!-- JQuery must be loaded before bootstrap -->
        
        
        
        
    </div>
    <script>
        $(document).ready( function () {
            $('#tabla_hoy').DataTable();
        } );
    </script>
    @endsection
    