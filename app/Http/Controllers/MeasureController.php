<?php

namespace App\Http\Controllers;

use App\Appointment;
use App\CashierQueue;
use App\LabPatientMeasure;
use App\Measure;
use App\Radiologymeasure;
use App\Surgery;
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
     * Stores lab measures
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (! $request->measures) {
            return redirect()->back()->with('unsuccess','Kindly check tests for patient.');
        }
        
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

            //add to cashier queue;
            $cashierQueue = new CashierQueue();
            $cashierQueue->appointment_id = $request->app_id;
            $cashierQueue->patient_id = $request->patient_id;
            $cashierQueue->department = 'lab';
            $cashierQueue->reason = 'lab';
            $cashierQueue->save();
        });

        return redirect()->route('create_channel_view')->with('success', 'Patient sent to lab');
    }

    /**
     * Store a newly created resource in storage.
     * Stores patient radiology measures
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeRadiology(Request $request)
    {
        if (! $request->measures) {
            return redirect()->back()->with('unsuccess','Kindly check tests for patient.');
        }

        DB::transaction(function () use ($request) {
            for ($i=0; $i < count($request->measures); $i++) { 
                $patient_measures = new Radiologymeasure();
                $patient_measures->patient_id = $request->patient_id;
                $patient_measures->appointment_id = $request->app_id;
                $patient_measures->measure_id = $request->measures[$i];
                $patient_measures->save();
            }
            
            if ($request->doc_note) {
                $patient_measures = new Radiologymeasure();
                $patient_measures->patient_id = $request->patient_id;
                $patient_measures->appointment_id = $request->app_id;
                $patient_measures->note = $request->doc_note;
                $patient_measures->save();
            }

            $appointment = Appointment::find($request->app_id);
            $appointment->department = $request->sendto;
            $appointment->update();
        });

        return redirect()->route('create_channel_view')->with('success', 'Patient sent to radiology');
    }

    /**
     * Store a newly created resource in storage.
     * Stores patient radiology measures
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeSurgery(Request $request)
    {
        if (! $request->measures) {
            return redirect()->back()->with('unsuccess','Kindly check tests for patient.');
        }

        DB::transaction(function () use ($request) {
            for ($i=0; $i < count($request->measures); $i++) { 
                $patient_measures = new Surgery();
                $patient_measures->patient_id = $request->patient_id;
                $patient_measures->appointment_id = $request->app_id;
                $patient_measures->measure_id = $request->measures[$i];
                $patient_measures->save();
            }
            
            if ($request->doc_note) {
                $patient_measures = new Surgery();
                $patient_measures->patient_id = $request->patient_id;
                $patient_measures->appointment_id = $request->app_id;
                $patient_measures->note = $request->doc_note;
                $patient_measures->save();
            }

            $appointment = Appointment::find($request->app_id);
            $appointment->department = $request->sendto;
            $appointment->update();
        });

        return redirect()->route('create_channel_view')->with('success', 'Patient sent to surgery');
    }
}
