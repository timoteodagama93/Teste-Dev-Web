@extends('layouts.app')

@section('content')
<div class="container">

    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">Nova enquete</div>

                <div class="card-body">

                    <create-component></creat-component>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Enquetes</div>

                <div class="card-body">
                    <criar></criar>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection