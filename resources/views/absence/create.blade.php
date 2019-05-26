@extends('main')

@section('title', 'Nueva ausencia')

@section('content')


<h3 class="title py-3"><span class=" p-2">Nueva ausencia&ensp;&ensp;</span>    </h3>



<br><br>

{{-- Result Message  --}}
<div class="flash-message">
    @foreach (['danger', 'warning', 'success', 'info'] as $msg)
    @if(Session::has('alert-' . $msg))
    
    <p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }} <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></p>
    @endif
    @endforeach
</div>
<br>

<div class="text-dark btn border col-12 bg-whitesmoke"><h5>Agregar</h5>
    
    <form action="/absences/store" method="post">
        @csrf
        <div class="form-group row">
            <select name="user" class="form-control col-md-6 mx-auto" >
                
                @foreach ($users as $user)

                @if((int)$user->id == (int)session()->get('absence.create.user') )
                    
                <option value="{{$user->id}}" selected> {{$user->dni}} : {{$user->name}} {{$user->surname}}</option>   
                @else
                <option value="{{$user->id}}"> {{$user->dni}} : {{$user->name}} {{$user->surname}}</option>    
                @endif
                @endforeach                
            </select>            
        </div>
        <div class="form-group form-sm ">
            <div class="mx-auto ">
            <input class="form-control col-xl-6 col-lg-6 col-md-6 col-sm-12" type="date" name="start_date" id="start_date" value="{{ session()->get('absence.create.sdate')}}">
            <input class="form-control col-xl-6 col-lg-6 col-md-6 col-sm-12" type="date" name="end_date" id="end_date" value="{{ session()->get('absence.create.edate')}}">
            </div>
        
        <div class="mx-auto ">
             <input  class="form-control col-xl-6 col-lg-6 col-md-6 col-sm-12 " type="text" name="note" id="note">
            </div>
        <div class="mx-auto">
                <input class="form-control col-xl-4 col-lg-4 col-md-4 col-sm-12 btn btn-light border-dark" type="submit" value="Agregar">
            </div>
       </div>
        
    </form>
</div>


@endsection
