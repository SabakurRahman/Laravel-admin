
<style>
    .size {
    width: 80%!important;
}
</style>


@extends('frontend.layouts.admin_login')


@section('page_title','Login')
@section('content')
    <div class="card">
        <div class="card-body">
            @include('global_partials.validation_error_display')
                <div class="text-center ">
                    <div class="mb-3">
                        <a href="{{route('front.index')}}" class="">
                            <img src="{{asset('tamplate/assets/images/Logo.png')}}" alt="" height="40" class="auth-logo logo-dark mx-auto">
                            <img src="{{asset('tamplate/assets/images/Logo.png')}}" alt="" height="40" class="auth-logo logo-light mx-auto">
                        </a>
                    </div>
                </div>
                <div>
                    <h4 class="font-size-18 text-muted mt-2 text-center">Welcome Back !</h4>
                    <p class="text-muted text-center mb-4">Sign in to continue to Aabash.</p>
                </div>

                {{-- <form class="form-horizontal" action="{{route('front.index')}}"> --}}
                <form method="POST" action="{{ route('login') }}">
                    @csrf 

                    <div class="mb-3">
                        <label class="form-label" for="email" value="__('Email')" >Username</label>
                        <input type="text" class="form-control" id="email" placeholder="Enter E-mail / Phone"name="login" :value="old('login')" required autofocus autocomplete="username">
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="password" :value="__('Password')" >Password</label>
                        <input type="password" class="form-control" id="password"placeholder="Enter password" name="password"required autocomplete="current-password">
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />

                    </div>
                    <div class="mb-3 row mt-4">
                        <div class="col-sm-6">
                            <label for="remember_me" class="inline-flex items-center">
                                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                                <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                            </label>
                        </div>

                        <div class="col-sm-6 text-end">
                            @if (Route::has('password.request'))
                                <a style="text-decoration: none;"class="text-muted" href="{{ route('password.request') }}">
                                    <i class="mdi mdi-lock"></i>Forgot your password?
                                </a>
                            @endif
                            {{-- <a href="auth-recoverpw.html" class="text-muted"><i class="mdi mdi-lock"></i> Forgot your password?</a> --}}
                        </div>
                    </div>

                    <div class="row mb-2">
                        <div class="col-12 text-center">
                            <x-primary-button class="ml-3 btn btn-primary size waves-effect waves-light">
                                {{ __('Log in') }}
                            </x-primary-button>
                        </div>
                                   
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="text-center plan-line">
                                <p>Need to Signup ? <a style="text-decoration: none"href={{ route('register') }} class="fw-bold text-primary"> SignUp </a></p>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection



{{-- <x-guest-layout> --}}
    <!-- Session Status -->
    {{-- <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf --}}

        <!-- Email Address -->
        {{-- <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div> --}}

        <!-- Password -->
        {{-- <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div> --}}

        <!-- Remember Me -->
        {{-- <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-end mt-4">
            @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif

            <x-primary-button class="ml-3">
                {{ __('Log in') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout> --}}





