<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register1', 'register2', 'getPhoto']]);
    }
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);
        $credentials = $request->only('email', 'password');
        $token = Auth::attempt($credentials);
        if (!$token) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized',
            ], 401);
        }

        $user = Auth::user();
        return response()->json([
            'status' => 'success',
            'user' => $user,
            'authorization' => [
                'token' => $token,
                'type' => 'bearer',
            ],
        ]);
    }
    public function loginWithVerificationCode(Request $request)
    {
        $user = User::where('mobile', $request->mobile)->first();
        if (!$user) {
            return ('no such mobile number in the system');
        }
        if ($user->verification_code != $request->verification_code) {
            return (['verification_code' => 'The provided verification code is incorrect.']);
        }
        $token = Auth::login($user);

        return response()->json([
            'status' => 'success',
            'user' => $user,
            'authorization' => [
                'token' => $token,
                'type' => 'bearer',
            ],
        ]);
    }
    public function registerStepOne(Request $request)
    {
        $request->validate([
            'name' => 'required|min:3|max:100',
            'mobile' => 'required|unique:users|regex:/^([0-9\s\-\+\(\)]*)$/|min:12',
            'identity_number' => 'nullable|min:5|max:20',
        ]);

        $user = User::create([
            $verify_code = rand(1000, 9999),
            'name' => $request->name,
            'mobile' => $request->mobile,
            'identity_number' => $request->identity_number,
            'verification_code' => $verify_code,
        ]);

        $token = Auth::login($user);
        return response()->json([
            'status' => 'success',
            'message' => 'User created successfully',
            'user' => $user,
            'authorization' => [
                'token' => $token,
                'type' => 'bearer',
            ],
        ]);
        //$user->notify(new SendSMSNotification($user));
    }
    public function registerStepTwo(Request $request)
    {
        
        $user = User::find($request->userId);
        $request->validate(
            [
                'email' => 'string|email|unique:users|nullable',
                'password' => 'string|min:8|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/|nullable',
                'image' => 'image|mimes:jpeg,png,jpg,gif,bmp|max:1024|nullable',
            ]);
        if ($request->email) {
            $user->update([
                'email' => $request->email,
            ]);
        }
        if ($request->password) {
            $user->update([
                'password' => Hash::make($request->password),
            ]);
        }
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $image->store('public');
            $user->image()->create([
                'path' => $image->hashName(),
            ]);
        }
        
        $token = $this->login($user);
        return response()->json([
            'status' => 'success',
            'message' => 'User created successfully',
            'user' => $user,
            'authorization' => [
                'token' => $token,
                'type' => 'bearer',
            ],
        ]);
    }
    public function logout()
    {
        Auth::logout();
        return response()->json([
            'status' => 'success',
            'message' => 'Successfully logged out',
        ]);
    }

    public function refresh()
    {
        return response()->json([
            'status' => 'success',
            'user' => Auth::user(),
            'authorization' => [
                'token' => Auth::refresh(),
                'type' => 'bearer',
            ],
        ]);
    }
    public function getPhoto(Request $request)
    {
        $user = User::find($request->userId);
        $imagePath = $user->image->getImagePath();
        return $imagePath;
    }
}
