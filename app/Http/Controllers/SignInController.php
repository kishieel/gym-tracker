<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\Auth\SignInRequest;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Auth;

/**
 * @group Authentication
 * @unathenticated
 */
class SignInController
{
    /**
     * Display sign in page.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function view()
    {
        return view('pages.sign-in');
    }

    /**
     * Authenticate with the provided credentials.
     *
     * @param \App\Http\Requests\Auth\SignInRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function action(SignInRequest $request): \Illuminate\Http\RedirectResponse
    {
        $email = $request->input('email');
        $password = $request->input('password');
        $remember = $request->boolean('remember', false);

        /** @var User $user */
        $user = User::where('email', $email)->first();

        $credentials = [
            'email' => $email,
            'password' => $password,
        ];

        if ($user && Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();

            return redirect()->intended(RouteServiceProvider::HOME);
        }

        return back()->withErrors(['password' => trans('auth.password')]);
    }
}
