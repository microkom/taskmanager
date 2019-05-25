<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    {{-- jquery --}}
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    
    {{-- bootstrap --}}
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    
    {{-- datatables --}}
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>
    
    {{-- styles --}}
    <link rel="stylesheet" href="/css/main.css">
    
    
    {{-- sweet alert --}}
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    
    <title>@yield('title')</title>
    {{-- <script src="/js/calendar.js"></script> --}}
</head>
<body @yield('onload')>
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
<div class="container">
 {{--    <div class="header col-12 text-center d-lg-block">
        <a href="/">
            <div class="d-inline-block float-left">
                <img src="/images/logo.png" alt="Logo">
            </div>
            <div class="d-inline-block  ">
                <p class="text-dark">Ministerio de Defensa</p>   
            </div>
        </a> 
    </div>
     --}}
    <div class="row inner col-xl-12 col-lg-12 col-md-12  mt-5">
        <div class="side col-xl-3 col-lg-3 col-md-3 col-sm-12  col-xs-12">
            <aside class="col-12">
                <a href="/assigntask" >
                    <button class="bh3 col-xl-12 col-lg-12 col-md-12 btn-top text-left menu_item">
                        <img src="/svg/desktop-download.svg" alt="Tasks" >&ensp;
                        Asignación de tareas
                    </button>
                </a>
                <a href="/settings" >
                    <button class="bh3 col-xl-12 col-lg-12 col-md-12  text-left menu_item">
                        <img src="/svg/settings.svg" alt="Configuración" >&ensp;
                        Configuración
                    </button>
                </a>
                <button class="bh3 col-xl-12 col-lg-12 col-md-12 text-left menu_item">
                    <img src="/svg/file-directory.svg" alt="Tasks" >&ensp;
                    Archivar
                </button>
                <a href="/employee" >
                    <button  class="bh3 col-xl-12 col-lg-12 col-md-12  text-left menu_item">
                        <img src="/svg/person.svg" alt="Empleados" >&ensp;
                        Personal
                    </button>
                </a>
                <a href="/absences" >
                    <button  class="bh3 col-xl-12 col-lg-12 col-md-12  text-left menu_item">
                        <img src="/svg/eye.svg" alt="Ausencias" >&ensp;
                        Ausencias
                    </button>
                </a>
                
            </aside>
        </div>
        <div class="main col-xl-9 col-lg-9 col-md-9 col-sm-12  col-xs-12">
            @yield('content')
        </div>
    </div> 
</div>

<script type="text/javascript" src="/js/jquery_functions.js"></script>

</body>
</html>