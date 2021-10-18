@extends('layouts.app')

@section('content')
<div class="container">

    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card">
                <div class="card-header">Nova enquete</div>

                <div class="card-body">

                    <criar-enquete></criar-enquete>
                </div>
            </div>
        </div>
        <div class="col-md-7">
            <div class="card">
                <div class="card-header">Enquetes</div>

                <div class="card-body">
                <user-enquetes></user-enquetes>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection