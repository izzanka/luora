<div>
    <div class="mt-4">
        <div class="row">
            <div class="col-6">
                <div class="row">
                    <div class="col-3">
                        <span class="avatar avatar-xl rounded-circle" style="background-image: url(@if(auth()->user()->image == null) 'https://ui-avatars.com/api/?name={{ auth()->user()->username }}&background=DE6060&color=fff&rounded=true&size=112' @else {{ asset(auth()->user()->image) }} @endif)"></span>
                    </div>
                    <div class="col-9">
                        <div class="row">
                            <div class="col-12">
                                <b style="font-size: 27px">
                                    {{ auth()->user()->username }}
                                </b>
                            </div>
                        </div>
                        <h3 class="mt-1 text-primary">
                            @if (auth()->user()->credential == null)
                                <a href="">Add profile credential</a>
                            @else
                                {{ auth()->user()->credential }}
                            @endif
                        </h3>
                        <h4 class="text-secondary">
                            0 Followers &#8226; 0 Following
                        </h4>
                    </div>
                </div>
                <div class="mt-3 ms-1">
                    @if (auth()->user()->description == null)
                        <a href="">Write a description about yourself</a>
                    @else
                        {{ auth()->user()->description }}
                    @endif
                </div>
                <div class="mt-4">
                    <div class="row text-center">
                        <div class="col-3">
                            <a href="" class="text-secondary">{{ auth()->user()->answers()->count() }} Answers</a>
                        </div>
                        <div class="col-3">
                            <a href="" class="text-secondary">{{ auth()->user()->questions()->count() }} Questions</a>
                        </div>
                        <div class="col-3">
                            <a href="" class="text-secondary">0 Followers</a>
                        </div>
                        <div class="col-3">
                            <a href="" class="text-secondary">0 Following</a>
                        </div>
                    </div>
                </div>
                <hr class="mt-3">
            </div>
            <div class="col-2">

            </div>
            <div class="col-4">
                <div>
                    Credentials & Highlights
                    <span class="float-end">
                        <svg role="button" xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-edit" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1"></path>
                            <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z"></path>
                            <path d="M16 5l3 3"></path>
                        </svg>
                    </span>
                    <hr class="mt-3 mb-3">
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" class="me-1 icon icon-tabler icon-tabler-briefcase" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <path d="M3 7m0 2a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v9a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2z"></path>
                            <path d="M8 7v-2a2 2 0 0 1 2 -2h4a2 2 0 0 1 2 2v2"></path>
                            <path d="M12 12l0 .01"></path>
                            <path d="M3 13a20 20 0 0 0 18 0"></path>
                        </svg>
                        @if (!auth()->user()->employment()->exists())
                            <a href="">Add employment credential</a>
                        @endif
                    </div>
                    <div class="mt-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="me-1 icon icon-tabler icon-tabler-school" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <path d="M22 9l-10 -4l-10 4l10 4l10 -4v6"></path>
                            <path d="M6 10.6v5.4a6 3 0 0 0 12 0v-5.4"></path>
                        </svg>
                        @if (!auth()->user()->education()->exists())
                            <a href="">Add education credential</a>
                        @endif
                    </div>
                    <div class="mt-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="me-1 icon icon-tabler icon-tabler-map-pin" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <path d="M9 11a3 3 0 1 0 6 0a3 3 0 0 0 -6 0"></path>
                            <path d="M17.657 16.657l-4.243 4.243a2 2 0 0 1 -2.827 0l-4.244 -4.243a8 8 0 1 1 11.314 0z"></path>
                        </svg>
                        @if (!auth()->user()->location()->exists())
                            <a href="">Add location credential</a>
                        @endif
                    </div>
                    <div class="mt-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="me-1 icon icon-tabler icon-tabler-calendar" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <path d="M4 7a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12z"></path>
                            <path d="M16 3v4"></path>
                            <path d="M8 3v4"></path>
                            <path d="M4 11h16"></path>
                            <path d="M11 15h1"></path>
                            <path d="M12 15v3"></path>
                        </svg>
                        Joined {{ auth()->user()->created_at->format('d M Y') }}
                    </div>
                </div>
                <div class="mt-4">
                    Knows about
                    <span class="float-end">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-edit" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1"></path>
                            <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z"></path>
                            <path d="M16 5l3 3"></path>
                        </svg>
                    </span>
                    <hr class="mt-3 mb-3">
                </div>
            </div>
        </div>
    </div>
</div>
