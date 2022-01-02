<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Luora is a Quora website clone. It's a platform to ask questions and connect with people who contribute quality answers">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title','Luora')</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="{{ asset('js/share.js') }}"></script>
    
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    @yield('link')
    <style>
        .dmenu a {
            width: 250px;
        }
    </style>
</head>

<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm sticky-top">
            <div class="container">
                <a class="navbar-brand mr-5" href="{{ route('home') }}">
                    <b class="text-danger">Luora</b>
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto" >
                        @guest
                            
                        @else
                            <li class="nav-item ml-4">
                                <a href="{{ route('home') }}" class="{{ request()->route()->named('home') ? 'text-danger' : 'text-dark'}} "><i class="bi bi-house-door" style="font-size: 1.5rem;"></i></a>
                            </li>

                            @can('isAdmin')
                                <x-admin-answers/>
                                <x-admin-questions/>
                                <x-admin-comments/>
                                <x-admin-topics/>
                            @else
                                <li class="nav-item ml-5">       
                                        <a href="javascript: void(0)" class="text-dark"><i class="bi bi-newspaper" style="font-size: 1.5rem;"></i></a>
                                </li>

                                <li class="nav-item ml-5">       
                                        <a href="{{ route('answer.index') }}" class="{{ request()->route()->named('answer.index') || request()->route()->named('question.show')  ? 'text-danger' : 'text-dark'}}"><i class="bi bi-pencil-square" style="font-size: 1.5rem;"></i></a>
                                </li>
                
                                <li class="nav-item ml-5">       
                                    <a href="javascript: void(0)" class="text-dark"><i class="bi bi-people" style="font-size: 1.5rem;"></i></a>
                                </li>

                                <li class="nav-item ml-5">
                                        <a href="javascript: void(0)" class="text-dark"><i class="bi bi-bell" style="font-size: 1.5rem;"></i></a>
                                </li>

                                <li class="nav-item ml-4 mt-1">
                                    <select name="livesearch" class="form-control livesearch" style="width: 375px">
        
                                    </select>
                                </li>
                        @endcan
                        
                        @endguest

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link" href="javascript: void(0)" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    <img src="{{ Auth::user()->avatar }}" alt="avatar" class="rounded-circle" width="25px" height="25px">
                                </a>

                                <div class="dropdown-menu dropdown-menu-right dmenu" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('profile.index',Auth::user()->name_slug) }}" class="text-dark"><b style="font-size: 15px">{{ Auth::user()->name }} <i class="bi bi-chevron-right ml-2"></i></b> </a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="{{ route('stats.index') }}"><i class="bi bi-bar-chart mr-2"></i>Stats</a>
                                    <a class="dropdown-item" href="{{ route('content.index') }}"><i class="bi bi-journals mr-2"></i>Your Content</a>
                                    <a class="dropdown-item" href="javascript: void(0)"><i class="bi bi-bookmark mr-2"></i>Bookmarks</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="{{ route('settings.index') }}">Settings</a>
                                    <a class="dropdown-item" href="javascript: void(0)">Help</a>
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>
                                    <div class="dropdown-divider"></div>
                                    <small class="dropdown-header"><a href="https://github.com/izzanka/luora" class="text-secondary">About &#183;</a></small>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>

                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link" href="javascript: void(0)" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    <img src="{{ asset('img/globe2.svg') }}" alt="" class="rounded-circle" width="25px" height="25px">
                                </a>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item">
                                        English
                                    </a>
                                    <a class="dropdown-item">
                                        Indonesia
                                    </a>
                                </div>
                            </li>
                            <button class="btn btn-sm btn-danger ml-2 rounded-pill" data-toggle="modal" data-target="#add-questionModal">Add question</button>
                        
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @guest
            @else
            <x-question/>
            @endguest
            
            @yield('content')
        </main>
    </div>

    <script>
        let $q = $('.livesearch');

        $q.select2({
            placeholder: 'Search user',
            ajax: {
                url: "/search",
                dataType: 'json',
                delay: 250,
                processResults: function (data) {
                    return {
                        results: $.map(data, function (item) {
                            return {
                                id: item.id,
                                text: item.name,
                                name_slug: item.name_slug,
                            }
                        })
                    };
                },
                cache: true
            }
        });

        $q.on('select2:select', function (e) {
            window.location.href = "/profile/" + e.params.data.name_slug + "/show";
        })

        $('#formTopic').hide();
        $("#btnTopic").click(function(){
            $('#formTopic').toggle();
        })

    </script>
    
    @yield('script')

</body>
</html>
