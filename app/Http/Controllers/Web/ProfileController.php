<?php

declare(strict_types=1);

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\ChangePasswordRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    /**
     * Show the user profile details.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function view(Request $request)
    {
        return view('pages.profile');
    }

    /**
     * Update user password.
     *
     * @param ChangePasswordRequest $request
     * @return null
     */
    public function changePassword(ChangePasswordRequest $request)
    {
        /** @var User $user */
        $user = Auth::user();

        $user->password = Hash::make($request->input('new_password'));
        $user->save();

        return back()->withFragment('change-password')
            ->with('change-password', trans('passwords.changed'));
    }
}
