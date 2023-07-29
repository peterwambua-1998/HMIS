<?php

namespace App\Http\Controllers;

use App\Appointment;
use App\Billing;
use App\Dialysis;
use App\DialysisMeasure;
use App\Patients;
use App\Triage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DialysisController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('dialysis.search');
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
        DB::transaction(function() use($request){
            $dialysis = new Dialysis();

            $dialysis->patient_id  = $request->patient_id;
            $dialysis->appointment_id  = $request->appointment_id;
            $dialysis->post_bp  = $request->post_bp;
            $dialysis->post_weight  = $request->post_weight;
            $dialysis->post_temp  = $request->post_temp;
            $dialysis->blood_transfusion_done  = $request->transfusion_done;
            $dialysis->blood_bags  = $request->num_of_bag_blood;
            $dialysis->start_time  = $request->start_time;
            $dialysis->end_time  = $request->end_time;
            $dialysis->doc_start  = $request->doc_start;
            $dialysis->doc_end  = $request->doc_end;
            $dialysis->dialyzer_type  = $request->dialyzer_type;
            $dialysis->bed_no  = $request->bed_no;
            $dialysis->machine_no  = $request->machine_no;
            $dialysis->summary  = $request->summary;


            $triage = new Triage();
            $triage->patient_id = $request->patient_id;
            $triage->weight = $request->weight;
            $triage->temp = $request->temp;
            $triage->blood_pressure = $request->blood_pressure;
            $triage->history = $request->history;
            $triage->save();

    
            $dialysis->save();

            /*
            $billing = new Billing();
            $billing->patient_id = $request->patient_id;
            $billing->appointment_id = $request->appointment_id;
            $billing->billing_for = $request->billing_for;
            $billing->amount = $request->amount;
            $billing->completed = $request->completed;
            $billing->payment_method = $request->payment_method;
            $billing->save();
            */


        });
        

        return redirect()->route('searchDialysis')->with('success_message', 'Dialysis Completed Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Dialysis  $dialysis
     * @return \Illuminate\Http\Response
     */
    public function show(Dialysis $dialysis)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Dialysis  $dialysis
     * @return \Illuminate\Http\Response
     */
    public function edit(Dialysis $dialysis)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Dialysis  $dialysis
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Dialysis $dialysis)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Dialysis  $dialysis
     * @return \Illuminate\Http\Response
     */
    public function destroy(Dialysis $dialysis)
    {
        //
    }

    public function search(Request $request)
    {
        
        if ($request->cat == "name") {
            $result = Patients::withTrashed()->where('name', 'LIKE', '%' . $request->keyword . '%')->get();
            $dialysis = Dialysis::where('patient_id', '=', $result[0]->id)->get();
            $appointment = Appointment::where('patient_id', '=', $result[0]->id)->get()->last();
        }
        if ($request->cat == "nic") {
            $result = Patients::withTrashed()->where('nic', 'LIKE', '%' . $request->keyword . '%')->get();
            $dialysis = Dialysis::where('patient_id', '=', $result[0]->id)->get();
            $appointment = Appointment::where('patient_id', '=', $result[0]->id)->get()->last();

        }
        if ($request->cat == "telephone") {
            $result = Patients::withTrashed()->where('telephone', 'LIKE', '%' . $request->keyword . '%')->get();
            
            
            $dialysis = Dialysis::where('patient_id', '=', $result[0]->id)->get();
            $appointment = Appointment::where('patient_id', '=', $result[0]->id)->get()->last();
        }

        if ($request->cat == 'patient_id') {
            $result = Patients::withTrashed()->where('id', '=', $request->keyword)->get();

            if ($result == null) {
                return redirect()->back()->withErrors('No Patient Found');
            };

            $dialysis = Dialysis::where('patient_id', '=', $result[0]->id)->get();

            $appointment = Appointment::where('patient_id', '=', $result[0]->id)->get()->last();

            $dialysisMeasures = DialysisMeasure::where('appointment_id', '=', $appointment->id)->where('patient_id', '=', $result[0]->id)->get()->last();
        }
        return view('dialysis.dislysisview', ["title" => "Search Results", "search_result" => $result, 'dialysis' => $dialysis, 'appointment' => $appointment, 'measure' => $dialysisMeasures]);
    }


    public function intro(Request $request)
    {
        DB::transaction(function () use ($request) {
            $preDialysis = new DialysisMeasure();

            $preDialysis->pre_bp = $request->pre_bp;
            $preDialysis->pre_weight = $request->pre_weight;
            $preDialysis->pre_temp = $request->pre_temp;
            $preDialysis->renal_failure = $request->renal_failure;
            $preDialysis->blood_group = $request->blood_group;
            $preDialysis->start_time = $request->start_time;
            $preDialysis->doc_incharge = $request->doc_incharge;
            $preDialysis->approved_by = $request->approved_by;
            $preDialysis->diagnosis = $request->diagnosis;
            $preDialysis->note = $request->note;
            $preDialysis->patient_id = $request->patient_id;
            $preDialysis->appointment_id = $request->app_id;
            $preDialysis->save();


            $appointment = Appointment::where('id', '=', $request->app_id)->get()->last();

            $appointment->department = 'dialysis';

            $appointment->save();
        });
        

        return redirect()->route('inpatientqueue');
    }
}
