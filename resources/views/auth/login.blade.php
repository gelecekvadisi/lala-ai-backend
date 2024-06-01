@extends('layouts.auth.app')

@section('title')
    {{ __('Login') }}
@endsection

@section('main_content')
<div class="mybazar-login-section">
    <div class="mybazar-login-wrapper"></div>
        <div class="mybazar-login-avatar" style="width: 25%;">
            <img src="{{ asset('assets/images/login/login-avatar.png') }}" alt="" style="width: %10">
        </div>
        
        <div class="mybazar-login-wrapper">
            <div class="login-wrapper">
                <div class="login-body w-100">
                    <h2>Welcome to<span> Maan OpenAI</span></h2>
                    <h6>Welcome back, Please login in to your account</h6>
                    <form method="POST" action="{{ route('login') }}" class="ajaxform_instant_reload">
                        @csrf
                        <div class="input-group">
                            <span><img src="{{ asset('assets/images/icons/user.png') }}" alt="img"></span>
                            <input type="email" name="email" class="form-control email" placeholder="Enter your Email">
                        </div>

                        <div class="input-group">
                            <span><img src="{{ asset('assets/images/icons/lock.png') }}" alt="img"></span>
                            <span class="hide-pass">
                                <img src="{{ asset('assets/images/icons/Hide.svg') }}" alt="img">
                                <img src="{{ asset('assets/images/icons/show.svg') }}" alt="img">
                            </span>
                            <input type="password" name="password" class="form-control password" placeholder="Password">
                        </div>

                        <div class="mt-lg-3 mb-0 forget-password">
                            <label class="custom-control-label">
                                <input type="checkbox" name="remember" class="custom-control-input">
                                <span>Remember me</span>
                            </label>
                            <a href="{{ route('password.request') }}">{{ ('Forgot Password?') }}</a>
                        </div>

                        <button type="submit" class="btn login-btn submit-btn">{{ __('Login') }}</button>

                        {{-- <div class="login-button-list">
                            <ul>
                                <li><a class="theme-btn" href="javascript:void(0)" onclick="fillup('superadmin@superadmin.com','superadmin')">{{ __('Super Admin') }}</a></li>
                                <li><a class="theme-btn" href="javascript:void(0)" onclick="fillup('admin@admin.com','admin')">{{ __('Admin') }}</a></li>
                                <li><a class="theme-btn" href="javascript:void(0)" onclick="fillup('manager@manager.com','manager')">{{ __('Manager') }}</a></li>
                            </ul>
                        </div> --}}
                    </form>
                </div>
            </div>
        </div>
        <div class="mybazar-login-wrapper"></div>
    </div>
    <input type="hidden" data-model="Login" id="auth">
@endsection

@push('js')
<script src="{{ asset('assets/js/auth.js') }}"></script>
@endpush

