<?php

namespace App\Http\Controllers;

use App\Events\TrainerAddedToAcademy;
use App\Models\Academy;
use App\Models\Trainer;
use Illuminate\Http\Request;

class TrainerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $searchTerm = $request->input('name');
        $trainers = Trainer::likeName($searchTerm)->get();
        return $trainers;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|min:3',
            'status' => 'required|string',
            'level_of_training' => 'required|string',
        ]);
        $trainer = Trainer::create($request->all());
        $academy = Academy::find($request->academy_id);

        $academy->update([
            'trainers_count' => $academy->trainers()->count(),
        ]);
        // notify for all trainers for Add trainer to academy.
        //$academy->trainers()->attach($trainer->id);
        // Dispatch the event
        //event(new TrainerAddedToAcademy($trainer, $academy));
        return $trainer;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Trainer  $trainer
     * @return \Illuminate\Http\Response
     */
    public function show($name)
    {
        $trainer = Trainer::where('name', $name)->first();
        return $trainer;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Trainer  $trainer
     * @return \Illuminate\Http\Response
     */
    public function edit(Trainer $trainer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Trainer  $trainer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Trainer $trainer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Trainer  $trainer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Trainer $trainer)
    {
        //
    }
}
