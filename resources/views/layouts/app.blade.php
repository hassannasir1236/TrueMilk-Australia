<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('js/dashboard.js') }}" defer></script>

    <script src="{{ asset('js/script.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- Add SheetJS library for Excel export -->
    <script src="https://cdn.sheetjs.com/xlsx-0.19.3/package/dist/xlsx.full.min.js"></script>
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">

                    </ul>
                </div>
            </div>
        </nav>
        @auth
                <main class="py-4">
                    <div class="dashboard-layout">
                        <!-- Sidebar -->

                        <aside class="sidebar">
                            <div class="sidebar-header">
                                <h1>Australian<span>Dairy</span></h1>
                            </div>
                            <div class="sidebar-menu">
                                <ul>
                                    <li class="active" data-section="overview">
                                        <a href="{{ route('home') }}">
                                            <i class="fas fa-home"></i>
                                            <span>Overview</span>
                                        </a>
                                    </li>
                                    <li data-section="farms"
                                        class="{{ (isset($activePage) && $activePage === 'farms') ? 'active' : '' }}">
                                        <a href="{{ route('farms.index') }}">
                                            <i class="fas fa-tractor"></i>
                                            <span>Add/Update Farms</span>
                                        </a>
                                    </li>
                                    <li data-section="farms-inventory"
                                        class="{{ (isset($activePage) && $activePage === 'inventory') ? 'active' : '' }}">
                                        <a href="{{ route('farm-inventory.index') }}">
                                            <i class="fas fa-boxes"></i>
                                            <span>Add Farms-Invertory</span>
                                        </a>
                                    </li>
                                    @php
                                        $states = \App\Models\State::all();
                                    @endphp
                                    @foreach($states as $state)
                                        @if(empty(Auth::user()->state_id) || Auth::user()->state_id == $state->id)
                                            <li class="{{ (isset($activePage) && $activePage == $state->id) ? 'active' : '' }}">
                                                <a href="{{ route('state.dashboard', $state->id) }}">
                                                    <i class="fas fa-map-marker-alt"></i>
                                                    {{ $state->name }}
                                                </a>
                                            </li>
                                        @endif
                                    @endforeach

                                    <li data-section="reports" style="display: none;">
                                        <a href="#reports">
                                            <i class="fas fa-chart-bar"></i>
                                            <span>Reports</span>
                                        </a>
                                    </li>
                                    <li data-section="settings"
                                        class="{{ (isset($activePage) && $activePage == 'setting') ? 'active' : '' }}">
                                        <a href="{{ route('setting.index') }}">
                                            <i class="fas fa-cog"></i>
                                            <span>Settings</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <div class="sidebar-footer">
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                                                                document.getElementById('logout-form').submit();" class="logout-btn" style="color: white;">
                                    {{ __('Logout') }} <i class="fas fa-sign-out-alt"></i>
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </aside>

                        <!-- Main Content -->
                        <main class="main-content">
                            @yield('content')
                        </main>
                    </div>
                </main>
        @else
            <main class="py-4">
                @yield('content')
            </main>
        @endauth
</body>

</html>