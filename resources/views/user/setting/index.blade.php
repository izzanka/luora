@extends('layouts.app')

@section('title')
Account Settings
@endsection

@section('content')

<div class="container">
    <div class="row">
        <div class="col-2">
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        Settings
                    </div>
                </div>
                <hr>
            </div>
     
        </div>
        <div class="col-7 ml-1">
            @include('layouts.success')
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        Account Settings
                    </div>
                </div>
                <hr>
            </div>
        </div>
     
    </div>
</div>
@endsection
