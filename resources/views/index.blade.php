@extends('main')

@section('content')
@unless (Auth::check())
You are not signed in.
@endunless
<div class="container">
    <div id="app">
        
    
    
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
                
                @if(count($tasks[0])>2)
                
                {{--  <div class="alert alert-primary text-center" role="alert">
                    <h4 class="">{{ $today_tasks[0]['date']}}</h4>
                </div> --}}
                
                <table class="table table-sm table-border table-hover">
                    <thead class="table-info">
                        <tr>{{-- <th>Empleo</th><th>Nombre</th> --}}<th>Servicio</th><th>Fecha</th></tr>
                    </thead>
                    <tbody>
                        
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
