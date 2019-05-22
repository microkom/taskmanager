@extends('settings')


@section('setting_content')

<h4>Configuración de los empleos (categorías)</h4>
<br>
<p>Empleos existentes.</p>

<div class="mx-auto col-xl-6 col-xl-6 col-lg-6 col-md-12 col-sm-12">
    <table class="table table-sm table-hover ">
        <thead class="thead-dark ">
            <tr><th scope="col">Empleo</th></tr>
        </thead><tbody>
            
            @foreach ($position as $pos)
            <tr scope="row">
                <td>{{ $pos->name }}</td>
                
            </tr>
            @endforeach
        </tbody>
    </table>    
    
    
</div>
@endsection