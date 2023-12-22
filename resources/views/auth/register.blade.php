
@extends('frontend.layouts.admin_login')

@section('page_title','SignUp')
{{-- <x-guest-layout> --}}
@section('content')
    <div class="card">
        <div class="card-body">
            <div class="text-center mt-1">
                <div class="mb-3">
                    <a href="{{route('front.index')}}" class="">
                        <img src="{{asset('tamplate/assets/images/Logo.png')}}" alt="" height="40" class="auth-logo logo-dark mx-auto">
                        <img src="{{asset('tamplate/assets/images/Logo.png')}}" alt="" height="40" class="auth-logo logo-light mx-auto">
                    </a>
                </div>
            </div>
            <div>
                <h4 class="font-size-18 text-muted mt-2 text-center">Free Register</h4>
                <p class="text-muted text-center mb-4">Get your free Aabash account now.</p>

                {{-- <form class="form-horizontal" action="index.html"> --}}
                <form method="POST" action="{{ route('register') }}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label" for="name":value="__('Name')">Name</label>
                        <input type="text" class="form-control" id="name"placeholder="Enter username"name="name" :value="old('name')" required autofocus autocomplete="name">
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="email":value="__('Email')">Email</label>
                        <input type="email" class="form-control" id="email"
                                            placeholder="Enter email"name="email" :value="old('email')" required autocomplete="username">
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="phone":value="__('Phone')">Phone</label>
                        <input type="phone" class="form-control" id="phone"
                                            placeholder="Enter phone number"name="phone" :value="old('phone')" required autocomplete="username">
                        <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                    </div>



                    <div class="mb-3">
                        <label class="form-label" for="password":value="__('Password')">Password</label>
                        <input type="password" class="form-control" id="password"placeholder="Enter password"name="password" required autocomplete="new-password">
                    
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label" for="password_confirmation" :value="__('Confirm Password')">Confirm Password</label>
                        <input type="password" class="form-control" id="password_confirmation" placeholder="Confirm password"name="password_confirmation" required autocomplete="new-password">
                    
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                    
                    </div>

                    <div class="mb-1 row mt-4">
                        <div class="col-12 text-end">
                             {{-- <button class="btn btn-primary w-100 waves-effect waves-light"
                                                type="submit">Register</button> --}}
                            <x-primary-button class="btn btn-primary w-100 waves-effect waves-light">
                                {{ __('Register') }}
                            </x-primary-button>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-12">
                            <div class="text-center plan-line">
                                <p>Already have an account ? <a style="text-decoration: none" href={{ route('login') }} class="fw-bold text-primary"> Login </a></p>
                            </div>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>

@endsection
{{-- </x-guest-layout> --}}




{{-- <x-guest-layout> --}}
    {{-- <form method="POST" action="{{ route('register') }}">
        @csrf --}}

        <!-- Name -->
        {{-- <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div> --}}

        <!-- Email Address -->
        {{-- <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div> --}}

        <!-- Password -->
        {{-- <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div> --}}

        <!-- Confirm Password -->
        {{-- <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ml-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form> --}}
{{-- </x-guest-layout> --}}