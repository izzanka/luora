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
                <div class="row">
                    <div class="col-12 text-danger">
                        Account
                    </div>
                </div>
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
                <div class="row">
                    <div class="col-12">
                        <div class="row">
                            <div class="col-6">
                                Email
                            </div>
                            <div class="col-6">
                                {{ auth()->user()->email }}
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-12">
                        <div class="row">
                            <div class="col-6">
                                Password
                            </div>
                            <div class="col-6">
                                <a href="#">Change Password</a>
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-12">
                        <div class="row">
                            <div class="col-6">
                                Country
                            </div>
                            <div class="col-6">
                                <a href="#">{{ auth()->user()->country ? auth()->user()->country : 'Select Country' }}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
     
    </div>
</div>
@endsection
