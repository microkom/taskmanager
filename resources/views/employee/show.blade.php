@extends('main')

@section('title', 'Expediente personal')

@show
@section('content')

<h4 class="text-black">{{ $employee->name}} {{ $employee->surname}}</h4>

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
            <select class="form-control"  id="position" name="position"  disabled>
                {{-- <option value="">- Empleo -</option> --}}
                
                {{-- [landing] Task list extracted from the database --}}
                {{-- @foreach ($positions as $position) --}}
                <option value="{{ $employee->position_id }}">{{ $employee->position_name }} </option>
               {{--  @endforeach --}}
                
            </select>
        </div>
        <div class="col-md-6 col-sm-6 col-xs-12">
            <label for="scale_number">Nº Escalafón</label>
        <input class="form-control" type="number" name="scale_number" value="{{ $employee->scale_number }}" id="scale_number" placeholder="Nº Escalafón" required disabled>
        </div>
    </div><br>
    <div class="form-row">       
        <div class="col-md-6 col-sm-6 col-xs-12">
            <label for="name">Nombre</label>
            <input class="form-control" type="text" name="name" id="name" value="{{ $employee->name }}" placeholder="Nombre" required disabled>
        </div>
        <div class="col-md-6 col-sm-6 col-xs-12">
            <label for="surname">Apellidos</label>
            <input class="form-control" type="text" name="surname" id="surname" value="{{ $employee->surname }}" placeholder="Apellidos" required disabled>
        </div>
    </div><br>
    <div class="form-row">       
        <div class="col-md-3 col-sm-6 col-xs-12">
            <label for="dni">DNI</label>
            <input type="text" class="form-control" name="dni" id="dni" value="{{ $employee->dni }}" placeholder="DNI" required disabled>
        </div>
        <div class="col-md-3 col-sm-6 col-xs-12">
            <label for="cip_code">Código CIP</label>
            <input type="text" class="form-control" name="cip_code" id="cip_code" value="{{ $employee->cip_code }}" placeholder="Código CIP" required disabled>
        </div>
        <div class="col-md-6 col-sm-6 col-xs-12">
            <label for="email">Email</label>
            <input type="text" class="form-control" name="email" id="email" value="{{ $employee->email }}" placeholder="Email" required disabled>
        </div>
        
    </div><br>
    <div class="form-row col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class=" col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <input  type="button" name="enviar" id="edit" value="Editar" class="btn btn-info ">

        </div>
        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <input  type="submit" name="enviar" id="store" value="Guardar" class="btn btn-info " style="display:none">
            hay que poner debajo de "fomr" la etiqueta para poder actualizar los datos en laravel, hay que crear el método con put/patch
        </div>
    </div>
    
</form>

<script type="text/javascript">
$(document).ready(function(){
    $('#edit').click(function(){
        $('input').removeAttr('disabled')
        $(this).hide();
        $('#store').show();
    });
})
</script>

@endsection