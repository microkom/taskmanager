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


<form action="/employee/update/{{ $employee->id }}" method="POST">
    <input type="hidden" name="id" value="{{ $employee->id }}">
    <input type="hidden" name="position" value="{{ $employee->position_id }}">
    <input type="hidden" name="position_name" value="{{ $employee->position_name }}">
    
    
    {{-- laravel security measure --}}
    @csrf
    @method('PATCH')
    
    <div class="form-row">
        <div class="col-md-6 col-sm-6 col-xs-12">
            <label for="position">Empleo</label>
            <select class="form-control"    disabled>
                {{-- <option value="">- Empleo -</option> --}}
                
                {{-- [landing] Task list extracted from the database --}}
                {{-- @foreach ($positions as $position) --}}
                <option value="{{ $employee->position_id }}">{{ $employee->position_name }} </option>
                {{--  @endforeach --}}
                
            </select>
        </div>
        <div class="col-md-6 col-sm-6 col-xs-12">
            <label for="scale_number">Nº Escalafón</label>
            <input class="form-control editable" type="number" name="scale_number" value="{{ $employee->scale_number }}" id="scale_number" placeholder="Nº Escalafón" required disabled>
        </div>
    </div><br>
    <div class="form-row">       
        <div class="col-md-6 col-sm-6 col-xs-12">
            <label for="name">Nombre</label>
            <input class="form-control editable" type="text" name="name" id="name" value="{{ $employee->name }}" placeholder="Nombre" required disabled>
        </div>
        <div class="col-md-6 col-sm-6 col-xs-12">
            <label for="surname">Apellidos</label>
            <input class="form-control editable" type="text" name="surname" id="surname" value="{{ $employee->surname }}" placeholder="Apellidos" required disabled>
        </div>
    </div><br>
    <div class="form-row">       
        <div class="col-md-3 col-sm-6 col-xs-12">
            <label for="dni">DNI</label>
            <input type="text" class="form-control editable" name="dni" id="dni" value="{{ $employee->dni }}" placeholder="DNI" required disabled>
        </div>
        <div class="col-md-3 col-sm-6 col-xs-12">
            <label for="cip_code">Código CIP</label>
            <input type="text" class="form-control editable" name="cip_code" id="cip_code" value="{{ $employee->cip_code }}" placeholder="Código CIP" required disabled>
        </div>
        <div class="col-md-6 col-sm-6 col-xs-12">
            <label for="email">Email</label>
            <input type="text" class="form-control editable" name="email" id="email" value="{{ $employee->email }}" placeholder="Email" required disabled>
        </div>
        
    </div><br>
    <div class="form-row col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-xs-12">
            <input  type="button" name="enviar" id="edit" value="Editar" class="btn btn-primary col-xl-6 col-lg-6 col-md-12 col-sm-12 col-xs-12">
            
        </div>
        <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-xs-12 store " style="display:none">
            <button  type="submit" name="enviar" id="store" value="Guardar" class="btn btn-primary col-xl-5 col-lg-5 col-md-12 col-sm-12 col-xs-12" >Guardar</button>
            <button  type="button" id="cancel" value="Guardar" class="btn btn-dark col-xl-5 col-lg-5 col-md-12 col-sm-12 col-xs-12" >Cancelar</button>
            
        </div>
    </div>

</form>

<script type="text/javascript">
    $(document).ready(function(){
        $('#edit').on('click', function(){
            $('.editable').removeAttr('disabled')
            $(this).fadeOut('slow');
            $('.store').fadeIn('slow');
        });
        $('#cancel').on('click',function(){
            $('.editable').prop('disabled', true)
            $('#edit').fadeIn('slow')
            $('.store').fadeOut('slow');
        })
        $('#store').click(function(e){
            e.preventDefault();
            var form = $(this).parents('form');
            swal({
                title: "Confirmar",
                text: "Se guardaran los datos de forma permanente",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willSave) => {
                if (willSave) {
                    form.submit();
                    /* swal("Información guardada.", {
                        icon: "success",
                    }); */
                } else {
                    swal("Información no guardada");
                }
            });
        })
    })
</script>

@endsection