@extends('layouts.app')

@section('content')
<div class="w-screen mt-4">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header inline-block">
                    <a align="right" href="{{ route('historial') }}">
                        <i class="fa fa-history" aria-hidden="true"></i>
                    </a>
                    
                    Chapa : <b>{{auth()->user()->chapa}}</b> - Nombre: <b>{{auth()->user()->nombre}}</b>
                </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    @foreach($seccion as $item)
                        @if( $item->nivel2 === 1 )
                            <registrar-horas2-component v-bind:current-user = '{{ auth()->user()->id }}' :seccion-id = '{{$item->id}}'/>
                        @else
                            <registrar-horas-component v-bind:current-user = '{{ auth()->user()->id }}' :seccion-id = '{{ $item->id }}'/>
                        @endif
                    @endforeach
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
