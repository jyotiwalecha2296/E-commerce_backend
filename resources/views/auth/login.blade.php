<link href="{{ asset('lineicons/icon-font/lineicons.css') }}" rel="stylesheet" type="text/css"> 
<link href="{{ asset('css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet" type="text/css">
<link href="{{ asset('css/app.css') }}" id="app-style" rel="stylesheet" type="text/css">
@extends('layouts.app')
@section('content')
<div class="login-page">
    <div class="container">
        <div class="row">
          <div class="col-lg-10 offset-lg-1">
            <h3 class="mb-3">{{ __('Login') }}</h3>
            <div class="bg-white shadow rounded">
              <div class="row">
                <div class="col-md-7 pe-0">
                  <div class="form-left h-100 py-5 px-5">                   
                    <form method="POST" action="{{ route('login.attempt') }}">
                        @csrf

                        <div class="row mb-3">
                            <label>{{ __('Email Address') }}<span class="text-danger">*</span></label>
                            <div class="input-group">
                              <div class="input-group-text"><i class="lni lni-user"></i></div>
                              <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="Enter Username">
                            </div>
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror                            
                        </div>

                        <div class="row mb-3">                           
                            <label>{{ __('Password') }}<span class="text-danger">*</span></label>
                            <div class="input-group">
                              <div class="input-group-text"><i class="lni lni-lock-alt"></i></div>
                              <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" >
                            </div>
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror                            
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-6">
                                <div class="form-check">
                                  <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }} >
                                  <label class="form-check-label" for="inlineFormCheck">{{ __('Remember Me') }}</label>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
                            </div>
                        </div>
                        <div class="row mb-3">
                          <div class="col-12">
                            <button type="submit" class="btn btn-primary px-4 float-end mt-4">{{ __('Login') }}</button>
                          </div> 
                        </div>                       
                    </form>
                  </div>
                </div>
                <div class="col-md-5 ps-0 d-none d-md-block">
                  <div class="form-right h-100 bg-primary text-white text-center pt-5 rounded-end">
                    <img src="{{ asset('images/logo/dummy-logo-white.png') }}" alt="E-Commerce Logo" title="E-Commerce">
                    <h2 class="fs-1 mt-5">PRECISION TIME INSTRUMENTS</h2>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Login') }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <div class="row mb-3">
                                <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                                <div class="col-md-6">
                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
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
                                        {{ __('Login') }}
                                    </button>

                                    @if (Route::has('password.request'))
                                        <a class="btn btn-link" href="{{ route('password.request') }}">
                                            {{ __('Forgot Your Password?') }}
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div> -->
    </div>
</div>
@endsection
