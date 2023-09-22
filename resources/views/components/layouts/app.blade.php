<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content=".">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ $title ?? 'Luora' }}</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/core@1.0.0-beta17/dist/css/tabler.min.css">
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    </head>
    <body>
        <div class="page">
            <header class="navbar navbar-expand-md navbar-light d-print-none">
              <div class="container-xl">
                <h1 class="navbar-brand text-danger navbar-brand-autodark d-none-navbar-horizontal pe-0 pe-md-3">
                    <a href="{{ route('home') }}">
                        Luora
                    </a>
                </h1>
                <div class="navbar-nav flex-row order-md-last">
                    @guest
                        <div class="nav-item d-none d-md-flex me-3">
                            <div class="btn-list">
                                <a href="{{ route('login') }}" wire:navigate class="btn btn-outline-danger border-danger btn-pill {{ request()->route()->named('login') ? 'active' : '' }}" >
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-login" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <path d="M14 8v-2a2 2 0 0 0 -2 -2h-7a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h7a2 2 0 0 0 2 -2v-2"></path>
                                        <path d="M20 12h-13l3 -3m0 6l-3 -3"></path>
                                    </svg>
                                    Sign in
                                </a>
                                <a href="{{ route('register') }}" wire:navigate class="btn btn-outline-danger border-danger btn-pill {{ request()->route()->named('register') ? 'active' : '' }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-user-plus" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0"></path>
                                        <path d="M16 19h6"></path>
                                        <path d="M19 16v6"></path>
                                        <path d="M6 21v-2a4 4 0 0 1 4 -4h4"></path>
                                    </svg>
                                    Sign up
                                </a>
                            </div>
                        </div>
                    @else
                        <div class="nav-item d-none d-md-flex me-2">
                            <div class="btn-list me-2">
                                <a href="{{ route('home') }}" class="btn btn-outline-danger border-danger btn-pill {{ request()->route()->named('home') ? 'active' : ''}}">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-home" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <path d="M5 12l-2 0l9 -9l9 9l-2 0"></path>
                                        <path d="M5 12v7a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-7"></path>
                                        <path d="M9 21v-6a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v6"></path>
                                     </svg>
                                    Home
                                </a>
                                <a href="" class="btn btn-outline-danger border-danger btn-pill {{ request()->route()->named('appearance.index') ? 'active' : ''}}">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-list" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <path d="M9 6l11 0"></path>
                                        <path d="M9 12l11 0"></path>
                                        <path d="M9 18l11 0"></path>
                                        <path d="M5 6l0 .01"></path>
                                        <path d="M5 12l0 .01"></path>
                                        <path d="M5 18l0 .01"></path>
                                    </svg>
                                    Following
                                </a>
                                <a href="{{ route('answer.index') }}" class="btn btn-outline-danger border-danger btn-pill {{ request()->route()->named('answer.index') ? 'active' : ''}}">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-edit" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1"></path>
                                        <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z"></path>
                                        <path d="M16 5l3 3"></path>
                                     </svg>
                                    Answer
                                </a>
                                <a href="" class="btn btn-outline-danger border-danger btn-pill {{ request()->route()->named('appearance.index') ? 'active' : ''}}">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-users-group" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <path d="M10 13a2 2 0 1 0 4 0a2 2 0 0 0 -4 0"></path>
                                        <path d="M8 21v-1a2 2 0 0 1 2 -2h4a2 2 0 0 1 2 2v1"></path>
                                        <path d="M15 5a2 2 0 1 0 4 0a2 2 0 0 0 -4 0"></path>
                                        <path d="M17 10h2a2 2 0 0 1 2 2v1"></path>
                                        <path d="M5 5a2 2 0 1 0 4 0a2 2 0 0 0 -4 0"></path>
                                        <path d="M3 13v-1a2 2 0 0 1 2 -2h2"></path>
                                     </svg>
                                    Spaces
                                </a>
                                <a href="" class="btn btn-outline-danger border-danger btn-pill {{ request()->route()->named('appearance.index') ? 'active' : ''}}">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-bell" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <path d="M10 5a2 2 0 1 1 4 0a7 7 0 0 1 4 6v3a4 4 0 0 0 2 3h-16a4 4 0 0 0 2 -3v-3a7 7 0 0 1 4 -6"></path>
                                        <path d="M9 17v1a3 3 0 0 0 6 0v-1"></path>
                                     </svg>
                                    Notifications
                                </a>
                            </div>
                        </div>
                        <div class="nav-item dropdown">
                            <a href="#" class="nav-link d-flex lh-1 text-reset p-0" data-bs-toggle="dropdown">
                                <span class="avatar avatar-sm rounded-circle" style="background-image: url(@if(auth()->user()->image == null) 'https://ui-avatars.com/api/?name={{ auth()->user()->username }}&background=DE6060&color=fff&rounded=true&size=112' @else {{ asset(auth()->user()->image) }} @endif)"></span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                <a class="dropdown-item text-dark" href="{{ route('profile.index', auth()->user()->username_slug) }}">
                                    {{ auth()->user()->username }}
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#">
                                    Your content & stats
                                </a>
                                <div class="dropdown-divider"></div>
                                <a href="#" onclick="event.preventDefault(); document.getElementById('signout-form').submit();" class="dropdown-item">
                                    Settings
                                </a>
                                <a href="#" onclick="event.preventDefault(); document.getElementById('signout-form').submit();" class="dropdown-item">
                                    Sign out
                                </a>
                                <form id="signout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </div>
                    @endguest
                </div>
              </div>
            </header>

            <div class="page-wrapper">
                <div class="container">
                    {{ $slot ?? null }}
                </div>
            </div>

            {{-- <footer class="footer footer-transparent d-print-none">
                <div class="container-xl mt-2">
                  <div class="row text-center align-items-center flex-row-reverse">
                    <div class="col-lg-auto ms-lg-auto">
                      <ul class="list-inline list-inline-dots mb-0">
                        <li class="list-inline-item"><a href="https://github.com/izzanka/linkme" target="_blank" class="link-secondary" rel="noopener"><svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-brand-github" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <path d="M9 19c-4.3 1.4 -4.3 -2.5 -6 -3m12 5v-3.5c0 -1 .1 -1.4 -.5 -2c2.8 -.3 5.5 -1.4 5.5 -6a4.6 4.6 0 0 0 -1.3 -3.2a4.2 4.2 0 0 0 -.1 -3.2s-1.1 -.3 -3.5 1.3a12.3 12.3 0 0 0 -6.2 0c-2.4 -1.6 -3.5 -1.3 -3.5 -1.3a4.2 4.2 0 0 0 -.1 3.2a4.6 4.6 0 0 0 -1.3 3.2c0 4.6 2.7 5.7 5.5 6c-.6 .6 -.6 1.2 -.5 2v3.5"></path>
                         </svg> Source code</a></li>
                      </ul>
                    </div>
                    <div class="col-12 col-lg-auto mt-3 mt-lg-0">
                      <ul class="list-inline list-inline-dots mb-0">
                        <li class="list-inline-item">
                          Copyright &copy; 2023
                          <a href=".." class="link-secondary">Luora</a>.
                        </li>
                      </ul>
                    </div>
                  </div>
                </div>
            </footer> --}}
        </div>
        <script src="https://cdn.jsdelivr.net/npm/@tabler/core@1.0.0-beta17/dist/js/tabler.min.js"></script>
        <script type="text/javascript">
            window.addEventListener('swal',function(e){
                Swal.fire({
                    title: e.detail.title,
                    icon: e.detail.icon,
                });
            });

            window.onscroll = function(ev){
                if((window.innerHeight + window.scrollY) >= document.body.offsetHeight){
                    Livewire.dispatch('increase-limit');
                }
            }
        </script>
    </body>
</html>

