@extends('main')

@section('content')
@unless (Auth::check())
    You are not signed in.
@endunless
<div class="container">
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light navbar-laravel">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    <img src="/images/logo.png" alt="Logo">
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>
                
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">
                        
                    </ul>
                    <h4 class="text-dark">Ministerio de Defensa</h4>   
                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                        </li>
                        @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                        </li>
                        @endif
                        @else
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->name }} <span class="caret"></span>
                            </a>
                            
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>
                            
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>
    
    
</div>
    <div class="row justify-content-center">
        
        {{-- Result Message  --}}
        <div class="flash-message">
            @foreach (['danger', 'warning', 'success', 'info'] as $msg)
            @if(Session::has('alert-' . $msg))
            
            <p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }} <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></p>
            @endif
            @endforeach
        </div>
        <?php //dump(Auth::user()); exit();?>
        
        <div class="col-md-8">
            <div class="card">
                
                @if( !is_null($tasks))
                    <div class="card-header text-dark text-center">
                        <h4>{{ $tasks[0]['position']}}  {{ $tasks[0]['employee'] }}</h4>
                    </div>
                @else
                 <?php //dump(($tasks)>2);?>
                <div class="card-header text-dark text-center"><h4>{{ $tasks['position']}}  {{ $tasks['employee'] }}</h4></div>
                 @endif
                
                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif
                    
               <?php// dump(count($tasks[0])); exit();?>    
                @if(count($tasks[0])>2)
                    
                    {{--  <div class="alert alert-primary text-center" role="alert">
                        <h4 class="">{{ $today_tasks[0]['date']}}</h4>
                    </div> --}}
                    
                    <table class="table table-sm table-border table-hover">
                        <thead class="table-info">
                            <tr>{{-- <td>Empleo</td><td>Nombre</td> --}}<td>Servicio</td><td>Fecha</td></tr>
                        </thead><tbody>
                            
                            @foreach ($tasks as $task)
                            <tr>
                                {{-- <td>{{$task['position']}}</td>
                                <td>{{$task['employee']}}</td> --}}
                                <td>{{$task['task']}}</td>
                                <td>{{ date('d M Y', strtotime($task['date'])) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>     
                 @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endsection
    