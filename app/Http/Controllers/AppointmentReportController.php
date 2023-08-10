<?php

namespace App\Http\Controllers;

use App\Appointment;
use App\Dialysis;
use App\LabMeasure;
use App\LabMeasureResult;
use App\LabPatientMeasure;
use App\Patients;
use App\Radiologyimaging;
use App\Triage;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class AppointmentReportController extends Controller
{
    public function report($id)  
    {
        $appointment = Appointment::find(Crypt::decrypt($id));
        $patient = Patients::find($appointment->patient_id);
        $triage = Triage::where('patient_id', '=', $patient->id)->where('appointment_id', '=', $appointment->id)->get()->last();
        $labs = LabMeasureResult::where('patient_id', '=', $patient->id)->where('appointment_id', '=', $appointment->id)->get();
        if ($labs->isNotEmpty()) {
            foreach ($labs as $key => $lab) {
                $measure_name = LabMeasure::where('id','=',$lab->measure_id)->first();
                $lab->measure_name = $measure_name->measure_name;
                $lab->unit = $measure_name->unit_of_measurement;
            }
        }
        $lab_requests = LabPatientMeasure::where('patient_id', '=', $patient->id)->where('appointment_id', '=', $appointment->id)->get();
        $lab_requests_final = new Collection();
        $lab_note = null;
        foreach ($lab_requests as $key => $measure) {
            if ($measure->measure_id !== 0) {
                $lab_measure = LabMeasure::where('id','=', $measure->measure_id)->first(['id','measure_name']);
            }

            if ($measure->measure_id == 0 && $measure->note) {
                $lab_note = $measure->note;
            }
        }
        $imaging_radiology = Radiologyimaging::where('patient_id', '=', $patient->id)->where('appointment_id', '=', $appointment->id)->get()->last();
        $lab_measures = LabMeasure::all();
        $title = 'Appointment report';
        return view('patient.appointment_report', compact(
            'appointment', 'patient', 'triage', 'labs', 'lab_measures','imaging_radiology','title'
        ));
    }
}
