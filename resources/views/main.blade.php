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
    
    <title>@yield('title')</title>
    {{-- <script src="/js/calendar.js"></script> --}}
</head>
<body @yield('onload')>
    <div class="container">
        <div class="header col-12 border d-lg-block">
            <a href="/">
                <div class="d-inline-block">
                    <img src="/images/logo.png" alt="Logo">
                </div>
                <div class="d-inline-block  ">
                    <p class="text-dark">Ministerio de Defensa</p>   
                </div>
            </a> 
        </div>
        
        <div class="row inner col-xl-12 col-lg-12 col-md-12  mt-5">
            <div class="side col-xl-3 col-lg-3 col-md-3 col-sm-12  col-xs-12">
                <aside class="col-12">
                    <a href="/assigntask" >
                        <button id='assigntask' class="bh3 col-xl-12 col-lg-12 col-md-12 btn-top text-left menu_item">
                            <img src="/svg/list-unordered.svg" alt="Tasks" >&ensp;
                            Asignación de tareas
                        </button>
                    </a>
                            
                    <button class="bh3 col-xl-12 col-lg-12 col-md-12  text-left menu_item">
                        <img src="/svg/settings.svg" alt="Configuración" >&ensp;
                        Configuración
                    </button>
                    <button class="bh3 col-xl-12 col-lg-12 col-md-12 text-left menu_item">
                        <img src="/svg/file-directory.svg" alt="Tasks" >&ensp;
                        Archivar
                    </button>
                    <a href="/employee" >
                        <button id='employee' class="bh3 col-xl-12 col-lg-12 col-md-12 btn-top text-left menu_item">
                            <img src="/svg/person.svg" alt="Empleados" >&ensp;
                            Personal
                        </button>
                    </a>
                   
                               
                            
                           {{--  <div id="employee2" class="collapse show" aria-labelledby="employee" data-parent="#accordion">
                                <div class="card-body">
                                    
                                    <img src="/svg/pencil.svg" alt="Editar" >
                                    <a class=" col-xl-12 col-lg-12 col-md-12 text-left " href="/employee/edit">Editar </a><br>
                                     
                                    <img src="/svg/plus.svg" alt="Agregar" >
                                    <a class=" col-xl-12 col-lg-12 col-md-12 text-left " href="/employee/add">Agregar </a><br>
                                    
                                    <img src="/svg/chevron-up.svg" alt="Ascender" >
                                    <a class=" col-xl-12 col-lg-12 col-md-12 text-left " href="employee/promote">Ascender</a><br>
                                    
                                    <img src="/svg/x.svg" alt="Desactivar" >
                                    <a class=" col-xl-12 col-lg-12 col-md-12 text-left " href="employee/deactivate">Desactivar</a><br>
                                    
                                    
                                    <img src="/svg/dash.svg" alt="Excluir" >
                                    <a class=" col-xl-12 col-lg-12 col-md-12 text-left " href="employee/exclude">Excluir</a>
                                     
                                </div>
                            </div>
                        </div>
                     
                       
                    </div> --}}
                </aside>
            </div>
            <div class="main col-xl-9 col-lg-9 col-md-9 col-sm-12  col-xs-12">
                @yield('content')
            </div>
        </div>
    </div>
    <script type="text/javascript" src="/js/jquery_functions.js"></script>
   
</body>
</html>/