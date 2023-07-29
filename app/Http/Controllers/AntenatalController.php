<?php

namespace App\Http\Controllers;

use App\Antenatal;
use App\Appointment;
use App\Billing;
use App\Clinic;
use App\Delivery;
use App\Dialysis;
use App\Http\Controllers\Redirect;
use App\inpatient;
use App\Lab;
use App\Medicine;
use App\Patients;
use App\Prescription;
use App\Prescription_Medicine;
use App\Radiologyimaging;
use App\Theatre;
use App\Triage;
use App\User;
use App\Ward;
use Carbon\Carbon;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use stdClass;

class AntenatalController extends Controller
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Antenatal  $antenatal
     * @return \Illuminate\Http\Response
     */
    public function show(Antenatal $antenatal)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Antenatal  $antenatal
     * @return \Illuminate\Http\Response
     */
    public function edit(Antenatal $antenatal)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Antenatal  $antenatal
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Antenatal $antenatal)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Antenatal  $antenatal
     * @return \Illuminate\Http\Response
     */
    public function destroy(Antenatal $antenatal)
    {
        //
    }

    public function validateAppNum(Request $request)
    {
        $num = $request->number;
        $numlength = strlen((string) $num);
         //this means the patient registration number has entered
            $rec = DB::table('appointments')->join('patients', 'appointments.patient_id', '=', 'patients.id')->select('patients.name as name', 'appointments.number as num', 'appointments.patient_id as pnum')->whereRaw(DB::Raw("appointments.patient_id='$num'"))->get()->last();
            if ($rec) {
                return response()->json([
                    "exist" => true,
                    "name" => $rec->name,
                    "appNum" => $rec->num,
                    "pNum" => $rec->pnum,
                ]);
            } else {
                return response()->json([
                    "exist" => false,
                ]);
            }
        
    }

    public function checkPatientView()
    {
        $user = Auth::user();
        return view('mertanity.antenatal.check_patient_intro', ['title' => "Check Patient"]);
    }



    public function checkPatient(Request $request)
    {

        //dd($request->pid);
        //to get the latest appointment number for the day
        //apa kuna where clause where('created_at', '>=', date('Y-m-d') . ' 00:00:00')->
        $appointment = Appointment::where('number', $request->appNum)->where('patient_id', $request->pid)->get()->last();


        //dd($appointment);

        //dd($appointment);
        if ($appointment->completed == "YES") {
            return redirect()->route('check_patient_view')->with('fail', "This Appointment Has Already Been Completed.");
        }

        $patient = Patients::find($appointment->patient_id);

        $user = Auth::user();

        //need to get the latest issued prescription to fetch the patient bp,sugar,cholestrol to be displayed in the checkpatient
        $prescriptions = Prescription::where('patient_id', $appointment->patient_id)->orderBy('created_at', 'DESC')->get();


        $data = DB::table('wards')
                    ->select('*')
                    ->join('users', 'wards.doctor_id', '=', 'users.id')
                    ->get();

        $select_doctors = User::where('user_type', 'LIKE', '%'.'doctor'.'%')->get();

        
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


        $triage = Triage::where('patient_id', '=', $patient->id)->where('created_at', 'LIKE', '%'.date('Y-m-d').'%')->get()->last();

        $lab = Lab::where('patient_id', '=', $patient->id)->where('appointment_id', '=', $appointment->id)->get()->last();

        $dialysis = Dialysis::where('patient_id', '=', $patient->id)->get()->last();

        $medicines = Medicine::where('qty', '>', 0)->get();

        $imaging_radiology = Radiologyimaging::where('patient_id', '=', $patient->id)->where('appointment_id', '=', $appointment->id)->get()->last();

        $theatre = Theatre::where('patient_id', '=', $patient->id)->get()->last();

        $antenatal = Antenatal::where('patient_id', '=', $patient->id)->get();
        

        return view('mertanity.antenatal.check_patient', [
            'title' => "Check Patient",
            'appNum' => $request->appNum,
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
            'select_doctors' => $select_doctors,
            'antenatal' => $antenatal
        ]);
    }

    public function checkPatientSave(Request $request)
    {

        //dd($request);

        DB::transaction(function() use($request) {

        
            $user = Auth::user();
            $presc = new Prescription;
            $presc->doctor_id = $user->id;
            $presc->patient_id = $request->patient_id;
            $presc->diagnosis = $request->diagnosis;
            $presc->appointment_id = $request->appointment_id;

            $presc->medicines = json_encode($request->medicines);

            /*
            $bp = new stdClass;
            $bp->value = $request->pressure;
            $bp->updated = Carbon::now()->toDateTimeString();
            $presc->bp = json_encode($bp);

            $gloucose = new stdClass;
            $gloucose->value = $request->glucose;
            $gloucose->updated = Carbon::now()->toDateTimeString();
            $presc->blood_sugar = json_encode($gloucose);

            $cholestrol = new stdClass;
            $cholestrol->value = $request->cholestrol;
            $cholestrol->updated = Carbon::now()->toDateTimeString();
            $presc->cholestrol = json_encode($cholestrol);
            */

            $presc->save();

            $appointment = Appointment::find($request->appointment_id);
            $appointment->completed = "YES";
            $appointment->doctor_id = $appointment->doctor_id;
            $appointment->save();


            if (count($request->medicines) > 0) {
                foreach ($request->medicines as $medicine) {
                    $med = Medicine::where('name_english', 'LIKE', '%'.$medicine['name'] . '%')->first();
                   
                    $pres_med = new Prescription_Medicine;
                    $pres_med->medicine_id = $med->id;
                    $pres_med->prescription_id = $presc->id;
                    $pres_med->note = $medicine['note'];
                    $pres_med->save();
                }
            }
            

            $antenatal = new Antenatal();
            $antenatal->patient_id = $request->patient_id;
            $antenatal->appointment_id = $request->appointment_id;
            $antenatal->baby_health = $request->babyhealth;
            $antenatal->doc_notes = $request->diagnosis;
            $antenatal->save();

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
            
            $appointment->department = $request->department;
            //$appointment->doctor_id = $request->docname;
            $appointment->update();
        
            // Log Activity
            //activity()->performedOn($presc)->withProperties(['Patient ID' => $request->patient_id, 'Doctor ID' => $user->id, 'Prescription ID' => $presc->id, 'Appointment ID' => $request->appointment_id, 'Medicines' => json_encode($request->medicines)])->log('Check Patient Success');
        });
        return http_response_code(200);
    }

    public function store_inpatient(Request $request)
    {

        //dd($request);
        DB::transaction(function () use ($request) {
            //dd($request->reg_pname);
            $pid = $request->reg_pid;
            $Ptable = Patients::find($pid);
            $INPtable = new inpatient;

            $Ptable->civil_status = $request->reg_ipcondition;
            $Ptable->birth_place = $request->reg_ipbirthplace;
            $Ptable->nationality = $request->reg_ipnation;
            $Ptable->religion = $request->reg_ipreligion;
            $Ptable->income = $request->reg_inpincome;
            $Ptable->guardian = $request->reg_ipguardname;
            $Ptable->guardian_address = $request->reg_ipguardaddress;

            $INPtable->patient_id = $request->reg_pid;
            $INPtable->appointment_id = $request->app_id;
            $INPtable->ward_id = $request->reg_ipwardno;
            $INPtable->bed_no = $request->bed_no;
            $INPtable->patient_inventory = $request->reg_ipinventory;
            $INPtable->patient_name = $request->reg_pname;
            $INPtable->patient_reg_no = $request->reg_pid;
            $INPtable->patientidnumber = $request->reg_pnic;



            $INPtable->house_doctor = $request->reg_iphousedoc;
            $INPtable->approved_doctor = $request->reg_ipapprovedoc;
            $INPtable->gravidae = $request->gravidae;
            $INPtable->num_of_anc_visits = $request->num_anc;
            $INPtable->last_menstrual_period = $request->last_menstrual_period;
            $INPtable->expected_date_of_delivery = $request->expected_day;
            $INPtable->certified_officer = $request->reg_admitofficer4;

            $Ptable->save();
            $INPtable->save();

            $appointment = Appointment::find($request->app_id);

            $appointment->admit = 'YES';

            $appointment->department = 'maternity ward';

            $appointment->update();
            // decrement bed count by 1
            $getFB = Ward::where('ward_no', $request->reg_ipwardno)->first();
            $newFB = $getFB->free_beds-=1;
            Ward::where('ward_no', $request->reg_ipwardno)->update(['free_beds' => $newFB]);


            //dd($getFB);

            $billing = new Billing();
            $billing->patient_id = $request->patient_id;
            $billing->appointment_id = $request->app_id;
            $billing->billing_for = $request->billing_for;
            $billing->amount = $getFB->charges_per_day;
            $billing->completed = 'no';
            $billing->payment_method = $appointment->mode_of_payment;
            $billing->save();
        }, 3);
      
        return redirect()->route('checkmertanitypatient');
    }


    public function deliveryinto()
    {
        return view('mertanity.delivery_intro');
    }

    public function deliveryformbegin(Request $request)
    {
        $appointment = Appointment::where('number', $request->appNum)->where('patient_id', $request->pid)->get()->last();

        if ($appointment == null) {
            return redirect()->back()->withErrors('patient does not have appointment number');
        }
        
        return view('mertanity.delivery')->with([
            'appointment' => $appointment,
            'title' => 'Delivery Form'
        ]);
    }


    public function savedeliveryinfo(Request $request)
    {
        DB::transaction(function () use ($request) {
            $delivery = new Delivery();
            $delivery->patient_id = $request->patient_id;
            $delivery->appointment_id = $request->appointment_id;
            $delivery->duration_of_labour = $request->duration_of_labour;
            $delivery->date_of_delivery = $request->date_of_delivery;
            $delivery->duration_of_labour = $request->duration_of_labour;
            $delivery->time_of_delivery = $request->time_of_delivery;
            $delivery->gestation_at_birth = $request->gestation_at_birth;
            $delivery->mode_of_delivery = $request->mode_of_delivery;
            $delivery->num_of_babies_delivered = $request->num_of_babies_delivered;
            $delivery->placenta_complete = $request->placenta_complete;
            $delivery->uterotonic_given = $request->uterotonic_given;
            $delivery->vaginal_examination = $request->vaginal_examination;
            $delivery->blood_loss = $request->blood_loss;
            $delivery->mother_status = $request->mother_status;
            $delivery->maternal_deaths_notified = $request->maternal_deaths_notified;
            $delivery->delivery_complications = $request->delivery_complications;
            $delivery->HIV_status_mother = $request->HIV_status_mother;
            $delivery->APGAR_Score = $request->APGAR_Score;
            $delivery->birth_outcome = $request->birth_outcome;
            $delivery->birth_weight = $request->birth_weight;
            $delivery->sex = $request->sex;
            $delivery->TEO_given_at_birth = $request->TEO_given_at_birth;
            $delivery->chlorhexidine_applied_on_cord_stump = $request->chlorhexidine_applied_on_cord_stump;
            $delivery->birth_with_deformities = $request->birth_with_deformities;
            $delivery->vitamin_k_given = $request->vitamin_k_given;
            $delivery->VDRL_RPR_results = $request->VDRL_RPR_results;
            $delivery->HIV_status_baby = $request->HIV_status_baby;
            $delivery->ARV_prophylaxis = $request->ARV_prophylaxis;
            $delivery->CTX_to_mother = $request->CTX_to_mother;
            $delivery->tested_for_hiv = $request->tested_for_hiv;
            $delivery->hiv_results = $request->hiv_results;
            $delivery->Counselled_on_infant_feeding = $request->Counselled_on_infant_feeding;
            $delivery->delivery_conducted_by = $request->delivery_conducted_by;

            $delivery->save();
        });

        return redirect()->route('deliveryinto');
    }
}
