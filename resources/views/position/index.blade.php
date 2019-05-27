@extends('settings')


@section('setting_content')

{{-- Result Message  --}}
<div class="flash-message">
    @foreach (['danger', 'warning', 'success', 'info'] as $msg)
    @if(Session::has('alert-' . $msg))
    
    <p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }} <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></p>
    @endif
    @endforeach
</div>

<h4>Configuración de los empleos (categorías)</h4>
<br>
<p>Empleos existentes. Haga click en un empleo para modificarlo</p>

<div class="mx-auto col-xl-6 col-xl-6 col-lg-6 col-md-12 col-sm-12">
    <table class="table table-sm  ">
        <thead class="thead-dark ">
            <tr><th scope="col">Empleo</th><th scope="col"></th></tr>
        </thead><tbody>
            
            @foreach ($position as $pos)
            <tr scope="row">
                <td class="editable" id="pos_td_{{ $pos->id }}">
                    <form action="/position/update/{{ $pos->id}}" method="post">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="id" class="id" value="{{$pos->id}}">
                        <input type="text" name="name" class="pos_input " id="pos_input_edit_{{$pos->id}}" value="{{ $pos->name }}" disabled>
                        &ensp;<input type="submit"   value="Guardar" class="btn btn-success btn-sm save"  style="display:none" >
                    </form>
                </td>
                <td class="text-right">
                    <form action="/position/delete/{{ $pos->id}}" method="post">
                        @csrf
                        @method('DELETE')
                        <input type="submit" class="btn btn-light btn-sm delete"  style="display:none" value="Borrar">
                    </form>
                </td>
                
            </tr>
            @endforeach
        </tbody>
        
        
    </table>    
    
    
    <div class="border border-primary btn mx-auto col-xl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12">
        <table>
            <tr>
                <td class="editable col-xl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12">
                    <form action="/position/create" method="post">
                        @csrf
                        <input type="text" name="name" class="pos_input " id="pos_input_create" placeholder="Nuevo empleo " disabled>
                        <input type="submit" class="btn btn-light btn-sm" style="display:none" value="Guardar">
                    </form>
                </td>
            </tr>
        </table>
        
    </div>
</div>


{{-- add warnings --}}


<script type="text/javascript">
    $(document).ready(function(){
        var count = 0
        $('td.editable').click(function(){
            
            if(count < 1){
                $(this).find('.pos_input').removeAttr('disabled').css('border', '1px solid lightgray').css('border-radius', '3px ')
                $(this).parent().find('.btn').show();
                
                
                count++;                
            } else {
                
            }
        });
        
        
        $('.save').click(function(e){
            e.preventDefault()
            var form = $(this).parents('form');
            swal({
                title: "Guardar",
                text: "Desea guardar esta entrada?",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willSave) => {
                if (willSave) {
                    form.submit();
                    
                } else {
                    
                }
            });
        })
        $('.delete').on('click', function(e){
            try{
                e.preventDefault()
                var form = $(this).parents('form');
                swal({
                    title: "Borrar",
                    text: "Desea borrar esta entrada?",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willSave) => {
                    try{
                    if (willSave) {
                        form.submit();
                        
                    } else {
                        $(this).parent().parent().parent().find('.pos_input').removeAttr('style').prop('disabled','disabled')
                        $(this).parent().parent().parent().find('.btn').hide();
                    }
                }catch(err){
                    console.log(err)
                }
                });
            }catch(er){
                console.log(er)
            }
        })
        
    })
</script>
@endsection