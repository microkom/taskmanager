@extends('main')

@section('title','Asignación de Tareas')

@show
@section('content')


<div class="container mx-auto">
  
  @if (!auth()->guest())                   
  
  @if(auth()->user()->employee->role->id === 2)  
  <h4 class="text-uppercase text-dark title py-3">Tareas Programadas</h4>
  @endif
  @endif
  
  @if (!auth()->guest())                   
  
  @if(auth()->user()->employee->role->id === 1) 
  <div class="title py-3">
    <h4 class="text-uppercase text-dark">Asignación de tareas</h4>
  </div>
  @endif
  @endif
  
  <br>
  
  @if(isset($counter))
  
  <div class="text-center alert alert-success alert-dismissible fade show py-3" role="alert">
    @if($counter === 1)
    <h5>Se ha añadido {{ $counter}} tarea </h5>
    @else
    <h5>Se han añadido {{ $counter}} tareas </h5>
    @endif
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
  
  @endif
  <br>
  @include('result_message')
  
  @if (!auth()->guest())                   
  
  @if(auth()->user()->employee->role->id === 1) 
  
  {{-- Form to asign a task --}}
  <form action="/assigntask" method="post" class="py-3">
    
    {{-- laravel security measure --}}
    @csrf
    
    <div class="bg-whitesmoke p-3 btn col-12">
      <div class="form-row justify-content-center ">
        {{-- Task option selectors --}}
        <div class="col-md-4 col-sm-6 col-xs-12">
          <label for="date">Fecha</label>
          <input class="form-control " type="date" name="date" id="date" placeholder="Fecha 2015-01-31" required="required">
        </div>
        <div class="col-md-3 col-sm-6 col-xs-12">
          <label for="task">Tarea</label>
          <select class="form-control"  id="task_assign_task" name="task" required>
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
          <select class="form-control " id="position_assign_task" name="position" required>
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
          </select> 
        </div>
      </div>  
      
    </div>
    {{-- submit button --}}
    <div class="col-md-2 col-sm-4 col-xs-12">
      <br>
      <button class="btn btn-outline-info" type="submit" name="enviar" value="Asignar" id="asignar">Asignar</button>
    </div>
    
    
  </form>
  
  @endif
  @endif
  <div ><br><hr><br>
    @if(isset($today_tasks))
    
    <table id="tabla_hoy" class="table table-sm table-border">
      <thead>
        <tr><th>Empleo</th><th>Nombre</th><th>Servicio</th><th>Fecha</th><th></th></tr>
      </thead><tbody>
        
        @foreach ($today_tasks as $task)
       
        <tr>
          <td>{{$task['position']}}</td>
          <td><a href="/assignTask/show/{{$task['employee_id']}}">{{$task['employee']}}</a></td>
          <td>{{$task['task']}}</td>
          <td>{{ date('d M Y', strtotime($task['date'])) }}</td>
          <td class="text-center">
            @if (!auth()->guest())                   
            
              @if(auth()->user()->employee->role->id === 1) 
                <a class="delete-link" href="/assignTask/delete/{{$task['id']}}"> Borrar </a>
              @endif
            @endif
          </td>
        </tr>
        @endforeach
      </tbody></table>
      
      @else 
      <div class="alert alert-success text-center" role="alert">
        <h4 >No hay Servicios en esta fecha</h4>
      </div> 
      @endif
      
    </div>
    
    {{--  <script type="text/javascript" src="/js/task_position.js"></script> --}}
    <!-- JQuery must be loaded before bootstrap -->
    
    
    
    
  </div>
  <script>
    /* Delete Link */
    /*  $(document).ready(function(){
      
      $('.delete-link').on('click', function (e) {
        console.log($(this))
        try {
          e.preventDefault()
          swal({
            title: "Borrar",
            text: "Desea borrar esta entrada?",
            icon: "warning",
            buttons: true,
            dangerMode: true,
          })
          .then((willSave) => {
            try {
              if (willSave) {
                window.location.href ='/assignTask/delete/{{$task['id']}}'
              }
            } catch (err) {
              console.log(err)
            }
          });
        } catch (er) {
          console.log(er)
        }
      })
    }) */
    
  </script>
  @endsection
  