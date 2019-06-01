{{------------------------------------------------------------------- 
    Section:      Task assignment and list of assigned tasks
    Author:       German Navarro
    Date:         2019 June
    School Loc.:  Manises, Spain
    
    This section assigns tasks. Shows the list of all the assigned tasks.
    It receives a collection from TaskController@addTask
    
    It is also possible view the assigned tasks of each user by clicking 
    on their name.
    
    It is possible to delete one assigned task to a user.
    
    Jquery is used when deleting tasks.
    
    Bootstrap 4. used in almost all elements.
    
    -------------------------------------------------------------------}}
    @extends('main')
    
    @section('title','Asignación de Tareas')
    
    @show
    @section('content')
    
    
    <div class="container mx-auto">
        
        @if (!auth()->guest())                   
        
        {{-- Regular user priviledges  --}}
        @if(auth()->user()->employee->role->id === 2)  
        <h4 class="text-uppercase text-dark title py-3">Tareas Programadas</h4>
        @endif
        @endif
        
        @if (!auth()->guest())                   
        
        {{-- Only admin priviledges  --}}
            @if(auth()->user()->employee->role->id === 1) 
            
                <div class="title py-3">
                    <h4 class="text-uppercase text-dark">Asignación de tareas</h4>
                </div>
            @endif
        @endif
        
        <br>
        
        
        @if(isset($counter))  {{-- Counter of tasks assigned --}}
        
            <div class="text-center alert alert-success alert-dismissible fade show py-3" role="alert">

                @if($counter === 1)
                    <h5>Se ha añadido {{ $counter}} tarea </h5>
                @else
                    <h5>Se han añadido {{ $counter}} tareas </h5>
                @endif

                {{-- close button  --}}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>

            </div>

        @endif

        <br>

        {{-- Result message --}}
        @include('result_message')
        
        @if (!auth()->guest())                   
        
        {{-- Only admin priviledges  --}}
        @if(auth()->user()->employee->role->id === 1) 
        
        {{-- Form to asign a task --}}
        <form action="/assigntask" method="post" class="py-3">
            
            {{-- laravel security measure --}}
            @csrf
            
            <div class="bg-whitesmoke p-3 btn col-12">
                <div class="form-row justify-content-center ">
                    
                    {{-- Task option selectors --}}
                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-xs-12">
                        <label for="date">Fecha</label>
                        <input class="form-control " type="date" name="date" id="date" placeholder="Fecha 2015-01-31" required="required">
                    </div>
                    
                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-xs-12">
                        <label for="task">Tarea</label>
                        <select class="form-control"  id="task_assign_task" name="task" required>
                            <option value="">- Tarea -</option>
                            
                            {{-- Task list extracted from the database -> TaskController@landing --}}
                            @foreach ($tasks as $key => $task)
                            <option value="{{ $task->id }}">{{ $task->name }} </option>
                            @endforeach
                            
                        </select>
                    </div>
                    
                    {{-- Position list based on task selected previously  [upon request][task_position.js] --}}
                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-xs-12">
                        <label for="position">Empleo</label>
                        <select class="form-control " id="position_assign_task" name="position" required>
                            <option value="">- Empleo -</option>
                        </select>
                    </div>
                    
                    {{-- how many people will do the task --}}
                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-xs-12">
                        
                        <label for="quantity">PAX.</label>
                        <select class="form-control " name="quantity" id="quantity" required>
                            
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            
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
        <hr>
        <div>
            <p>Listado de las tareas asignadas a todos a los usuario a partir de hoy.</p>
        </div>
        <div > <br>
            @if(isset($today_tasks))
            
            
            {{-- Table showing the list of assigned tasks from today on --}}
            <table id="tabla_hoy" class="table  table-sm  table-setting">
                <thead>
                    <tr><th>Empleo</th><th>Nombre</th><th>Servicio</th><th>Fecha</th><th></th></tr>
                </thead>
                <tbody>
                    
                    @foreach ($today_tasks as $task)
                    
                    <tr>
                        <td>{{$task['position']}}</td>
                        <td><a href="/assignTask/show/{{$task['employee_id']}}">{{$task['employee']}}</a></td>
                        <td>{{$task['task']}}</td>
                        <td>{{ date('d M Y', strtotime($task['date'])) }}</td>
                        <td class="text-center">
                            @if (!auth()->guest())                   
                            
                            @if(auth()->user()->employee->role->id === 1)
                            <input type="hidden" name="task_id" class="task_id" value="{{$task['id']}}" >
                            <a class="delete_assigned_task" href="/assignTask/delete/{{$task['id']}}"> Borrar </a>
                            @endif
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            
            @else 
            <div class="alert alert-success text-center" role="alert">
                <h4 >No hay Servicios en esta fecha</h4>
            </div> 
            @endif
            
        </div>
        
        {{--  <script type="text/javascript" src="/js/task_position.js"></script> --}}
        <!-- JQuery must be loaded before bootstrap -->
        
        
        
        
    </div>
    
    @endsection
    