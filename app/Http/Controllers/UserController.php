<?php

namespace App\Http\Controllers;

use App\Models\Academy;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function showUserName()
    {
        $user = auth()->user();
        $userName = $user->name;
        return $userName;
    }

    public function getUserAcademies(Request $request)
    {
        $user = User::find($request->userId);
        $academies = $user->academies;
        $academies = DB::table('academies')
            ->select('name', 'phone')
            ->get();

        return $academies;
    }
    public function gitUserInformation(Request $request)
    {
        $user = User::find($request->userId);
        $imagePath = $user->image->getImagePath();
        $academy = Academy::find($user->current_academy_id);
        return response()->json([
            'user-name' => $user->name,
            'image-path' => $imagePath,
            'user-current-academy' => $academy,
        ]);
    }
    public function gitUserNamePhoto(Request $request)
    {
        $user = User::find($request->userId);
        $imagePath = $user->image->getImagePath();
        return response()->json([
            'user-name' => $user->name,
            'image-path' => $imagePath,
        ]);
    }
    public function switchAcademy(Request $request)
    {
        $user = User::find($request->userId);
        $academyId = $request->input('academyId');
        $user->update([
            'current_academy_id' => $academyId,
        ]);
        $academy = Academy::find($academyId);
        return response()->json([
            'message' => "academy switch successfully",
            'academy' => $academy,
        ]);
    }
}
