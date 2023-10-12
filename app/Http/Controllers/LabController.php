<?php

namespace App\Http\Controllers;

use App\Account;
use App\Appointment;
use App\Billing;
use App\Lab;
use App\LabMeasure;
use App\LabMeasureResult;
use App\LabPatientMeasure;
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
        DB::transaction(function() use($request){
            $service = new PatentAppointmentService();

            for ($i=0; $i < count($request->measure_id); $i++) { 
                $measure_result = new LabMeasureResult();
                $measure_result->appointment_id = $request->appointment_id;
                $measure_result->patient_id = $request->patient_id;
                $measure_result->measure_id = $request->measure_id[$i];
                $measure_result->result = $request->measures[$i];
                $measure_result->save();

                $measure_name = LabMeasure::where('id','=',$request->measure_id[$i])->first()->measure_name;
                $service->service = $measure_name;
            }

            $appointment = Appointment::find($request->appointment_id);
            if ($appointment->admit == 'YES') {
                $appointment->department = 'ward';
            } else {
                $doc = User::where('id','=', $appointment->doctor_id)->first();
                if ($doc->user_type == 'doctor_physiotherapy') {
                    $appointment->department = 'physiotherapy';
                }

                if ($doc->user_type == 'doctor_consultation') {
                    $appointment->department = 'consultation';
                }

                if ($doc->user_type == 'doctor_dentist') {
                    $appointment->department = 'dentist';
                }
            }
            $appointment->update();

            
            $service->patient_id = $request->patient_id;
            $service->appointment_id = $request->appointment_id;
            $service->department = 'lab';
           
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
        $measures = LabPatientMeasure::where('appointment_id', '=', $appointment->id)->where('patient_id','=',$result->id)->get();
        $docname = User::where('id', '=', $appointment->doctor_id)->first();

        if ($measures->isEmpty()) {
            return redirect()->back()->with('unsuccess','Patient has not been sent to lab');
        }

        $note = null;

        $lab_history = Appointment::where('patient_id','=', $request->patient_id)->where('id','!=', $appointment->id)->get();
        foreach ($lab_history as $key => $history) {
            $lab_measure_results = LabMeasureResult::where('appointment_id','=', $history->id)->get();
            if ($lab_measure_results->isNotEmpty()) {
                $history->lab_measure_results = $lab_measure_results;
            } else {
                $history->lab_measure_results = null;
            }
        }

        foreach ($measures as $key => $measure) {
            if ($measure->measure_id) {
                $measure_name = LabMeasure::where('id','=',$measure->measure_id)->first();
                $measure->measure_name = $measure_name->measure_name;
                $measure->unit = $measure_name->unit_of_measurement;
            }

            if ($measure->measure_id == 0 && $measure->note) {
                $note = $measure->note;
            }
        }

        return view('lab.labview')->with([
            "title" => "Search Results", 
            "search_result" => $result, 
            'appointment' => $appointment, 
            'measures' => $measures, 
            'docs' => $docname,
            'note' => $note,
            'lab_history' => $lab_history
        ]);
        
    }

    public function measureList()
    {
        $lab_measures = LabMeasure::all();
        return view('lab.measure_list', compact('lab_measures'));
    }

    public function addMeasurePage()
    {
        $title = "add test";
        return view('lab.create_measures', compact('title'));
    }

    public function saveMeasure(Request $request)
    {
        $lab_measure = new LabMeasure();
        $lab_measure->measure_name = $request->measure;
        $lab_measure->unit_of_measurement = $request->unit;
        $lab_measure->price = $request->price;
        if ($lab_measure->save()) {
            return redirect()->route('labMeasure')->with('success','Record stored successfully');
        }
        return redirect()->route('labMeasure')->with('unsuccess','System error please try again');
    }

    public function editMeasure($id)
    {
        $title = 'Edit Lab Measure';
        $lab_measure = LabMeasure::find($id);
        return view('lab.measure_edit', compact('lab_measure', 'title'));
    }

    public function updateMeasure(Request $request)
    {
        $lab_measure = LabMeasure::find($request->lab_measure_id);
        $lab_measure->measure_name = $request->measure;
        $lab_measure->unit_of_measurement = $request->unit;
        $lab_measure->price = $request->price;
        if ($lab_measure->update()) {
            return redirect()->route('labMeasure')->with('success','Record stored successfully');
        }
        return redirect()->route('labMeasure')->with('unsuccess','System error please try again');
    }
}
