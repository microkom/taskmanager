{{------------------------------------------------------------------- 
    Section:      List of positions assigned to each task
    Author:       German Navarro
    Date:         2019 June
    School Loc.:  Manises, Spain
    
    This section shows the list of all the positions assigned to each task.
    It receives a collection from TaskController@index_task_position
    
    Bootstrap 4. used in almost all elements.
    
    -------------------------------------------------------------------}}
    
    @extends('settings')
    
    
    @section('setting_content')
    
    {{-- Result message --}}
    @include('result_message')
    
    <h5>Empleos asignados a las tareas</h5>
    
    <br>
    <p>Qué tareas puede hacer quién.</p>
    
    <br>
    
    {{-- Table of positions assigned to tasks --}}
    <div class="mx-auto col-xl-6 col-lg-8 col-md-12 col-sm-12 col-xs-12">
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
    
    <br><br></div>
   <div  class="mx-auto col-12 btn ">
         <div class="mx-auto btn border border-primary  ">
         {{-- Table for new task/position form --}}
         <table class=" mx-auto">
            
            <tr>
               
               <td class=" editable">
                  
                  {{-- Form to save a new task/position relationship --}}
                  <form action="/taskposition/create" method="post">
                     
                     @csrf
                     <div class=" form-row">
                     <div class=" form-inline">
                     <select name="task_id" id="task_id" class="form-control">
                         @foreach ($tasks as $tl)
                     <option value="{{$tl->id}}">{{$tl->name}}</option>      
                         @endforeach                        

                     </select> 
                     <select name="position_id" id="position_id" class="form-control">
                         @foreach ($positions as $pl)
                     <option value="{{$pl->id}}">{{$pl->name}}</option>      
                         @endforeach                        

                     </select>
                     
                     <br>
                     <input type="submit" class="btn btn-outline-success btn-sm save" style="display:none" value="Guardar">
                     </div>
                     </div>
                  </form>
                  
               </td>
               
            </tr>
            
         </table>
         
      </div></div>
    @endsection