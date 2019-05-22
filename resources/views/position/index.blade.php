@extends('settings')


@section('setting_content')
<div class="text-right">
    <a href="/position/create">
        <button class="btn btn-info" id="settings_position_create">Nuevo</button>
    </a>
 {{--    <a href="/position/edit">
        <button class="btn btn-info" id="settings_position_update">Editar</button>
    </a> --}}
</div>


<h4>Configuración de los empleos (categorías)</h4>
<br>
<p>Empleos existentes.</p>

<div class="mx-auto col-xl-6 col-xl-6 col-lg-6 col-md-12 col-sm-12">
    <table class="table table-sm  ">
        <thead class="thead-dark ">
            <tr><th scope="col">Empleo</th><th scope="col"></th></tr>
        </thead><tbody>
            
            @foreach ($position as $pos)
            <tr scope="row">
                <td class="editable" id="pos_td_{{ $pos->id }}">
                    <form action="/position/update/{{ $pos->id}}" method="post">
                        <input type="hidden" name="id" value="{{$pos->id}}">
                        <input type="text" name="{{ $pos->name }}" class="pos_input " id="pos_input_edit_{{$pos->id}}" value="{{ $pos->name }}" disabled>
                        &ensp;<input type="submit"  name="position_name" style="display:none" value="Guardar" class="btn btn-success btn-sm">
                    </form>
                </td>
                <td class="text-right"><a href="/position/delete" class="btn btn-light btn-sm">Borrar</a></td>
            </tr>
            @endforeach
        </tbody>
    </table>    
    
    
</div>
<script type="text/javascript">
    $(document).ready(function(){
        var count = 0
        $('td.editable').click(function(){
            if(count < 1){
                count++; 
               
                
 
                swal({
                    title: "Confirmar",
                    text: "Desea editar esta entrada?",
                    icon: "warning",
                    buttons: true,
                    dangerMode: false,
                })
                .then((willSave) => {
                    if (willSave) {
                         $(this).find('.pos_input').removeAttr('disabled');
                        $(this).find('.btn').show();
                    } else {
                        count = 0
                    }
                });
            } 
        })
        
    })
</script>
@endsection