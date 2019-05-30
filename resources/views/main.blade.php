<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    {{-- jquery --}}
    <script src="/js/jquery-3.4.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    
    {{-- bootstrap --}}
    <script src="/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="/css/bootstrap.min.css">
    
    {{-- datatables --}}    
    <link rel="stylesheet" type="text/css" href="/DataTables/css/jquery.dataTables.min.css">
    <script type="text/javascript" charset="utf8" src="/DataTables/js/jquery.dataTables.min.js"></script>
    
    {{-- styles --}}
    <link rel="stylesheet" href="/css/main.css">
    
    
    {{-- sweet alert --}}
    <script src="/js/sweetalert.min.js"></script>
    
    <title>@yield('title')</title>
    {{-- <script src="/js/calendar.js"></script> --}}
</head>
<body @yield('onload')>
    
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light navbar-laravel">
            <div class="container">
                @if(auth()->check())
                <div>
                    <a class="navbar-brand" href="{{ url('/') }}">
                        <img src="/images/logo.png" alt="Logo">
                    </a>
                </div>
                <div class="col-auto text-center">
                    <h3 class="d-none d-md-block"  >Ministerio de Defensa</h3>  
                    <h4 class="d-none d-md-block" >Sistema de gestion de tareas</h4>  
                </div>
                {{-- <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button> --}}
                <div class="col-xl-2 col-lg-2 col-md-3 ">
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">
                        
                    </ul>
                    
                    
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
                    @else
                    <div class="mx-auto">
                            <div class="justify-content-center">
                                <h1>Sistema de Gestion de tareas</h1>
                            </div>
                            </div>
                    @endif   
                </ul>
            </div>

</div>
        </div>
    </nav>    
</div>

<div class="container">
    
    <div class="row inner col-xl-12 col-lg-12 col-md-12  mt-5">
        @auth
        <div class="side col-xl-3 col-lg-3 col-md-3 col-sm-12  col-xs-12">
            <aside class="col-12">
                
                @if (!auth()->guest() )      
                <a href="/home" >
                    <button class="bh3 col-xl-12 col-lg-12 col-md-12 btn-top text-left menu_item
                    <?php  if(request()->path() == 'home' || request()->path() == '/')echo 'active-side';?>">
                        <img src="/svg/person.svg" alt="Usuario" >&ensp;
                        Usuario
                    </button>
                </a>
                 
                @if(auth()->user()->employee->role->id === 2) 
                <a href="/tasks" >
                    <button class="bh3 col-xl-12 col-lg-12 col-md-12 btn-top text-left menu_item
                    <?php  if(request()->path() == 'assigntask' || request()->path() == 'tasks')echo 'active-side';?>">
                        <img src="/svg/file-directory.svg" alt="Tareas" >&ensp;
                        Todas las tareas
                    </button>
                </a>
                @endif
                @endif
                
                @if (!auth()->guest())                   
                
                @if(auth()->user()->employee->role->id === 1) 
                
                <a href="/assigntask" >
                    <button class="bh3 col-xl-12 col-lg-12 col-md-12 btn-top text-left menu_item
                          <?php  if(request()->path() == 'assigntask')echo 'active-side';?>">
                        <img src="/svg/desktop-download.svg" alt="Tareas" >&ensp;
                        Asignación de tareas
                    </button>
                </a>
                
                <a href="/settings/taskposition" >
                    <button class="bh3 col-xl-12 col-lg-12 col-md-12  text-left menu_item
                        <?php if( substr(request()->path(),0,8) == 'settings') echo 'active-side';?>">
                        <img src="/svg/settings.svg" alt="Configuración" >&ensp;
                        Configuración
                    </button>
                </a>
                <button class="bh3 col-xl-12 col-lg-12 col-md-12 text-left menu_item 
                    <?php  if(request()->path() == 'archive')echo 'active-side';?>">
                    <img src="/svg/file-directory.svg" alt="Archivo" >&ensp;
                    Archivar
                </button>
                <a href="/employee" >
                    <button  class="bh3 col-xl-12 col-lg-12 col-md-12  text-left menu_item
                        <?php if( substr(request()->path(),0,8) == 'employee') echo 'active-side';?>">
                        <img src="/svg/person.svg" alt="Empleados" >&ensp;
                        Personal
                    </button>
                </a>
                <a href="/absences" >
                    <button  class="bh3 col-xl-12 col-lg-12 col-md-12  text-left menu_item
                        <?php if( substr(request()->path(),0,8) == 'absences') echo 'active-side';?>">
                        <img src="/svg/eye.svg" alt="Ausencias" >&ensp;
                        Ausencias
                    </button>
                </a>
                @endif
                @endif
            </aside>
        </div>
        @endauth
        @if(auth()->check())
        <div class="main col-xl-9 col-lg-9 col-md-9 col-sm-12  col-xs-12">
            @else
            <div class="main col-xl-12 col-lg-12 col-md-12 col-sm-12  col-xs-12">
                @endif
                @yield('content')
            </div>
        </div> 
    </div>
    
    <script type="text/javascript" src="/js/jquery_functions.js"></script>
    
</body>
</html>