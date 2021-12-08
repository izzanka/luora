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
                                @if (auth()->user()->provider_id)
                                    <a href="javascript:void(0)" class="text-dark">Change Password</a>
                                @else
                                    <a href="" data-toggle="modal" data-target="#passwordModal">Change Password</a>
                                @endif
                            </div>
                            <!-- Modal -->
                            <form action="{{ route('settings.password',auth()->id()) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="modal fade" id="passwordModal" aria-labelledby="passwordModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                        <h5 class="modal-title" id="passwordModalLabel">Change password</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-12">
                                                    <label for="">Password</label>
                                                    <input type="password" name="password" class="form-control">
                                                    @include('layouts.error', ['name' => 'password'])
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-light rounded-pill" data-dismiss="modal">Cancel</button>
                                            <button type="submit" class="btn btn-primary rounded-pill">Save</button>
                                        </div>
                                    </div>
                                    </div>
                                </div>
                            </form>
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
                                <a href="javascript:void(0)">{{ auth()->user()->country ? auth()->user()->country : 'Select Country' }}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
     
    </div>
</div>
@endsection
