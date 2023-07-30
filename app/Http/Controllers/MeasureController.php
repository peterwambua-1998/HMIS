<?php

namespace App\Http\Controllers;

use App\Appointment;
use App\LabPatientMeasure;
use App\Measure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MeasureController extends Controller
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
            for ($i=0; $i < count($request->measures); $i++) { 
                $patient_measures = new LabPatientMeasure();
                $patient_measures->patient_id = $request->patient_id;
                $patient_measures->appointment_id = $request->app_id;
                $patient_measures->measure_id = $request->measures[$i];
                $patient_measures->save();
            }
            
            if ($request->doc_note) {
                $patient_measures = new LabPatientMeasure();
                $patient_measures->patient_id = $request->patient_id;
                $patient_measures->appointment_id = $request->app_id;
                $patient_measures->note = $request->doc_note;
                $patient_measures->save();
            }

            $appointment = Appointment::find($request->app_id);
            $appointment->department = $request->sendto;
            $appointment->update();
        });

        return redirect()->route('create_channel_view');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Measure  $measure
     * @return \Illuminate\Http\Response
     */
    public function show(Measure $measure)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Measure  $measure
     * @return \Illuminate\Http\Response
     */
    public function edit(Measure $measure)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Measure  $measure
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Measure $measure)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Measure  $measure
     * @return \Illuminate\Http\Response
     */
    public function destroy(Measure $measure)
    {
        //
    }
}
