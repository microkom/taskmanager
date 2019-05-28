@extends('main')

@section('title', 'Configuración')

@section('content')

{{-- Title --}}
<div class="title py-3">
    <h4>Configuración</h4>
</div>

<br>
<hr>

{{-- General setting buttons --}}
<div class="row  col-md-12"  >
    <a href="/settings/general" 
        class="btn btn-outline-info btn-sm col-md-3 col-sm-12 col-xs-12 disabled 
         " >General</a>
    <a href="/settings/taskposition" 
        class="btn btn-outline-info btn-sm col-md-3 col-sm-12 col-xs-12
        <?php if(request()->path() == 'settings/taskposition') echo 'active' ?>">Empleo/Tarea</a>
    <a href="/settings/position" 
        class="btn btn-outline-info btn-sm col-md-3 col-sm-12 col-xs-12 
        <?php if(request()->path() == 'settings/position') echo 'active' ?>">Empleo</a>
    <a href="/settings/personnel" 
        class="btn btn-outline-info btn-sm col-md-3 col-sm-12 col-xs-12 disabled
        <?php if(request()->path() == 'settings/personnel') echo 'active' ?>" >Tarea</a>
</div>

<hr><br>

<div>

    @yield('setting_content')
    
</div>
@endsection