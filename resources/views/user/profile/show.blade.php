@extends('layouts.app')

@section('title')
{{ $user->name }} - Socialite
@endsection

@section('content')

<div class="container">
    <div class="row">
        <div class="col-8">
            @include('layouts.success')
      
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-sm-2">
                            <img src="{{ $user->avatar }}" alt="avatar" class="rounded-circle mr-2" width="100px" height="100px">
                        </div>
                        <div class="col-sm-9">
                            <b style="font-size: 25px" id="name">{{ $user->name }} </b><br>
                            <span class="text-secondary">{{ $user->credential ?? '' }}</span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            {{ $user->description ?? '' }}
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-12">
                            <div class="row">
                                <div class="col-12">
                                    <div class="btn-group mr-2" role="group">
                                        <a href="{{ route('follow',$user->name_slug) }}" class="btn btn-primary btn-sm">
                                            
                                            @if (auth()->user()->isFollowing($user))
                                                <i class="bi bi-person-check-fill mr-1"></i> 
                                                {{ 'Following ' . $user->followers()->count() ?? 0 }}
                                            @else
                                                <i class="bi bi-person-plus mr-1"></i>
                                                {{ 'Follow ' . $user->followers()->count() ?? 0 }}
                                            @endif
                                            
                                        </a>
                                    </div>
                                    <div class="btn-group mr-2" role="group">
                                        <a href="#" class="btn btn-secondary btn-sm"><i class="bi bi-bell mr-1"></i> Notify me</a>
                                    </div>
                                    <div class="btn-group mr-2" role="group">
                                        <a href="#" class="btn btn-secondary btn-sm"><i class="bi bi-question-circle mr-1"></i> Ask Question</a>
                                    </div>
                                    <a class="text-dark float-right dropdown-toogle" id="navbarDropdown" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre><i class="bi bi-three-dots" style="font-size: 20px"> </i></a>
                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                            <a class="dropdown-item">
                                                Mute {{ $user->name }}
                                            </a>
                                            <a class="dropdown-item">
                                                Block
                                            </a>
                                            <a class="dropdown-item">
                                                Report
                                            </a> 
                                    </div>
                                </div>
                            </div>          
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-2">
                            {{ $user->answers->count() ?? 0}} Answers
                        </div>
                        <div class="col-sm-2">
                            {{ $user->questions->count() ?? 0}} Questions
                        </div>
                        <div class="col-sm-2">
                            0 Shares
                        </div>
                        <div class="col-sm-2">
                            {{ $user->followers()->count() ?? 0 }} Followers
                        </div>
                        <div class="col-sm-2">
                            {{ $user->followings()->count() ?? 0 }} Followings
                        </div>
                        <div class="col-sm-2">
                            0 Activity
                        </div>
                    </div>
                    <hr>
                </div>
        </div>
        <div class="col-4">
            <div class="mb-2">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            Credentials & Highlights
                        </div>
                    </div>
                    <hr>
                    @if ($employment_credential ?? '')
                    <div class="row">
                        <div class="col-12">
                            <i class="bi bi-briefcase mr-2" style="font-size: 15px"></i>
                            <span class="text-dark"> {{ $employment_credential['credential'] }} <small class="text-secondary">{{  $employment_credential['year']}}</small></span>
                        </div>
                    </div>
                    @endif

                    @if ($user->education ?? '')
                    <div class="row mt-2">
                        <div class="col-12">
                            <i class="bi bi-book mr-2" style="font-size: 15px"></i>
                            <span class="text-dark"> {{ $education_credential['credential'] }} <small class="text-secondary">{{  $education_credential['year']}}</small></span>
                        </div>
                    </div>
                    @endif

                    @if ($user->location ?? '')
                    <div class="row mt-2">
                        <div class="col-12">
                            <i class="bi bi-geo-alt mr-2" style="font-size: 15px"></i>                  
                            <span class="text-dark"> {{ $location_credential['credential'] }} <small class="text-secondary">{{  $location_credential['year']}}</small></span>
                        </div>
                    </div>  
                    @endif

                    <div class="row mt-2">
                        <div class="col-12">
                            <i class="bi bi-calendar mr-2" style="font-size: 15px"></i> Joined {{ $user->created_at->format('M Y') }}
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        Knows about                   
                    </div>
                </div>
                <hr>
                <div class="container">
                    <div class="row">
                        @forelse ($user->topics as $topic)
                            <div class="col-sm-6">
                                <li><b><a href="#" class="text-dark">{{ $topic->name }}</a></b></li>
                            </div>
                        @empty
                        <div class="row">
                            <div class="col-sm-12">
                            
                            </div>
                        </div>
                        @endforelse
                    </div>
                </div>
                    
            </div>
           
        </div>
    </div>
</div>
@endsection
