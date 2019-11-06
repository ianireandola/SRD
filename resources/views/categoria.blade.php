@extends('layouts.app')

@section('content')
<div class="w-screen mt-4">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">
                    <a href="{{ route('admin.dashboard') }}">
                        <i class="fa fa-home" aria-hidden="true"></i>
                    </a>
                    <b>       Administrador</b>
                </div>
                <div class="card-body">
                    <categoria-component/>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection