@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <a href="{{ route('admin.dashboard') }}">
                        <i class="fa fa-home" aria-hidden="true"></i>
                    </a>
                    <b>       Administrador</b>
                </div>

                <div class="card-body">
                    <dedicacion-component/>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection