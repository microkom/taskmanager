@extends('main')

@section('title','Nuevo empleado')

@show
@section('content')

<div class="title py-3">
    <h4>Nuevo</h4>
    <h5>Información personal</h5>
</div>
<br>
<hr>
{{-- Result Message  --}}
@include('result_message')


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
            <input type="text" class="form-control" name="dni" id="dni" placeholder="DNI" required >
            <span id="msg" > </span>
            
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
            <input type="submit" name="enviar" id="enviar" value="Guardar" class="btn btn-outline-primary">
        </div>
    </div>
    
</form>
<script type="text/javascript">
    function validateDNI(dni) {
        var numero, let, letra;
        var expresion_regular_dni = /^[XYZ]?\d{5,8}[A-Z]$/;
        
        dni = dni.toUpperCase();
        
        if(expresion_regular_dni.test(dni) === true){
            numero = dni.substr(0,dni.length-1);
            numero = numero.replace('X', 0);
            numero = numero.replace('Y', 1);
            numero = numero.replace('Z', 2);
            let = dni.substr(dni.length-1, 1);
            numero = numero % 23;
            letra = 'TRWAGMYFPDXBNJZSQVHLCKET';
            letra = letra.substring(numero, numero+1);
            if (letra != let) {
                //alert('Dni erroneo, la letra del NIF no se corresponde');
                return false;
            }else{
                //alert('Dni correcto');
                return true;
            }
        }else{
            //alert('Dni erroneo, formato no válido');
            return false;
        }
    }
</script>
<script>$('#dni').on('input', function() {
    if($('#dni').val().length > 4){
        if (validateDNI($(this).val())) {
            $('#msg').removeClass()
            $('#msg').addClass('text-success')
            $('#msg').html('DNI Correcto')
        }else{
            $('#msg').removeClass()
            $('#msg').addClass('text-danger')
            $('#msg').html('DNI Incorrecto')
        }
    }
});</script>

@endsection