@extends('main')

@section('title', 'Nueva ausencia')

@section('content')

<div class="title py-3">    
<h4 >Ausencias de:&ensp;&ensp; {{$user->position}} {{$user->name}} {{ $user->surname}} </span>    </h4>
</div>
<br>
@include('result_message')
<br>
<p>Para eliminar una ausencia haga click sobre ella.</p>
<table class="border table table-sm table-hover">
    <thead class="thead-light">
        <tr>
            <th></th><th>Fecha Inicio</th><th>Fecha fin</th><th>Notas</th>
        </tr>
        <tbody>
            @php $n=1; @endphp
            @foreach ($absences as $abs)
            
            
            <tr>
                <td>@php echo $n++;  @endphp. </td>
                <td>
                    <a href="/absences/delete/{{ $abs->id}}" class="eraseable" data-toggle="tooltip" data-placement="right" title="Eliminar toda esta linea">
                         {{ date('d M Y', strtotime($abs->start_date_time)) }}
                    </a>
                </td>
                <td> 
                    <a href="/absences/delete/{{ $abs->id}}" class="eraseable" data-toggle="tooltip" data-placement="right" title="Eliminar toda esta línea">
                        {{ date('d M Y', strtotime($abs->end_date_time)) }}
                    </a>
                </td>
                <td>{{ $abs->note }}  </td> 
            </tr>
            
            
            @endforeach
        </tbody>
        <tfoot>
            
        </tfoot>
        
        <script>
            $(document).ready(function(){
                $('[data-toggle="tooltip"]').tooltip();
                
                $('.eraseable').click(function(e){
                    e.preventDefault()
                    let that = $(this)
                    
                    try{
                        swal({
                            title: "Eliminar",
                            text: "Confirma que desea eliminar esta ausencia? ",
                            icon: "warning",
                            buttons: true,
                            dangerMode: true,
                        })
                        .then((willDelete) => {
                            if (willDelete) {
                                that.hide('slow')
                                window.location = that.attr('href');
                            } else {
                                
                            }
                        });
                        
                    }catch( e){
                        console.log(e)
                    }
                    
                })   
            });
        </script>
        
        @endsection