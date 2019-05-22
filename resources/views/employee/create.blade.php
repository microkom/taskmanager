@extends('main')

@section('title','Nuevo empleado')

@show
@section('content')

<h4>Nuevo</h4>
<br>

{{-- Result Message  --}}
<div class="flash-message">
    @foreach (['danger', 'warning', 'success', 'info'] as $msg)
    @if(Session::has('alert-' . $msg))
    
    <p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }} <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></p>
    @endif
    @endforeach
</div>


<form action="/employee/store" method="POST">
    
    {{-- laravel security measure --}}
    @csrf
    
    <div class="form-row">
        <div class="col-md-6 col-sm-6 col-xs-12">
            <label for="position">Empleo</label>
            <select class="form-control"  id="position" name="position" required>
                <option value="">- Empleo -</option>
                
                {{-- [landing] Task list extracted from the database --}}
                @foreach ($positions as $position)
                <option value="{{ $position->id }}">{{ $position->name }} </option>
                @endforeach
                
            </select>
        </div>
        <div class="col-md-6 col-sm-6 col-xs-12">
            <label for="scale_number">Nº Escalafón</label>
            <input class="form-control" type="number" name="scale_number" id="scale_number" placeholder="Nº Escalafón" required>
        </div>
    </div><br>
    <div class="form-row">       
        <div class="col-md-6 col-sm-6 col-xs-12">
            <label for="name">Nombre</label>
            <input class="form-control" type="text" name="name" id="name" placeholder="Nombre" required>
        </div>
        <div class="col-md-6 col-sm-6 col-xs-12">
            <label for="surname">Apellidos</label>
            <input class="form-control" type="text" name="surname" id="surname" placeholder="Apellidos" required>
        </div>
    </div><br>
    <div class="form-row">       
        <div class="col-md-3 col-sm-6 col-xs-12">
            <label for="dni">DNI</label>
            <input type="text" class="form-control" name="dni" id="dni" placeholder="DNI" required>
        </div>
        <div class="col-md-3 col-sm-6 col-xs-12">
            <label for="cip_code">Código CIP</label>
            <input type="text" class="form-control" name="cip_code" id="cip_code" placeholder="Código CIP" required>
        </div>
        <div class="col-md-6 col-sm-6 col-xs-12">
            <label for="email">Email</label>
            <input type="text" class="form-control" name="email" id="email" placeholder="Email" required>
        </div>
        
    </div><br>
    <div class="form-row">
        <div class="col-md-2 col-sm-3 col-xs-6">
            <input type="submit" name="enviar" id="enviar" value="Guardar" class="btn btn-primary">
        </div>
    </div>
    
</form>



@endsection