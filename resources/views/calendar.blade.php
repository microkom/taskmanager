@extends('layout')


@section('title', 'Calendario de Tareas')
@section('onload')
    onload="fillCalendar()"
@endsection

@section('content')


	<div id="menu">Menu</div>
	<div id="calendar">
    <header>
        <h1 id="year"></h1>
        <h2 id="month"></h2>
        <button id="prev" onclick="prev();">&lt;&lt;&lt;</button>
        <button id="next" onclick="next();">&gt;&gt;&gt;</button>
    </header>

    <!-- <nav id="days">
        <div class="dayname">Lunes</div>
        <div class="dayname">Tuesday</div>
        <div class="dayname">Wednesday</div>
        <div class="dayname">Thursday</div>
        <div class="dayname">Friday</div>
        <div class="dayname">Saturday</div>
		<div class="dayname red">Sunday</div>
        
    </nav> -->

    <nav id="abr">
        <div class="dayname">Lun</div>
        <div class="dayname">Mar</div>
        <div class="dayname">Mie</div>
        <div class="dayname">Jue</div>
        <div class="dayname">Vie</div>
        <div class="dayname">Sab</div>
		<div class="dayname red">Dom</div>
        
    </nav>

    <main></main>
<div>

@endsection