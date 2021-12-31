<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SignOutController
{
    /**
     * Destroy authenticated user session or token.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function action(Request $request): \Illuminate\Http\RedirectResponse
    {
        Auth::logout();

        return redirect()->intended('/');
    }
}
