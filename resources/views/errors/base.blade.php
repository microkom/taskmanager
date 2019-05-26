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
    <div class="container text-center">


    <a class="navbar-brand" href="{{ url('/') }}">
        <img src="/images/logo.png" alt="Logo">
    </a><h3 class="text-dark">Ministerio de Defensa</h3>  
    
    </div>
    @yield('content')
</body>