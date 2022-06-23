<?php

namespace App\Http\Controllers;

use App\Models\Dartboard;
use App\Http\Requests\StoreDartboardRequest;
use App\Http\Requests\UpdateDartboardRequest;

class DartboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @param  \App\Http\Requests\StoreDartboardRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreDartboardRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Dartboard  $dartboard
     * @return \Illuminate\Http\Response
     */
    public function show(Dartboard $dartboard)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Dartboard  $dartboard
     * @return \Illuminate\Http\Response
     */
    public function edit(Dartboard $dartboard)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateDartboardRequest  $request
     * @param  \App\Models\Dartboard  $dartboard
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateDartboardRequest $request, Dartboard $dartboard)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Dartboard  $dartboard
     * @return \Illuminate\Http\Response
     */
    public function destroy(Dartboard $dartboard)
    {
        //
    }
}
