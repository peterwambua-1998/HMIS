<?php

namespace App\Http\Controllers;

use App\Appointment;
use App\Billing;
use App\Measureradiology;
use App\Patients;
use App\Radiologyimaging;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RadiologyimagingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('radiologyimaging.search');
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
            $radiology = new Radiologyimaging();

            if ($request->ct_Scan !== null) {
                $radiology->ct_scan = $request->ct_Scan;
            }

            if ($request->x_ray !== null) {
                $radiology->x_ray = $request->x_ray;
                $radiology->reasion_for_exam = $request->reason_for_exam;
                $radiology->technique = $request->technique;
                $radiology->findings = $request->findings;
            }

            if ($request->ultra_sound !== null) {
                $radiology->ultra_sound = $request->ultra_sound;
            }

            if ($request->mri !== null) {
                $radiology->mri = $request->mri;
            }

            /*
            if ($request->mri !== null) {
                $radiology->mri = $request->mri;
            }
            */



            $radiology->appointment_id = $request->appointment_id;
            $radiology->patient_id = $request->patient_id;

            $filePath = '';

            if ($request->hasFile('image_radiology')) {
                $filePath = $request->file('image_radiology')->store('imaging-radiology', 'public');
            }

            $radiology->save();

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
            

            $appointment = Appointment::find($request->appointment_id);
            

            if ($appointment->admit == 'YES') {
                $appointment->department = 'ward';
            } else {
                $appointment->department = 'consultation';
                
            }
            
            //$appointment->doctor_id = $request->docname;
            $appointment->update();

        });

        return redirect()->route('searchRadiology');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Radiologyimaging  $radiologyimaging
     * @return \Illuminate\Http\Response
     */
    public function show(Radiologyimaging $radiologyimaging)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Radiologyimaging  $radiologyimaging
     * @return \Illuminate\Http\Response
     */
    public function edit(Radiologyimaging $radiologyimaging)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Radiologyimaging  $radiologyimaging
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Radiologyimaging $radiologyimaging)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Radiologyimaging  $radiologyimaging
     * @return \Illuminate\Http\Response
     */
    public function destroy(Radiologyimaging $radiologyimaging)
    {
        
    }

    public function search(Request $request)
    {
        
        if ($request->cat == "name") {
            $results = Patients::withTrashed()->where('name', 'LIKE', '%' . $request->keyword . '%')->get();
            foreach ($results as $key => $patient) {
                $appointment =  Appointment::where('patient_id', $patient->id)->get()->last();
                $patient->appointment = $appointment;
            }
        }
        if ($request->cat == "nic") {
            $result = Patients::withTrashed()->where('nic', 'LIKE', '%' . $request->keyword . '%')->get();
            $radiology = Radiologyimaging::where('patient_id', '=', $result[0]->id)->get();
            $appointment = Appointment::where('patient_id', '=', $result[0]->id)->get()->last();

        }
        if ($request->cat == 'patient_id')  {
            $result = Patients::withTrashed()->where('id', '=', $request->keyword)->get();

            if(count($result) == 0) {
                return redirect()->back()->withError('Enter Valid Patient Number');    
            }
            
            
            $radiology = Radiologyimaging::where('patient_id', '=', $result[0]->id)->get();

            $appointment = Appointment::where('patient_id', '=', $result[0]->id)->get()->last();

            $measure = Measureradiology::where('appointment_id', '=', $appointment->id)->where('patient_id','=',$result[0]->id)->get()->last();

            $docname = User::where('id', '=', $appointment->doctor_id)->first();
            
        }
        return response($results);
        //return view('radiologyimaging.radiologyview', ["title" => "Search Results", "search_result" => $result, 'radiology' => $radiology, 'appointment' => $appointment, 'measure' => $measure, 'docs'=>$docname]);
    }

    public function startRadiology(Request $request)
    {
        $result = Patients::find($request->patient_id);
        $radiology = Radiologyimaging::where('patient_id', '=', $result->id)->get();
        $appointment = Appointment::where('patient_id', '=', $result->id)->get()->last();
        $measure = Measureradiology::where('appointment_id', '=', $appointment->id)->where('patient_id','=',$result->id)->get()->last();
        $docname = User::where('id', '=', $appointment->doctor_id)->first();
        return view('radiologyimaging.radiologyview', ["title" => "Search Results", "search_result" => $result, 'radiology' => $radiology, 'appointment' => $appointment, 'measure' => $measure, 'docs'=>$docname]);
    }
}
