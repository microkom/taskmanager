@extends('main')

@section('title','Tareas Usuario')
@show
@section('content')

<div class="container">
        <div class="title py-2">
            <h4>Tareas de: 

                @if( !is_null($tasks) )
                 
                    {{ $tasks[0]['position']}}  {{ $tasks[0]['employee'] }}
                 
                @else
                 
                    {{ $tasks['position']}}  {{ $tasks['employee'] }}
                 
                @endif

            </h4>
            
        </div>
    
    <div class="row justify-content-center">
        {{-- Result Message  --}}
        @include('result_message')
        
        <div class="col-md-10 py-3">     
               
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif
                    
                    @if(count($tasks[0])>2)
                    
                    <table class="table table-sm table-border table-hover">
                        
                        <thead class="table-light">
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
@endsection
