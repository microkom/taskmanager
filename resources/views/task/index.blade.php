{{------------------------------------------------------------------- 
   Section:      List of tasks from the database
   Author:       German Navarro
   Date:         2019 June
   School Loc.:  Manises, Spain
   
   This section shows the list of all tasks.
   It receives a collection of all the tasks in the database sent
   from TaskController@index_task
   
   It is also possible to update and delete new tasks from
   the same page by clicking on the name of each task.
   
   For creating a new one there is an input field to fill out at the 
   bottom of the list.
   
   Warnings are prompted when attempting to update or erase a task in the list.
   
   Jquery is used to activate or disable elements for updating, saving 
   and deleting tasks.
   
   Bootstrap 4. used in almost all elements.
   
   -------------------------------------------------------------------}}
   


   @extends('settings')
   
   @section('setting_content')


   {{-- Result Message  --}}
   @include('result_message')
   
   <h5>Configuración de las tareas </h5>
   
   <br>
   
   <p>Tareas existentes. Haga click en una tarea para modificarla</p>
   
   <div class="mx-auto col-xl-6 col-xl-6 col-lg-6 col-md-12 col-sm-12">
      
      {{-- Table to show list of all the tasks --}}
      <table id="tabla_hoy" class="table table-sm  ">
         
         <thead>
            <tr><th scope="col">Tarea</th></tr>
         </thead>
         
         <tbody>
            
            @foreach ($tasks as $task)
            
            <tr scope="row">
               
               <td class="editable form-row"  >
                  
                  {{-- Form to update a task --}}
                  <form action="/task/update/{{ $task->id}}" method="post">
                     
                     {{-- Laravel security meassure --}}
                     @csrf
                     
                     {{-- HTTP method --}}
                     @method('PATCH')
                     
                     {{-- Input field and button --}}
                     <input type="hidden" name="id" class="id form-control" value="{{$task->id}}">
                     <input type="text" name="name" class="pos_input "  value="{{ $task->name }}" disabled>
                     <input type="submit"   value="Guardar" class="btn btn-outline-success btn-sm save"  style="display:none" >
                     
                  </form>
                  
                  {{-- Form to delete a task --}}
                  <form action="/task/delete/{{ $task->id}}" method="post">
                     
                     {{-- Laravel security meassure --}}
                     @csrf
                     
                     {{-- HTTP method --}}
                     @method('DELETE')

                     <input type="submit" class="btn btn-outline-danger btn-sm delete"  style="display:none" value="Borrar">
                  
                  </form>
                  
               </td>
               
            </tr>
            
            @endforeach
            
         </tbody>
      </table>    
      
      <br>
      
      <div class="border border-primary btn mx-auto col-xl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12">
         
         {{-- Table for new task form --}}
         <table>
            
            <tr>
               
               <td class="editable col-xl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12">
                  
                  {{-- Form to save a new task --}}
                  <form action="/task/create" method="post">
                     
                     @csrf
                     
                     <input type="text" name="name" class="pos_input " id="pos_input_create" placeholder="Nueva tarea " disabled>
                     <input type="submit" class="btn btn-outline-success btn-sm" style="display:none" value="Guardar">
                     
                  </form>
                  
               </td>
               
            </tr>
            
         </table>
         
      </div>
   </div>
   
   <script type="text/javascript">
      
   </script>
   
   {{-- end of section: List of tasks from the database -------}}
   @endsection