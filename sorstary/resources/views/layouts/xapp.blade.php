<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
    <!-- Styles -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/main.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
</head>

<body>   
    <div id="app">
            <!-- Navbar -->
  <nav class="navbar fixed-top navbar-expand-lg navbar-dark scrolling-navbar">
    <div class="container">

      <!-- Brand -->
      <a class="navbar-brand" href="{{ url('/dashboard/') }}" target="_blank">
        <strong>BP Rafa</strong>
      </a>

      <!-- Collapse -->
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
        aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <!-- Links -->
      <div class="collapse navbar-collapse" id="navbarSupportedContent">

        <!-- Left -->
        <ul class="navbar-nav mr-auto">
          @guest
              @if (Route::has('login'))
                  <li class="nav-item">
                      <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                  </li>
              @endif
          @else
                    @can('user-list')
                      <li class="nav-item dropdown">
                        <div class="dropdown-menu dropdown-menu-left">
                      @can('user-list')
                        <a class="dropdown-item" href="{{ route('users.index') }}">Użytkownicy</a>
                      @endcan
                      @can('role-list')
                        <a class="dropdown-item" href="{{ route('roles.index') }}">Statusy</a>
                      @endcan
                      @can('permission-list')
                        <a class="dropdown-item" href="{{ route('permissions.index') }}">Uprawnienia</a>
                    @endcan
                    </div>
                     <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                      Użytkownicy
                    </a>
                  </li>                      
                @endcan 
                @can('todo-list')
                  <li class="nav-item dropdown">
                    <div class="dropdown-menu dropdown-menu-left">
                        <a class="dropdown-item" href="{{ route('todo.index') }}">Lista zadań</a>
                        <a class="dropdown-item" href="{{ route('todo.create') }}">Nowe zadanie</a>
                        <a class="dropdown-item" href="{{ route('todostatus.index') }}">Lista statusów</a>
                        <a class="dropdown-item" href="{{ route('todostatus.create') }}">Nowy status</a>
                    </div>
                     <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                      Zadania
                    </a>
                  </li>                      
                @endcan 
                
                @can('contractors-list')
                  <li class="nav-item dropdown">

                    <div class="dropdown-menu dropdown-menu-left">
                        <a class="dropdown-item" href="{{ route('bookings.index') }}">Lista</a>
                        <a class="dropdown-item" href="{{ route('bookings.create') }}">Nowa</a>
                        <a class="dropdown-item" href="{{ route('bookingstatus.index') }}">Lista statusów</a>
                        <a class="dropdown-item" href="{{ route('bookingstatus.create') }}">Nowy</a>
                    </div>
                     <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                      Rezerwacje
                    </a>
                  </li>                      
                @endcan  

                @can('contractors-list')
                  <li class="nav-item dropdown">

                    <div class="dropdown-menu dropdown-menu-left">
                        <a class="dropdown-item" href="{{ route('notes.index') }}">Lista</a>
                        <a class="dropdown-item" href="{{ route('notes.create') }}">Nowy</a>
                    </div>
                     <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                      Notatki
                    </a>
                  </li>                      
                @endcan  
              @can('contractors-list')
                  <li class="nav-item dropdown">

                    <div class="dropdown-menu dropdown-menu-left">
                        <a class="dropdown-item" href="{{ route('contractors.index') }}">Lista</a>
                        <a class="dropdown-item" href="{{ route('contractors.create') }}">Nowy</a>
                    </div>
                     <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                      Kontrahenci
                    </a>
                  </li>                      
                @endcan  
                @can('event-list')
                    <li><a class="nav-link" href="{{ route('events.index') }}">Imprezy</a></li>
                @endcan      
              


              <li class="nav-item dropdown">

                  <div class="dropdown-menu dropdown-menu-left" aria-labelledby="navbarDropdown">
                      <a class="dropdown-item" href="{{ route('logout') }}"
                         onclick="event.preventDefault();
                                       document.getElementById('logout-form').submit();">
                          {{ __('Logout') }}
                      </a>
                      <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                          @csrf
                      </form>
                  </div>
                  <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                      {{ Auth::user()->name }}
                  </a>
              </li>
          @endguest
      </ul>

      </div>

    </div>
  </nav>
       
    <main>
            @yield('content')
            </div>
        </main>
    </div>

    {{-- scripts --}}

   
    <script src="{{ asset('js/res/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('js/res/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('js/res/summernote-bs4.js') }} "></script>
    <script src="{{ asset('js/app.js') }} " ></script>
    <script src="{{ asset('js/appscript.js') }} " ></script>
    @yield('scripts')
</body>
</html>
