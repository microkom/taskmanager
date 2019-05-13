<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

    <link href="/css/style.css" rel="stylesheet">
    <link href="/css/index.css" rel="stylesheet">
    <!-- <link href="css/calendar.css" rel="stylesheet"> -->

    <title>@yield('title')</title>
    <script src="/js/calendar.js"></script>
</head>
<body @yield('onload')>
    
    
<div class="text-center" style="margin-bottom:0">
  <h1>Company Name</h1>
  <p>Tareas</p> 
</div>

{{-- <nav class="navbar navbar-expand-sm bg-dark navbar-dark">
  <a class="navbar-brand" href="#">Navbar</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="collapsibleNavbar">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" href="#">Link</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">Link</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">Link</a>
      </li>    
    </ul>
  </div>  
</nav> --}}

<div class="container" style="margin-top:30px">
  <div class="row">
    <div class="col-sm-4">
      <h2>Menu</h2>

      <ul class="nav nav-pills flex-column">
        <li class="nav-item">
          <a class="nav-link {{-- active --}}" href="#">Gestion Empleados</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/calendar">Calendario</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/assigntask">Asignar Tarea</a>
        </li>
        <li class="nav-item">
          <a class="nav-link " href="#">Configuración</a>
        </li>
      </ul>
      <hr class="d-sm">
    </div>
    <div class="col-sm-8">
      
        @yield('content')
   </div>
  </div>
</div>

<div class="card-footer footer text-muted text-center" style="margin-bottom:0;height:3em;">
  <p>Diseñado por German Navarro &reg;</p>
</div>
    

</body>
</html>