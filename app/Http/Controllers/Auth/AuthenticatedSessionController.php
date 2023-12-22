<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {


        $user = User::query()
        ->where('email', $request->input('login'))
        ->orWhere('phone', $request->input('login'))
        ->first();

        if($user){
            if(Hash::check($request->input('password'), $user->password)){
                Auth::login($user);
                redirect()->intended(RouteServiceProvider::HOME);
            }else{
                throw ValidationException::withMessages(['login' => 'Login credencials are incorrect']);
            }
        }
         throw ValidationException::withMessages(['login' => 'Login credencials are incorrect 23']);

        return redirect()->back();
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        // Auth::guard('web')->logout();
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
        // return redirect('/login');
    }
}
