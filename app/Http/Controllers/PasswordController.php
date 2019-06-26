<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChangePasswordRequest;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class PasswordController extends Controller
{
    public function index()
    {
        return view('change-password');
    }

    public function store(ChangePasswordRequest $request)
    {
//        dd($request->all());

        if (! Hash::check($request->get('old_password'), Auth()->user()->getAuthPassword())) {
            return redirect()->back()->withErrors(['Incorrect old password entered.']);
        }

        Auth::user()->update([
            'password' => bcrypt($request->get('password'))
        ]);

        Auth::logout();

        return redirect('/login')->withErrors(['Successfully changed password. Please log in again.']);
    }
}
