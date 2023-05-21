<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

class ResetPasswordController extends Controller
{
    //this method shows the reset page , after using email for reset
    public function showResetFormEmail(Request $request, $token = null)
    {
        return view('auth.passwords.reset')->with(
            ['token' => $token, 'email' => $request->email]
        );
    }


    //this method shows the reset page , after using mobile for reset
    public function showResetFormMobile(Request $request, $token = null)
    {
        return view('auth.passwords.reset')->with(
            ['token' => $token, 'mobile' => $request->mobile]
        );
    }


    //this method does the functionality of reset , regarding using email for reset, It validates the user's input, resets their password, and logs them in if the reset was successful.
    public function resetWithEmail(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:8',
        ]);

        $credentials = $request->only(
            'email', 'password', 'password_confirmation', 'token'
        );

        $response = Password::reset($credentials, function ($user, $password) {
            $user->forceFill([
                'password' => Hash::make($password)
            ])->save();
            Auth::login($user);
        });

        if ($response == Password::PASSWORD_RESET) {
            return redirect('/')->with('status', 'Password reset successfully!');
        } else {
            return back()->withErrors(['email' => [trans($response)]]);
        }
    }





    //this method does the functionality of reset , regarding using mobile for reset , It validates the user's input, resets their password, and logs them in if the reset was successful.
    public function resetWithMobile(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'mobile' => 'required|unique:users|regex:/^([0-9\s\-\+\(\)]*)$/|min:12',
            'password' => 'required|confirmed|min:8',
        ]);

        $credentials = $request->only(
            'mobile', 'password', 'password_confirmation', 'token'
        );

        $response = Password::reset($credentials, function ($user, $password) {
            $user->forceFill([
                'password' => Hash::make($password)
            ])->save();
            Auth::login($user);
        });

        if ($response == Password::PASSWORD_RESET) {
            return redirect('/')->with('status', 'Password reset successfully!');
        } else {
            return back()->withErrors(['mobile' => [trans($response)]]);
        }
    }
}
