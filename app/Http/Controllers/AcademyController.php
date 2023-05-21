<?php

namespace App\Http\Controllers;

use App\Models\Academy;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class AcademyController extends Controller
{
    public function index(Request $request)
    {
        $searchTerm = $request->input('name');
        $academies = Academy::likeName($searchTerm)->get();
        return $academies;
        
    }

    public function create()
    {
        //
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|min:3|max:100|regex:/^[A-Za-z][A-Za-z\s]*$/',
            'email' => 'required|email|unique:academies',
            'phone' => 'required|unique:academies|regex:/^\+\d{10,12}$/',
            'image' => 'image|mimes:jpeg,png,jpg,gif,bmp|max:1024|nullable',
            'location' => 'required|string|max:255|nullable',
            'rating' => 'required|numeric|min:1|max:5|nullable',
        ]);
        $academy = Academy::create($request->all());
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $image->store('public');
            $academy->image()->create([
                'path' => $image->hashName(),
            ]);
        }

        User::where('id', $request->user_id)->update([
            'current_academy_id' => $academy->id,
        ]);
        return response()->json([
            'message' => 'academy added successfully',
        ]);
    }

    public function show($name)
    {
        $academy = Academy::where('name', $name)->first();
        return $academy;
    }

    public function edit(Academy $academy)
    {
        //
    }

    public function update(Request $request, Academy $academy)
    {
        //
    }

    public function destroy($id)
    {
        $academy = Academy::findOrFail($id);
        $academy->delete();

        return response()->json([
            'message' => 'Academy deleted successfully.',
            'status' => 'success',
            'data' => null,
        ], 200);
    }
    public function getPhoto(Request $request)
    {
        $academy = Academy::find($request->academyId);
        return $academy->image->getImagePath();
    }
    public function getAcademyDetails(Request $request)
    {
        $academy = Academy::find($request->academyId);
        return response()->json([
            'name' => $academy->name,
            'location' => $academy->location,
            'trainers' => $academy->trainers()->count(),
            'players' => $academy->players()->count(),
            'rating' => $academy->rating,
        ]);
    }
    public function getAllAcademyDetails()
    {
        $academies = DB::table('academies')
            ->select('name', 'location','trainers_count','players_count','rating')
            ->get();
            return $academies;
    }
}
