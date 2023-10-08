<?php

namespace App\Http\Controllers;

use App\Appointment;
use App\Medicine;
use App\Patients;
use App\Prescription;
use App\Prescription_Medicine;
use App\SurgaryResult;
use App\Surgery;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SurgeryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('surgery.search');
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
            for ($i=0; $i < count($request->measure_id); $i++) { 
                $radiology = new SurgaryResult();
                $radiology->appointment_id = $request->appointment_id;
                $radiology->patient_id = $request->patient_id;
                $radiology->measure_id = $request->measure_id[$i];
                $radiology->result = $request->measures_results[$i];
                $radiology->save();
            }
            $appointment = Appointment::find($request->appointment_id);
            $user = User::where('id', '=', $appointment->doctor_id)->first();
            if ($request->send_to == 'pharmacy') {
                $presc = new Prescription();
                $presc->doctor_id = $user->id;
                $presc->patient_id = $request->patient_id;
                $presc->diagnosis = $request->diagnosis;
                $presc->appointment_id = $request->appointment_id;
                $presc->medicines = json_encode($request->medicines);
                $presc->save();
                foreach ($request->medicines as $medicine) {
                    $med = Medicine::where('name_english', 'LIKE', '%'.$medicine['name'] . '%')->first();
                    $pres_med = new Prescription_Medicine();
                    $pres_med->medicine_id = $med->id;
                    $pres_med->prescription_id = $presc->id;
                    $pres_med->note = $medicine['note'];
                    $pres_med->exp_date = $med->exp_date;
                    $pres_med->save();
                }
            }
            

            if ($appointment->admit == 'YES') {
                $appointment->department = 'ward';
            } else {
                $doc = User::where('id','=', $appointment->doctor_id)->first();
                if ($request->send_to == 'consultation') {
                    if ($doc->user_type == 'doctor_consultation') {
                        $appointment->department = 'consultation';
                    }
                }

                if ($request->send_to == 'pharmacy') {
                    if ($doc->user_type == 'pharmacy') {
                        $appointment->department = 'pharmacy';
                        $appointment->completed = 'YES';
                    }
                }

                if ($request->send_to == 'physiotherapy') {
                    if ($doc->user_type == 'doctor_physiotherapy') {
                        $appointment->department = 'physiotherapy';
                    }
                }

                if ($request->send_to == 'dentist') {
                    if ($doc->user_type == 'doctor_dentist') {
                        $appointment->department = 'dentist';
                    }
                }
            }
            $appointment->update();
        });

        return response(1, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Surgery  $surgery
     * @return \Illuminate\Http\Response
     */
    public function destroy(Surgery $surgery)
    {
        //
    }

    
    public function search(Request $request)
    {
        if ($request->cat == "name") {
            $results = Patients::withTrashed()->where('name', 'LIKE', '%' . $request->keyword . '%')->get();
            foreach ($results as $key => $patient) {
                $appointment =  Appointment::where('patient_id', $patient->id)->get()->last();
                $patient->appointment = $appointment;
                $patient->measures = Surgery::where('appointment_id', '=', $appointment->id)->where('patient_id','=',$patient->id)->get();
                $patient->history = SurgaryResult::where('patient_id', '=', $patient->id)->get();
            }
        }
        // if ($request->cat == "nic") {
        //     $result = Patients::withTrashed()->where('nic', 'LIKE', '%' . $request->keyword . '%')->get();
        //     $radiology = Radiologyimaging::where('patient_id', '=', $result[0]->id)->get();
        //     $appointment = Appointment::where('patient_id', '=', $result[0]->id)->get()->last();

        // }
        if ($request->cat == 'patient_id')  {
            $result = Patients::withTrashed()->where('id', '=', $request->keyword)->get();

            if(count($result) == 0) {
                return redirect()->back()->withError('Enter Valid Patient Number');    
            }
            
            $radiology = SurgaryResult::where('patient_id', '=', $result[0]->id)->get();

            $appointment = Appointment::where('patient_id', '=', $result[0]->id)->get()->last();

            $measures = Surgery::where('appointment_id', '=', $appointment->id)->where('patient_id','=',$result->id)->get();

            //$docname = User::where('id', '=', $appointment->doctor_id)->first();
            
        }
        return response($results);
        //return view('radiologyimaging.radiologyview', ["title" => "Search Results", "search_result" => $result, 'radiology' => $radiology, 'appointment' => $appointment, 'measure' => $measure, 'docs'=>$docname]);
    }

    public function startSurgery(Request $request)
    {
        $result = Patients::find($request->patient_id);
        $history = SurgaryResult::where('patient_id', '=', $result->id)->get();
        $appointment = Appointment::where('patient_id', '=', $result->id)->get()->last();
        $measures = Surgery::where('appointment_id', '=', $appointment->id)->where('patient_id','=',$result->id)->get();
        $note = '';
        foreach ($measures as $key => $item) {
            if (!$item->measure_id && $item->note) {
                $note = $item->note;
                $measures->forget($key);
            }
        }
        $docname = User::where('id', '=', $appointment->doctor_id)->first();
        $medicines = Medicine::where('qty', '>', 0)->get();
        return view('surgery.view', ["title" => "Search Results", "search_result" => $result, 'history' => $history, 'appointment' => $appointment, 'measures' => $measures, 'docs'=>$docname, 'note' => $note,'medicines' => $medicines]);
    }
}
