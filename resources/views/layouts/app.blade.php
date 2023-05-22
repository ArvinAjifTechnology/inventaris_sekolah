<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <title>{{ config("app.name", "Laravel") }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com" />
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <link href="{{ asset('') }}assets/vendor/simple-datatables/style.css" rel="stylesheet">

    <!-- Scripts -->
    {{-- @vite(['resources/sass/app.scss', 'resources/sass/simple-datatables.scss', 'resources/js/app.js',
    'resources/js/simple-datatables.js']) --}}
    @vite(['resources/sass/app.scss', 'resources/js/app.js',])
</head>

<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config("app.name", "Laravel") }}
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>
                @Auth
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">
                        @can('admin')
                        <li class="nav-item">
                            <a class="nav-link {{ Request::is('admin/users*') ? 'active' : '' }}"
                                href="{{ route('admin.users.index') }}">{{ __("Users") }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ Request::is('admin/rooms*') ? 'active' : '' }}"
                                href="{{ url('admin/rooms') }}">{{ __("Ruangan") }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ Request::is('admin/items*') ? 'active' : '' }}"
                                href="{{ url('admin/items') }}">{{ __("Barang") }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ Request::is('admin/borrows*') ? 'active' : '' }}"
                                href="{{ url('admin/borrows') }}">{{ __("Peminjaman") }}</a>
                        </li>
                        @endcan @can('operator')
                        <li class="nav-item">
                            <a class="nav-link {{ Request::is('operator/rooms*') ? 'active' : '' }}"
                                href="{{ url('operator/rooms') }}">
                                {{ __("Ruangan") }}
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ Request::is('operator/items*') ? 'active' : '' }}"
                                href="{{ url('operator/items') }}">
                                {{ __("Barang") }}
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ Request::is('operator/borrows*') ? 'active' : '' }}"
                                href="{{ url('operator/borrows') }}">
                                {{ __("Peminjaman") }}
                            </a>
                        </li>
                        @endcan @can('borrower')
                        <li class="nav-item">
                            <a class="nav-link {{ Request::is('borrower/borrows*') ? 'active' : '' }}"
                                href="{{ url('borrower/borrows') }}">
                                {{ __("Peminjaman") }}
                            </a>
                        </li>
                        @endcan
                    </ul>
                    @endauth
                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        @auth
                        <li class="btn btn-primary">{{ __(ucfirst(Auth::user()->role)) }}</a>
                        </li>
                        @endauth
                        <!-- Authentication Links -->
                        @guest @if (Route::has('login'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">{{ __("Login") }}</a>
                        </li>
                        @endif @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">{{ __("Register") }}</a>
                        </li>
                        @endif @else
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->full_name }}
                            </a>

                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    {{ __("Logout") }}
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
        </nav>

        <main class="py-4">@yield('content')</main>
    </div>
    <script src="{{ asset('') }}/assets/vendor/simple-datatables/simple-datatables.js"></script>
</body>

</html>
