@extends('main')

@section('title', 'Configuración')

@section('content')

<h4>Configuración</h4>

<br>

<hr>
<div class="row btn-group col-md-12" role="group">
<a href="/settings/general" class="btn btn-primary btn-lg col-md-3 col-sm-12 col-xs-12">General</a>
<a href="/settings/taskposition" class="btn btn-primary btn-lg col-md-3 col-sm-12 col-xs-12">Empleo/Tarea</a>
<a href="/settings/position" class="btn btn-primary btn-lg col-md-3 col-sm-12 col-xs-12 ">Empleo</a>
<a href="/settings/personnel" class="btn btn-primary btn-lg col-md-3 col-sm-12 col-xs-12 disabled" >Tarea</a>
</div>
<br><hr><br>
<div>
    
    @yield('setting_content')
        
        
    </div>
    @endsection