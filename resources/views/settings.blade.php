@extends('main')

@section('title', 'Configuración')

@section('content')

{{-- Title --}}
<div class="title py-3">
    <h4>Configuración</h4>
</div>

<br>
<hr class="border border-info">

{{-- General setting buttons --}}
<div class="row  col-md-12 justify-content-center"  >
    <a href="/settings/taskposition" 
        class="btn btn-outline-info btn-sm col-md-3 col-sm-12 col-xs-12 mr-1
        <?php if(request()->path() == 'settings/taskposition') echo 'active' ?>">Empleo/Tarea</a>
    <a href="/settings/position" 
        class="btn btn-outline-info btn-sm col-md-3 col-sm-12 col-xs-12 mr-1 
        <?php if(request()->path() == 'settings/position') echo 'active' ?>">Empleo</a>
    <a href="/settings/task" 
        class="btn btn-outline-info btn-sm col-md-3 col-sm-12 col-xs-12 mr-1 
        <?php if(request()->path() == 'settings/task') echo 'active' ?>" >Tarea</a>
    {{--  <a href="/settings/general" 
        class="btn btn-outline-info btn-sm col-md-3 col-sm-12 col-xs-12 mr-1 disabled 
         " >General</a> --}}
       
</div>

<hr class="border border-info"><br>

<div>

    @yield('setting_content')
    
</div>
@endsection