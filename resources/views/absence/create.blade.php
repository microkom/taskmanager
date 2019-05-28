@extends('main')

@section('title', 'Nueva ausencia')

@section('content')

<div class="title py-3">
<h4 >Nueva ausencia</h4>
</div>
{{-- Result Message  --}}
@include('result_message')
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
        <div class="form-row form-group form-sm ">
            <div class="d-inline-block mx-auto col-xl-4 col-lg-4 col-md-4 col-sm-12 col-xs-12 ">
                <label for="start_date">Fecha inicio</label>
                <input class="form-control text-center" type="date" name="start_date" id="start_date" value="{{ session()->get('absence.create.sdate')}}">
            </div>
            <div class="d-inline-block mx-auto col-xl-4 col-lg-4 col-md-4 col-sm-12 col-xs-12  ">    
                <label for="start_date">Fecha fin</label>
                <input class="form-control col-auto text-center" type="date" name="end_date" id="end_date" value="{{ session()->get('absence.create.edate')}}">
            </div>
        </div>   
        <div class="form-row form-group form-sm ">
            <div class="mx-auto col-xl-10 col-lg-10 col-md-10 col-sm-12 col-xs-12 ">
                <label for="note">Notas</label>
                <input list="note" name="note" class="form-control col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                
                <datalist id="note">
                    @foreach ($notes as $note)
                        @if($note != null)
                        <option value="{{ $note }}">
                        @endif
                    @endforeach
                        
            </div> 
        </div>
        <div class="mx-auto">
            <input class="form-control col-3 btn btn-light border-dark" type="submit" value="Agregar">
        </div>
                    
                    
                </form>
            </div>
            
            
            @endsection
            