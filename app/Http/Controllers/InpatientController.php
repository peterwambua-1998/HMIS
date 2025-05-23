<?php

namespace App\Http\Controllers;

use App\Appointment;
use App\Billing;
use App\Clinic;
use App\Dialysis;
use App\DoctorNote;
use App\inpatient;
use App\Lab;
use App\Medicine;
use App\Patients;
use App\Prescription;
use App\Prescription_Medicine;
use App\Radiologyimaging;
use App\Theatre;
use App\Triage;
use App\Ward;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use stdClass;

class InpatientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $user = Auth::user();
        return view('inpatient.searchinpatient', ['title' => "Check In Patient"]);

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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        
        $inpatient = inpatient::where('patient_id', '=', $id)->where('appointment_id', '=', $request->appointment_id)->get()->last();

        
        $wards = Ward::all();

        //dd($inpatient);

        return view('inpatient.edit')->with(['inpatient'=> $inpatient, 'wards' => $wards]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        DB::transaction(function () use ($request, $id) {
            $inpatient = inpatient::where('patient_id', '=', $id)->where('appointment_id', '=', $request->appointment_id)->get()->last();

            $inpatient->ward_id = $request->ward_id;
            $inpatient->bed_no = $request->bed_no;

            $inpatient->save();
        });
        

        return redirect()->route('inpatientqueue');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function validateAppNum(Request $request)
    {
        $num = $request->number;
        $numlength = strlen((string) $num);
         //this means the patient registration number has entered
            $rec = DB::table('appointments')->join('patients', 'appointments.patient_id', '=', 'patients.id')->select('patients.name as name', 'appointments.number as num', 'appointments.patient_id as pnum', 'appointments.id as appId')->whereRaw(DB::Raw("appointments.patient_id='$num'"))->get()->last();
            if ($rec) {
                return response()->json([
                    "exist" => true,
                    "name" => $rec->name,
                    "appNum" => $rec->num,
                    "pNum" => $rec->pnum,
                    'appId' => $rec->appId,
                ]);
            } else {
                return response()->json([
                    "exist" => false,
                ]);
            }
        
    }


    public function search(Request $request)
    {
        $inpatients = inpatient::where('patient_id', '=', $request->patient_name)->first();

        if($inpatients == null) {
            return redirect()->back()->withError('No patient found. Please try again'); 
        }


        $patient = Patients::where('id', '=', $request->patient_name)->first();


        if($patient == null) {
            return redirect()->back()->withError('No patient found. Please try again'); 
        }

        $appointment = Appointment::where('patient_id', '=', $inpatients->id)->get()->last();


        return redirect()->back()->with(['inpatients' => $inpatients, 'app' => $appointment, 'patient' => $patient]);
    }


    public function inpatientQueue()
    {
        $user = Auth::user();

        

        if ($user->user_type == 'nurse') {
            //$inpatient = $inpatient  
            $ward = Ward::where('nurse_incharge', '=', $user->id)->first();

            $inpatient = inpatient::where('discharged', 'LIKE', '%'.'NO'. '%')
                            ->where('ward_id', '=', $ward->id)
                            ->get();
        } else {
            $inpatient = inpatient::where('discharged', 'LIKE', '%'.'NO'. '%')->get();
        }

        //dd($appointments);

        return view('inpatient.inpatient_queue')->with('inpatient_appointments', $inpatient);
    }


    public function checkPatient(Request $request)
    {

        //dd($request->pid);
        //to get the latest appointment number for the day
        //apa kuna where clause where('created_at', '>=', date('Y-m-d') . ' 00:00:00')->
        $appointment = Appointment::where('id', $request->appNum)->where('patient_id', $request->pid)->get()->last();

        //dd($appointment);

        //dd($appointment);
        if ($appointment->completed == "YES") {
            return redirect()->route('check_patient_view')->with('fail', "This Appointment Has Already Been Completed.");
        }

        $patient = Patients::find($appointment->patient_id);

        $inpatient = inpatient::where('patient_id', '=', $patient->id)->get()->last();

        $bedNumber = $inpatient->bed_no;

        //department
        $department = $appointment->department;


        $user = Auth::user();

        //need to get the latest issued prescription to fetch the patient bp,sugar,cholestrol to be displayed in the checkpatient
        $prescriptions = Prescription::where('patient_id', $appointment->patient_id)->orderBy('created_at', 'DESC')->get();


        $data = DB::table('wards')
                    ->select('*')
                    ->join('users', 'wards.doctor_id', '=', 'users.id')
                    ->get();

        
        //creates thress objects to store these data
        //sometimes thses may get blank so use the flag to resolve this issue if flag is false these will not be displayed in the view
        /*
        $pBloodPressure = new stdClass;
        $pBloodPressure->flag = false;

        $pBloodSugar = new stdClass;
        $pBloodSugar->flag = false;

        $pCholestrol = new stdClass;
        $pCholestrol->flag = false;
        

        foreach ($prescriptions as $prescription) {

            if (!$pBloodPressure->flag == true) {
                $bp = json_decode($prescription->bp)->value;
                if ($bp != null) {
                    $pBloodPressure->sys = explode("/", $bp)[0];
                    $pBloodPressure->dia = explode("/", $bp)[0];
                    $pBloodPressure->date = json_decode($prescription->bp)->updated;
                    $pBloodPressure->flag = true;

                }
            }

            if (!$pCholestrol->flag == true) {
                $cholestrol = json_decode($prescription->cholestrol)->value;
                if ($cholestrol != null) {
                    $pCholestrol->value = $cholestrol;
                    $pCholestrol->date = json_decode($prescription->cholestrol)->updated;
                    $pCholestrol->flag = true;
                }
            }

            if (!$pBloodSugar->flag == true) {
                $sugar = json_decode($prescription->blood_sugar)->value;
                if ($sugar != null) {
                    $pBloodSugar->value = $sugar;
                    $pBloodSugar->date = json_decode($prescription->blood_sugar)->updated;
                    $pBloodSugar->flag = true;
                }
            }

        }

        */

        $updated = "No Previous Visits";
        if ($prescriptions->count() > 0) {
            $updated = explode(" ", $prescriptions[0]->created_at)[0];
        }
        // $updated = explode(" ", $prescriptions[0]->created_at)[0];

        $pHistory = new stdClass;

        $assinged_clinics = Patients::find($request->pid)->clinics;

        $clinics = Clinic::all();


        $triage = Triage::where('patient_id', '=', $patient->id)->get()->last();

        $lab = Lab::where('patient_id', '=', $patient->id)->where('appointment_id', '=', $appointment->id)->get()->last();

        $dialysis = Dialysis::where('patient_id', '=', $patient->id)->get()->last();

        $medicines = Medicine::where('qty', '>', 0)->get();

        $imaging_radiology = Radiologyimaging::where('patient_id', '=', $patient->id)->where('appointment_id', '=', $appointment->id)->get()->last();

        $theatre = Theatre::where('patient_id', '=', $patient->id)->get()->last();

        //medicines
        $prescriptions = Prescription::where('patient_id', '=', $patient->id)->where('appointment_id', '=', $appointment->id)->get()->last();

        //dd($prescriptions);

        if ($prescriptions !== null) {
            $patient_medicines = Prescription_Medicine::where('prescription_id', '=', $prescriptions->id)->get();

            //dd($patient_medicines);
        } else {
            $patient_medicines= null;
        }
        
        

        $patient_ward = Ward::where('id', '=', $inpatient->ward_id)->first();

        $wards = Ward::all();
        
        //dd($medicines);

        return view('inpatient.check_in_patient', [
            'title' => "Check Patient",
            'appNum' => $request->appNum,
            'department' => $appointment->department,
            'appID' => $appointment->id,
            'pName' => $appointment->patient->name,
            'pSex' => $appointment->patient->sex,
            'pAge' => $patient->getAge(),
            //'pCholestrol' => $pCholestrol,
            //'pBloodSugar' => $pBloodSugar,
            //'pBloodPressure' => $pBloodPressure,
            // 'pHistory' => $pHistory,
            'inpatient' => $appointment->admit,
            'pid' => $appointment->patient->id,
            'medicines' => $medicines,
            'updated' => $updated,
            'assinged_clinics' => $assinged_clinics,
            'clinics' => $clinics,
            
            'triage' => $triage,
            'lab' => $lab,
            'dialysis' => $dialysis,
            'imaging_radiology' => $imaging_radiology,
            'user' => $user,
            'theatre' => $theatre,
            'user' => $user,
            'patient' => $patient,
            'data' => $data,
            'patient_medicines' => $patient_medicines,
            'patient_ward' => $patient_ward,
            'bedNumber' => $bedNumber,
            'wards' => $wards,
        ]);
    }

    public function checkInpatientSave(Request $request)
    {

        $find_prescription = Prescription::where('appointment_id', '=', $request->appointment_id)
                             ->where('patient_id', '=', $request->patient_id)->first();

        

            
        DB::transaction(function () use ($request, $find_prescription) {
            $user = Auth::user();

            if ($find_prescription == null) {
                $presc = new Prescription;
                $presc->doctor_id = $user->id;
                $presc->patient_id = $request->patient_id;
                $presc->diagnosis = 'diagnosis';
                $presc->appointment_id = $request->appointment_id;

                $presc->medicines = json_encode($request->medicines);

                $presc->save();


                foreach ($request->medicines as $medicine) {
                    $med = Medicine::where('name_english', strtolower($medicine['name']))->first();
                    $pres_med = new Prescription_Medicine();
                    $pres_med->medicine_id = $med->id;
                    $pres_med->prescription_id = $presc->id;
                    $pres_med->note = $medicine['note'];
                    $pres_med->save();
                }
            } else {
                $presc = Prescription::where('appointment_id', '=', $request->appointment_id)
                ->where('patient_id', '=', $request->patient_id)->first();

                
                
                $decode_medicines = json_decode($presc->medicines);

                


                $extra_medicine = $request->medicines;

                

                array_push($decode_medicines, $extra_medicine);

                $updatedMed = json_encode($decode_medicines);

                //dd($updatedMed);

                $presc->medicines = $updatedMed;

                $presc->save();


                foreach ($request->medicines as $medicine) {
                    $med = Medicine::where('name_english', strtolower($medicine['name']))->first();
                    $pres_med = new Prescription_Medicine();
                    $pres_med->medicine_id = $med->id;
                    $pres_med->prescription_id = $presc->id;
                    $pres_med->note = $medicine['note'];
                    $pres_med->save();
                }
            }
            
            

            $appointment = Appointment::find($request->appointment_id);
            $appointment->completed = $request->completed;
            $appointment->doctor_id = $appointment->doctor_id;
            $appointment->save();


            $inpatient = inpatient::where('patient_id', '=', $request->patient_id)->get()->last();


            $doc_note = new DoctorNote();
            $doc_note->user_id = $user->id;
            $doc_note->appointment_id = $appointment->id;
            $doc_note->patient_id = $request->patient_id;
            $doc_note->note = $request->note;
            $doc_note->save();



            

            //billing
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
        

        return http_response_code(200);
    }


    public function sendToTriage(Request $request)
    {
        //$inpatient = inpatient::where()

        $appointment = Appointment::where('patient_id', '=', $request->patient_id)->where('id', '=', $request->appointment_id)->get()->last();

        $appointment->department = 'triage';

        $appointment->save();

        return http_response_code(200);
    }

    public function sendToPhysiotheray(Request $request)
    {
        //$inpatient = inpatient::where()

        $appointment = Appointment::where('patient_id', '=', $request->patient_id)->where('id', '=', $request->appointment_id)->get()->last();

        $appointment->department = 'physiotherapy';

        $appointment->save();

        return http_response_code(200);
    }


}
