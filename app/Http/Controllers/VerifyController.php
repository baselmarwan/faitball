<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class verifyController extends Controller
{
    public function checkYourPhone(Request $request){
        $request->validate([
            'otp_code' => 'required|numeric',
            'user_id' => 'required',
        ]);
        $input_code = $request->input('otp_code');
        $user = User::find($request->input('user_id'));
        if($user->verification_code == $input_code){
            $user->update(['is_verified'=>true]);
            return ('checked successfully');
        }
        
    }

    
    public function resendCode(Request $request){
        $user = User::find($request->user_id);
        $user->update([
            'verification_code' => rand(1000, 9999),
        ]);
        //$user->notify(new SendSMSNotification($user));
        return "verification code resend successfully";
    }
}
