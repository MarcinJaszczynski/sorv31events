<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="pl">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Biuro Podróży Rafa</title>
    @stack('meta')


    <!-- Google Font: Source Sans Pro -->





    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>{{ config('app.name', 'Laravel') }}</title>
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- Styles -->
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('assets/dist/css/adminlte.min.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css"
        integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/main.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">



        <!-- Navbar -->


        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <div class="collapse navbar-collapse" id="navbarSupportedContent">

                <ul class="navbar-nav mr-auto">


                    @guest
                        @if (Route::has('login'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                        @endif
                    @else
                        @can('user-perm')
                            <li><a class="nav-link" href="{{ route('eventinit') }}">Szybkie zapytanie</a></li>

                            <li class="nav-item dropdown">
                                <div class="dropdown-menu dropdown-menu-left">
                                    <a class="dropdown-item" href="/events/list">Szukaj</a>
                                    <a class="dropdown-item" href="/events/getevents?eventStatus=Zapytanie">Zapytanie</a>
                                    <a class="dropdown-item" href="/events/getevents?eventStatus=oferta">Oferta</a>
                                    <a class="dropdown-item" href="/events/getevents?eventStatus=Potwierdzona">Potwierdzone</a>
                                    <a class="dropdown-item" href="/events/getevents?eventStatus=1">Najnowsze potwierdzone</a>
                                    <a class="dropdown-item" href="/events/getevents?eventStatus=DoRozliczenia">Do
                                        rozliczenia</a>
                                    <a class="dropdown-item" href="/events/getevents?eventStatus=Zakończona">Rozliczone</a>
                                    <a class="dropdown-item" href="/events/getevents?eventStatus=doanulacji">Do anulacji</a>
                                    <a class="dropdown-item" href="/events/getevents?eventStatus=Anulowana">Anulowane</a>
                                    <a class="dropdown-item" href="/events/getevents?eventStatus=All">Wszystkie</a>
                                </div>
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    IMPREZY
                                </a>
                            </li>
                            <li class="nav-item dropdown">
                                <div class="dropdown-menu dropdown-menu-left">
                                    <a class="dropdown-item" href="/bookings">Wszystkie</a>
                                    <a class="dropdown-item" href="{{ url('/bookings/getbookings/0') }}">Bez rezerwacji</a>
                                    <a class="dropdown-item" href="{{ url('/bookings/getbookings/1') }}">Do rezerwacji</a>
                                    <a class="dropdown-item" href="{{ url('/bookings/getbookings/2') }}">Zarezerwowane</a>
                                    <a class="dropdown-item" href="{{ url('/bookings/getbookings/3') }}">Do anulacji</a>
                                    <a class="dropdown-item" href="{{ url('/bookings/getbookings/4') }}">Anulowane</a>
                                    {{-- <a class="dropdown-item" href="{{url('/bookings/getbookings/5')}}">Autokary</a>       
                        <a class="dropdown-item" href="{{url('/bookings/getbookings/6')}}">Hotele</a>        --}}

                                </div>
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    Rezerwacje
                                </a>
                            </li>
                        @endcan

                        @can('user-perm')
                            <li class="nav-item dropdown">
                                <div class="dropdown-menu dropdown-menu-left">
                                    <a class="dropdown-item" href="{{ route('todo.index') }}">Lista zadań</a>
                                    <a class="dropdown-item" href="{{ route('todo.indexdone') }}">Zadania zaakceptowane</a>

                                    @can('autor-perm')
                                        <a class="dropdown-item" href="{{ route('todo.create') }}">Nowe zadanie</a>
                                    @endcan
                                    <a class="dropdown-item" href="{{ route('todostatus.index') }}">Lista statusów</a>
                                    @can('autor-perm')
                                        <a class="dropdown-item" href="{{ route('todostatus.create') }}">Nowy status</a>
                                    @endcan
                                </div>
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    Zadania
                                </a>
                            </li>
                        @endcan


                        @can('user-perm')
                            <li class="nav-item dropdown">

                                <div class="dropdown-menu dropdown-menu-left">
                                    <a class="dropdown-item" href="/contractors/list">Szukaj</a>
                                    <a class="dropdown-item" href="{{ route('contractors.index') }}">Lista kontrahentów</a>
                                    @can('autor-perm')
                                        <a class="dropdown-item" href="{{ route('contractors.create') }}">Nowy kontrahent</a>
                                        <a class="dropdown-item" href="{{ route('contractorstypes.index') }}">Typy
                                            kontrahentów</a>
                                        <a class="dropdown-item" href="{{ route('contractorstypes.create') }}">Nowy typ
                                            kontrahenta</a>
                                    @endcan
                                </div>
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    Kontrahenci
                                </a>
                            </li>
                        @endcan
                        @can('admin-perm')
                            <li class="nav-item dropdown">
                                <div class="dropdown-menu dropdown-menu-left">
                                    <a class="dropdown-item" href="{{ route('users.index') }}">Użytkownicy</a>
                                    <a class="dropdown-item" href="{{ route('roles.index') }}">Statusy</a>
                                    <a class="dropdown-item" href="{{ route('permissions.index') }}">Uprawnienia</a>
                                </div>
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    Użytkownicy
                                </a>
                            </li>
                        @endcan
                        @can('admin-perm')
                            <li class="nav-item dropdown">
                                <div class="dropdown-menu dropdown-menu-left">
                                    <a class="dropdown-item" href="{{ route('currency.index') }}">Waluty</a>
                                    <a class="dropdown-item" href="{{ route('paymenttypes.index') }}">Rodzaje płatności</a>
                                    <a class="dropdown-item" href="{{ url('/reports/entrants') }}">Raport uczestnictwa</a>
                                    {{-- <a class="dropdown-item" href="{{ route('roles.index') }}">Statusy</a> --}}
                                    {{-- <a class="dropdown-item" href="{{ route('permissions.index') }}">Uprawnienia</a> --}}
                                </div>
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    Admin
                                </a>
                            </li>
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
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->name }}
                            </a>
                        </li>
                    @endguest
                </ul>
            </div>

            <!-- Right navbar links -->
            @can('todo-list')
                <ul class="navbar-nav ml-auto">
                    <!-- Navbar Search -->
                    {{-- <li class="nav-item">
        <a class="nav-link" data-widget="navbar-search" href="#" role="button">
          <i class="fas fa-search"></i>
        </a>
        <div class="navbar-search-block">
          <form class="form-inline">
            <div class="input-group input-group-sm">
              <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
              <div class="input-group-append">
                <button class="btn btn-navbar" type="submit">
                  <i class="fas fa-search"></i>
                </button>
                <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                  <i class="fas fa-times"></i>
                </button>
              </div>
            </div>
          </form>
        </div>
      </li> --}}

                    <!-- Notifications Dropdown Menu -->
                    <li class="nav-item">
                        <a class="nav-link" href="/todo?urgent=1" alt="Alarm">
                            <i class="far fa-bell"></i>
                            <span class="badge bg-danger navbar-badge">
                                @php
                                    echo DB::table('todos')
                                        ->where('urgent', '1')
                                        ->count();
                                @endphp
                            </span>
                        </a>
                    </li>

                    <!-- Messages Dropdown Menu -->
                    <li class="nav-item">
                        <a class="nav-link" href="/todo?executor={{ Auth::user()->id }}" class="small-box-footer"
                            alt="Nowe zadania">
                            <i class="far fa-comments"></i>
                            <span class="badge bg-info navbar-badge">
                                @php
                                    echo DB::table('todos')
                                        ->where('executor_id', Auth::user()->id)
                                        ->where('status_id', '1')
                                        ->count();
                                @endphp
                            </span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="/events/getevents?eventStatus=Zapytanie" alt="Zapytania">
                            <i class="far fa-comments"></i>
                            <span class="badge bg-success navbar-badge">
                                @php
                                    echo DB::table('events')
                                        ->where('eventStatus', 'Zapytanie')
                                        ->count();
                                @endphp
                            </span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/events/getevents?eventStatus=doanulacji" class="small-box-footer"
                            alt="Nowe zadania">
                            <i class="far fa-comments"></i>
                            <span class="badge bg-warning navbar-badge">
                                @php
                                    echo DB::table('events')
                                        ->where('eventStatus', 'doanulacji')
                                        ->count();
                                @endphp
                            </span>
                        </a>
                    </li>
                @endcan

            </ul>
        </nav>
        <!-- /.navbar -->
        @auth
            <!-- Main Sidebar Container -->
            <aside class="main-sidebar sidebar-dark-primary elevation-4">
                <!-- Brand Logo -->
                <a href="\dashboard" class="brand-link">
                    {{-- <img src="dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8"> --}}
                    <span class="brand-text font-weight-light">BP Rafa</span>
                </a>

                <!-- Sidebar -->
                <div class="sidebar">
                    <!-- Sidebar user panel (optional) -->
                    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                        {{-- <div class="image">
          <img src="dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
        </div> --}}
                        <div class="info">
                            <a href="#" class="d-block">{{ Auth::user()->name }}</a>
                        </div>
                    </div>



                    <!-- Sidebar Menu -->
                    <nav class="mt-2">
                        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                            data-accordion="false">


                            <li class="nav-item menu-open">
                                <a href="{{ route('eventinit') }}" class="nav-link active">
                                    <i class="nav-icon fas fa-tachometer-alt"></i>
                                    <p>
                                        Szybkie zapytanie
                                        </i>
                                    </p>
                                </a>
                            </li>





                        </ul>
                    </nav>


                    <div class="timeline">
                        <!-- timeline time label -->
                        <div class="time-label">
                            <span class="bg-red">
                                @php
                                    $mytime = Carbon\Carbon::now()->format('d-m-Y');
                                    echo $mytime;
                                @endphp
                            </span>
                        </div>
                        <div class="container">
                            <article id="latestActivityTimeline">

                            </article>
                        </div>
                    </div>
                </div>




                <!-- END timeline item -->


                <!-- /.sidebar-menu -->
                <!-- /.sidebar -->
            </aside>
        @endauth
        <div class="content-wrapper">
            <main>
                @yield('content')
            </main>
            <!-- /.content-header -->
        </div>

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
        <script src="{{ asset('js/res/jquery-3.6.0.min.js') }}"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.2.1/moment.min.js"></script>

        <script src="{{ asset('js/res/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('js/res/summernote-bs4.js') }} "></script>
        <script src="{{ asset('js/app.js') }} "></script>
        <script src="{{ asset('js/appscript.js') }} "></script>
        <script>
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        </script>


        <script>
            $(document).ready(function() {
                $(".summernoteeditor").summernote({
                    height: 150, //set editable area's height
                    codemirror: { // codemirror options
                        theme: 'monokai'
                    }
                });
            });

            let latestActivity = ''

            function lifetimeline() {
                $.post('{{ url('/search/latestactivity') }}', {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                    },
                    function(data) {
                        latest_activity_row(data);
                    });

                setTimeout(lifetimeline, 100000);

            }

            function latest_activity_row(res) {
                latestActivity = ''
                if ((Object.keys(res.latestActivities).length) <= 0) {
                    latestActivity += `
              <tr>
                  <td colspan="4">Brak danych.</td>
              </tr>`;
                } else {
                    for (let i = 0; i < (Object.keys(res.latestActivities).length); i++) {
                        let created = moment.utc(res.latestActivities[i].created_at, "YYYY-MM-DD\THH:mm:ss\Z").format(
                            "YYYY-MM-DD HH:mm")
                        let title = ''
                        let kind = ''
                        let author = ''
                        let link = ''
                        let desc = ''
                        if (res.latestActivities[i].kind === 'event') {
                            kind = 'dodał imprezę'
                            if (res.latestActivities[i].author_id !== null) {
                                author = res.latestActivities[i].author.name
                            }
                            title = '<strong>' + res.latestActivities[i].eventName + '</strong>'
                            link = '"/events/' + res.latestActivities[i].id + '/edit"'
                        } else if (res.latestActivities[i].kind === 'todo') {
                            kind = 'dodał zadanie '
                            author = res.latestActivities[i].principal.name
                            title = res.latestActivities[i].name
                            if (res.latestActivities[i].event_id !== '' || res.latestActivities[i].event_id !== undefined) {
                                link = '"/events/' + res.latestActivities[i].event_id + '/edit"'
                            } else {
                                link = '"/todos/' + res.latestActivities[id].id + '/edit"'
                            }
                        } else {
                            kind = 'dodał komentarz'
                            author = res.latestActivities[i].author_id
                            title = res.latestActivities[i].name

                        }

                        latestActivity += `
          <div class="card">
            <div class="card-body">
              <div class="card-text">

              <span class="handle ui-sortable-handle">
              <i class="fas fa-ellipsis-v"></i>
              <i class="fas fa-ellipsis-v"></i>
              </span>
          <span class="text-muted small float-right"><i class="far fa-clock"> </i> ` + created + `</span><br />
              <div>` + author + `<br />
              ` + kind + `
            </div>
              <div>
                <a class="text-uppercase font-decoration-none text-weight-bold text-dark" href=` + link + `>` + title + `</a> 
              </div>
            </div>

          </div>
        </div>`
                    }
                    $('#latestActivityTimeline').html(latestActivity);

                }

                // $('#latestActivityTimeline').html(latestActivity);
            }

            lifetimeline()
        </script>


        @yield('scripts')


</body>

</html>
