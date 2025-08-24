@extends('layouts.app')

@section('nav')

<nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
    <div class="container d-flex justify-content-between">
        <div class="mr-auto p-2">
            <a class="navbar-brand" href="{{ url('/') }}">
                {{ config('app.name', 'Laravel') }}
            </a>
        </div>

        <div class="p-2">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>
        
        <div class="p-2">
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                @guest
                    @if (Route::has('login'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                        </li>
                    @endif
                @else
                    @can('user-list')
                        <li><a class="nav-link" href="{{ route('users.index') }}">Użytkownicy</a></li>
                    @endcan
                    @can('role-list')
                        <li><a class="nav-link" href="{{ route('roles.index') }}">Statusy</a></li>
                    @endcan
                    @can('permission-list')
                        <li><a class="nav-link" href="{{ route('permissions.index') }}">Uprawnienia</a></li>
                    @endcan
                    @can('event-list')
                        <li><a class="nav-link" href="{{ route('events.index') }}">Imprezy</a></li>
                    @endcan      
                    


                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->name }}
                        </a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
    </div>
</nav>

@endsection