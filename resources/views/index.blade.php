@extends('main')

@section('title','Tareas Usuario')
@show
@section('content')
 
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
    
    <div class="col-md-8">
        <div class="card">
            
            @if( !is_null($tasks) )
                <div class="card-header text-dark text-center">
                    <h4>{{ $tasks[0]['position']}}  {{ $tasks[0]['employee'] }}</h4>
                </div>
            @else
                <div class="card-header text-dark text-center">´
                    <h4>{{ $tasks['position']}}  {{ $tasks['employee'] }}</h4>
                </div>
            @endif
            
            <div class="card-body">
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif
                
                @if(count($tasks[0])>2)

                 <table class="table table-sm table-border table-hover">

                    <thead class="table-info">
                        <tr><th>Servicio</th><th>Fecha</th></tr>
                    </thead>

                    <tbody>
                        
                        @foreach ($tasks as $task)
                        <tr>
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
