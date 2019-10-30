@extends('layouts.app')

@section('content')
<div class="w-screen mt-4">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header inline-block">
                    <a href="{{ route('registroHoras') }}">
                        <i class="fa fa-home" aria-hidden="true"></i>
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
                            <historial2-component/>
                        @else
                            <historial-component/>
                        @endif
                    @endforeach

                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection