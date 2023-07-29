<?php

namespace App\Http\Controllers;

use App\Account;
use App\Appointment;
use App\Billing;
use App\Lab;
use App\Measure;
use App\PatentAppointmentService;
use App\Patients;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use stdClass;

class LabController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('lab.search');
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
        //dd($request->activatedpartialthromboplastin);
        DB::transaction(function() use($request){
            $lab = new Lab();
            $lab->whitebooldcells = $request->whitebooldcells;
            $lab->redbooldcells = $request->redbooldcells;
            $lab->prothrombintime = $request->prothrombintime;
            $lab->activatedpartialthromboplastin = $request->activatedpartialthromboplastin;
            $lab->aspartateaminotransferase = $request->aspartateaminotransferase;
            $lab->alanineaminotransferase = $request->alanineaminotransferase;
            $lab->mlactatedehydrogenase = $request->mlactatedehydrogenase;
            $lab->bloodureanitrogen = $request->bloodureanitrogen;
            $lab->WBCcountWdifferential = $request->WBCcountWdifferential;
            $lab->Quantitativeimmunoglobulin = $request->Quantitativeimmunoglobulin;
            $lab->Erythrocytesedimentationrate = $request->Erythrocytesedimentationrate;
            $lab->alpha_antitrypsin = $request->alpha_antitrypsin;
            $lab->Reticcount = $request->Reticcount;
            $lab->arterialbloodgasses = $request->arterialbloodgasses;
            $lab->appointment_id = $request->appointment_id;
            $lab->patient_id = $request->patient_id;
            $lab->save();

            $account = new Account();
            $account->patient_id = $request->patient_id;
            $account->appointment_id = $request->appointment_id;
            $account->description = $request->billing_for;
            $account->title = $request->billing_for;
            $account->amount = $request->amount;


            $appointment = Appointment::find($request->appointment_id);
            if ($appointment->admit == 'YES') {
                $appointment->department = 'ward';
            } else {
                $appointment->department = 'consultation';
            }
            $appointment->update();

            
            $measure = Measure::where('appointment_id', '=', $request->appointment_id)->where('patient_id','=',$request->patient_id)->get()->last();

            $obj = new stdClass;
            $obj->service = 'lab';


            $service = new PatentAppointmentService();
            $service->patient_id = $request->patient_id;
            $service->appointment_id = $request->appointment_id;
            $service->service = json_encode($obj);
            $service->save();


        });
        

        return redirect()->route('searchLab');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Lab  $lab
     * @return \Illuminate\Http\Response
     */
    public function show(Lab $lab)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Lab  $lab
     * @return \Illuminate\Http\Response
     */
    public function edit(Lab $lab)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Lab  $lab
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Lab $lab)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Lab  $lab
     * @return \Illuminate\Http\Response
     */
    public function destroy(Lab $lab)
    {
        //
    }

    public function search(Request $request)
    {
        
        if ($request->cat == "name") {
            $result = Patients::withTrashed()->where('name', 'LIKE', '%' . $request->keyword . '%')->get();

            foreach ($result as $key => $patient) {
                $appointment =  Appointment::where('patient_id', $patient->id)->get()->last();
                $patient->appointment = $appointment;
            }
          
        }
        if ($request->cat == "nic") {
            $result = Patients::withTrashed()->where('nic', 'LIKE', '%' . $request->keyword . '%')->get();
            $triage = Lab::where('patient_id', '=', $result[0]->id)->get();
            $appointment = Appointment::where('patient_id', '=', $result[0]->id)->get()->last();

            $measure = Measure::where('appointment_id', '=', $appointment->id)->where('patient_id','=',$result[0]->id)->get();

        }
        if ($request->cat == "telephone") {
            $result = Patients::withTrashed()->where('telephone', 'LIKE', '%' . $request->keyword . '%')->get();
            
            
            $triage = Lab::where('patient_id', '=', $result[0]->id)->get();

            $appointment = Appointment::where('patient_id', '=', $result[0]->id)->get()->last();

            $measure = Measure::where('appointment_id', '=', $appointment->id)->where('patient_id','=',$result[0]->id)->get();
        }

        if ($request->cat == 'patient_id') {
            $result = Patients::withTrashed()->where('id', '=', $request->keyword)->get();
            if(count($result) == 0) {
                return redirect()->back()->withError('Enter Valid Patient Number');    
            }
            
            $triage = Lab::where('patient_id', '=', $result[0]->id)->get();

            $appointment = Appointment::where('patient_id', '=', $result[0]->id)->get()->last();

            $measure = Measure::where('appointment_id', '=', $appointment->id)->where('patient_id','=',$result[0]->id)->get()->last();

            //dd($measure);
            $docname = User::where('id', '=', $appointment->doctor_id)->first();

            if (!$measure) {
                return redirect()->back()->with('unsuccess','Patient has not been sent to lab');
            }
        }
        return response($result);
    }

    public function startLab(Request $request)
    {
        $result = Patients::find($request->patient_id);
        $triage = Lab::where('patient_id', '=', $result->id)->get();
        $appointment = Appointment::where('patient_id', '=', $result->id)->get()->last();
        $measure = Measure::where('appointment_id', '=', $appointment->id)->where('patient_id','=',$result->id)->get()->last();
        $docname = User::where('id', '=', $appointment->doctor_id)->first();

        if (!$measure) {
            return redirect()->back()->with('unsuccess','Patient has not been sent to lab');
        }

        return view('lab.labview')->with([
            "title" => "Search Results", 
            "search_result" => $result, 
            'appointment' => $appointment, 
            'measure' => $measure, 
            'docs' => $docname
        ]);
        
    }
}
