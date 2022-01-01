<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class SignOutController extends Controller
{
    /**
     * Destroy authenticated user session or token.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function action(): \Illuminate\Http\RedirectResponse
    {
        Auth::logout();

        return redirect()->intended('/');
    }
}
