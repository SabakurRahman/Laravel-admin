@extends('frontend.layouts.admin_login')

@section('page_title','Login')
@section('content')
        <div class="card">
            <div class="card-body">
                <div class="text-center mt-4">
                    <div class="mb-3">
                        <a href="{{route('front.index')}}" class="">
                            <img src="{{asset('tamplate/assets/images/Logo.png')}}" alt="" height="40" class="auth-logo logo-dark mx-auto">
                            <img src="{{asset('tamplate/assets/images/Logo.png')}}" alt="" height="40" class="auth-logo logo-light mx-auto">
                        </a>
                    </div>
                </div>
                <div>
                    <h4 class="font-size-18 text-muted mt-2 text-center mb-4">Reset Password</h4>
                    <div class="alert alert-info" role="alert">
                        Enter your Email and instructions will be sent to you!
                    </div>

                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="email":value="__('Email')">Email</label>
                            <input type="email" class="form-control" id="email"
                                            placeholder="Enter email"name="email" :value="old('email')" required autofocus>
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>


                        <div class="mb-3 row mt-4">
                            <div class="col-12 text-end">
                                <x-primary-button class="btn btn-primary w-100 waves-effect waves-light">
                                    {{ __('Email Password Reset Link') }}
                                </x-primary-button>
                            </div>
                        </div>

                    </form>

                </div>

            </div>
        </div>
        <div class="mt-2 text-center">
            <p>Remember It ? <a href={{ route('login') }}class="fw-bold text-primary"> Sign In Here </a> </p>
            <p>©
                <script>document.write(new Date().getFullYear())</script> Aabash with <i
                                class="mdi mdi-heart text-danger"></i> by MicroDeft
            </p>
        </div>

@endsection
{{-- <x-guest-layout>
    <div class="mb-4 text-sm text-gray-600">
        {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
    </div> --}}

    <!-- Session Status -->
    {{-- <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}">
        @csrf --}}

        <!-- Email Address -->
        {{-- <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button>
                {{ __('Email Password Reset Link') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout> --}}
