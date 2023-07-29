<?php

namespace App\Http\Controllers;

use App\Appointment;
use App\TheatreMeasure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TheatreMeasureController extends Controller
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        DB::transaction(function () use ($request) {
            $measure = new TheatreMeasure();

            $measure->patient_id  = $request->patient_id;
            $measure->appointment_id = $request->app_id;
            $measure->measrure_1 = $request->operation_procedure;
            $measure->surgon = $request->surgon;
            $measure->start_time = $request->start_time;
            $measure->note = $request->theatre_note;
            $measure->room  = $request->theatre_room;

            $measure->save();


            $appointmnet = Appointment::where('id', '=', $request->app_id)->get()->last();

            $appointmnet->department = 'theatre';

            $appointmnet->save();

        });
        

        return redirect()->route('inpatientqueue');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\TheatreMeasure  $theatreMeasure
     * @return \Illuminate\Http\Response
     */
    public function show(TheatreMeasure $theatreMeasure)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\TheatreMeasure  $theatreMeasure
     * @return \Illuminate\Http\Response
     */
    public function edit(TheatreMeasure $theatreMeasure)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\TheatreMeasure  $theatreMeasure
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TheatreMeasure $theatreMeasure)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\TheatreMeasure  $theatreMeasure
     * @return \Illuminate\Http\Response
     */
    public function destroy(TheatreMeasure $theatreMeasure)
    {
        //
    }
}
