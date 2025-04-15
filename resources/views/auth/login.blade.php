@extends('layouts.app')

@section('content')
<div class="login-page">
<div class="login-wrapper">
        <div class="login-container">
            <div class="logo-section">
                <h1>Australian<span>Dairy</span></h1>
                <p>Management Information System</p>
            </div>

            <h2>Manager Portal</h2>
            <form id="loginForm" method="POST" action="{{ route('login') }}">
                @csrf

                <div class="form-group">
                    <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                    <div class="col-md-6">
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                            name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group">
                    <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                    <div class="col-md-6">
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                            name="password" required autocomplete="current-password">

                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="region">Region</label>
                    <select id="region" name="region">
                        <option value="all">All Regions</option>
                        <option value="nsw">New South Wales</option>
                        <option value="queensland">Queensland</option>
                        <option value="wa">Western Australia</option>
                        <option value="victoria">Victoria</option>
                    </select>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6 offset-md-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                            <label class="form-check-label" for="remember">
                                {{ __('Remember Me') }}
                            </label>
                        </div>
                    </div>
                </div>

                <div class="row mb-0">
                    <div class="col-md-8 offset-md-4">
                        <button type="submit" class="btn btn-primary">
                            {{ __('Sign in') }}
                        </button>

                        @if (Route::has('password.request'))
                            <a class="forgot-password" href="{{ route('password.request') }}">
                                {{ __('Forgot Your Password?') }}
                            </a>
                        @endif
                    </div>
                </div>
            </form>
        </div>

        <div class="login-info">
            <h3 style="color: white;">Real-time Production Data</h3>
            <p>Access comprehensive data on milk sourcing, daily intake, and production figures across New South Wales,
                Queensland, Western Australia, and Victoria operations.</p>

            <ul class="login-features">
                <li><i class="fas fa-chart-line"></i> Track milk sourcing data from all partner farms</li>
                <li><i class="fas fa-calendar-day"></i> Monitor daily milk intake across all facilities</li>
                <li><i class="fas fa-industry"></i> View production metrics for all product lines</li>
                <li><i class="fas fa-map-marked-alt"></i> Compare regional performance data</li>
                <li><i class="fas fa-truck"></i> Track supply chain and distribution</li>
            </ul>

            <div class="company-info">
                <p>For authorized personnel only. All data accessed through this portal is confidential.</p>
                <div class="login-links">
                    <a href="index.html">Return to Website</a>
                    <a href="#help">Help</a>
                    <a href="#contact">Contact IT Support</a>
                </div>
            </div>
        </div>
    </div>
</div>
   

@endsection