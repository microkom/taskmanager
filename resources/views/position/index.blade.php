{{------------------------------------------------------------------- 
   Section:      List of Positions from the database
   Author:       German Navarro
   Date:         2019 June
   School Loc.:  Manises, Spain
   
   This section shows the list of all the categories for people (positions)
   It receives a collection of all the positions in the database sent
   from PositionController@index
   
   It is also possible to update and delete new possitions from
   the same page by clicking on the name of each position.
   
   For creating a new one there is an input field to fill out at the 
   bottom of the list.
   
   Warnings are prompted when attempting to update or erase a position in the list.
   
   Jquery is used to activate or disable elements for updating, saving 
   and deleting positions.
   
   Bootstrap 4. used in almost all elements.
   
   -------------------------------------------------------------------}}
   


   @extends('settings')
   
   @section('setting_content')

   <span id="position-index-blade" class="d-none"></span>

   {{-- Result Message  --}}
   @include('result_message')
   
   <h5>Configuración de los empleos (categorías)</h5>
   
   <br>
   
   <p>Empleos existentes. Haga click en un empleo para modificarlo</p>
   
   <div class="mx-auto col-xl-6 col-xl-6 col-lg-6 col-md-12 col-sm-12">
      
      {{-- Table to show list of all the positions --}}
      <table id="tabla_hoy" class="table table-sm  ">
         
         <thead>
            <tr><th scope="col">Empleo</th></tr>
         </thead>
         
         <tbody>
            
            @foreach ($position as $pos)
            
            <tr scope="row">
               
               <td class="editable form-row   " id="pos_td_{{ $pos->id }} ">
                  
                  {{-- Form to update a position --}}
                  <form action="/position/update/{{ $pos->id}}" method="post">
                     
                     {{-- Laravel security meassure --}}
                     @csrf
                     
                     {{-- HTTP method --}}
                     @method('PATCH')
                     
                     {{-- Input field and button --}}
                     <input type="hidden" name="id" class="id form-control" value="{{$pos->id}}">
                     <input type="text" name="name" class="pos_input " id="pos_input_edit_{{$pos->id}}" value="{{ $pos->name }}" disabled>
                     <input type="submit"   value="Guardar" class="btn btn-outline-success btn-sm save"  style="display:none" >
                     
                  </form>
                  
                  {{-- Form to delete a position --}}
                  <form action="/position/delete/{{ $pos->id}}" method="post">
                     
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
         
         {{-- Table for new position form --}}
         <table>
            
            <tr>
               
               <td class="editable col-xl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12">
                  
                  {{-- Form to save a new position --}}
                  <form action="/position/create" method="post">
                     
                     @csrf
                     
                     <input type="text" name="name" class="pos_input " id="pos_input_create" placeholder="Nuevo empleo " disabled>
                     <input type="submit" class="btn btn-outline-success btn-sm" style="display:none" value="Guardar">
                     
                  </form>
                  
               </td>
               
            </tr>
            
         </table>
         
      </div>
   </div>
   
   <script type="text/javascript">
      
   </script>
   
   {{-- end of section: List of Positions from the database -------}}
   @endsection