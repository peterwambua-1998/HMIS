<?php

namespace App\Http\Controllers;

use App\Appointment;
use App\BillFinal;
use App\Billing;
use App\Cashier;
use App\CashierQueue;
use App\Department;
use App\HospitalMeasure;
use App\Invoice;
use App\LabMeasure;
use App\LabPatientMeasure;
use App\LabQueue;
use App\Medicine;
use App\PatentAppointmentService;
use App\Patients;
use App\Prescription;
use App\Radiologymeasure;
use App\RadiologyService;
use App\SurgaryService;
use App\Surgery;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CashierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('cashier.search');

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
     * @param  \App\Cashier  $cashier
     * @return \Illuminate\Http\Response
     */
    public function show(Cashier $cashier)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Cashier  $cashier
     * @return \Illuminate\Http\Response
     */
    public function edit(Cashier $cashier)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Cashier  $cashier
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Cashier $cashier)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Cashier  $cashier
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cashier $cashier)
    {
        
    }

    public function search(Request $request)
    {
        
        $results =  Patients::withTrashed()->where('name', 'LIKE', '%' . $request->keyword . '%')->get();

        foreach ($results as $key => $patient) {
            $appointment =  Appointment::where('patient_id', $patient->id)->get()->last();
            $patient->appointment = $appointment;
        }
        
        return response($results);
    }

    public function startCashier(Request $request)
    {
        $result = Patients::find($request->patient_id);
        $appointment =  Appointment::where('patient_id', $result->id)->get()->last();
        //surgery
        $surgery = Surgery::where('appointment_id', '=', $appointment->id)->get();
        $surgeryCollection = [];
        if ($appointment->department == 'surgery') {
            foreach ($surgery as $key => $item) {
                if (!$item->measure_id && $item->note) {
                    $surgery->forget($key);
                }
                if ($item->measure_id !== null) {
                    if ($item->paid == 0) {
                        $surgeryService = SurgaryService::where('id','=', $item->measure_id)->first();
                        if ($surgeryService) {
                            $toPay = $surgeryService->price;
                            $surgeryCollection['service_id'] = $surgeryService->id;
                            $surgeryCollection['to_pay'] = $toPay;
                            $surgeryCollection['purpose'] = 'surgery';
                            $surgeryCollection['amount'] = 1;
                        }
                    } 
                }
            }
        }

        //lab
        $lab_collection = [];

        if ($appointment->department == 'lab') {
            $lab_measures = LabPatientMeasure::where('appointment_id', '=', $appointment->id)->where('patient_id','=',$result->id)->get();
            $labInnerArray = [];
            foreach ($lab_measures as $key => $measure) {
                if (isset($measure->measure_id)) {
                    $labService = LabMeasure::where('id', $measure->measure_id)->first();
                    $toPay = $labService->price;
                    $labInnerArray['service_id'] = $labService->id;
                    $labInnerArray['to_pay'] = $toPay;
                    $labInnerArray['purpose'] = $labService->measure_name;
                    $labInnerArray['amount'] = 1;
                    array_push($lab_collection, $labInnerArray);
                }
            }
        }

        

        // radiology
        $radiology_collection = [];
        if ($appointment->department == 'radiology') {
            $radiology_measures = Radiologymeasure::where('appointment_id', '=', $appointment->id)->where('patient_id','=',$result->id)->get();
            $radiologyInnerArray = [];
            foreach ($radiology_measures as $key => $measure) {
                $radiologyService = RadiologyService::where('id', $measure->measure_id)->first();
                $toPay = $radiologyService->price;
                $radiologyInnerArray['service_id'] = $radiologyService->id;
                $radiologyInnerArray['to_pay'] = $toPay;
                $radiologyInnerArray['purpose'] = $radiologyService->name;
                $radiologyInnerArray['amount'] = 1;
                array_push($radiology_collection, $radiologyInnerArray);
            }
        }

        //medicine
        $prescription_collection = [];
        if ($appointment->department == "pharmacy") {
            $prescription = Prescription::where('appointment_id', '=', $appointment->id)->where('patient_id', $result->id)->get()->last();
            $medicines = $prescription->medicines;
            $prescriptionInnerArray = [];
            foreach ($medicines as $key => $med) {
                $medicine = Medicine::where('id', $med->id)->first();
                $prescriptionInnerArray['service_id'] = $medicine->id;
                $prescriptionInnerArray['to_pay'] = $medicine->price;
                $prescriptionInnerArray['purpose'] = $medicine->name_english;
                $prescriptionInnerArray['amount'] = $med->qty;
                array_push($prescription_collection, $prescriptionInnerArray);
            }
        }

        return view('cashier.pos', [
            "title" => "Search Results", 
            "search_result" => $result,  
            'appointment' => $appointment,
            'surgeryCollection' => $surgeryCollection,
            'lab_collection' => $lab_collection,
            'radiology_collection' => $radiology_collection
        ]);
    }


    public function print(Request $request)
    {
        $result = Patients::withTrashed()->where('id', '=', $request->keyword)->get();

        if ($result == null) {
            return redirect()->back();
        }
        
        $appointment = Appointment::where('patient_id', '=', $result[0]->id)->get()->last();
        $invoice = new Invoice();
        if ($appointment->department == 'lab') {
            DB::transaction(function () use ($request, $invoice, $appointment) {
                $invoice->patient_id = $request->keyword;
                $invoice->appointment_id = $request->appointment;
                $invoice->serial_number = 'INV' . date('Ymd') . rand(1, 100000);
                $invoice->sub_total = $request->total;
                $invoice->tax = 0;
                $invoice->total = $request->total;
                $invoice->paid_amount = $request->paid_amount;
                $invoice->balance = $request->balance;
                $invoice->payment_method = $request->payment_method;
                $invoice->save();

                for ($i=0; $i < count($request->service); $i++) { 
                    $billfinal = new Billing();
                    $billfinal->invoice_id = $invoice->id;
                    $billfinal->billing_for = $request->service[$i];
                    $billfinal->qty = $request->qty[$i];
                    $billfinal->amount = $request->amount[$i];
                    $billfinal->save();
                }

                /**
                 * if lab
                 * update cashier table to done
                 */
                $cashierQueue = CashierQueue::where('appointment_id', $request->appointment)->where('done',0)->first();
                $cashierQueue->done = 1;
                $cashierQueue->paid = 1;
                $cashierQueue->update();

                if ($cashierQueue->department == 'lab') {
                    $labQueue = new LabQueue();
                    $labQueue->appointment_id = $request->appointment;
                    $labQueue->patient_id = $request->keyword;
                    $labQueue->department = 'lab';
                    $labQueue->reason = 'lab';
                    $labQueue->paid = 0;
                    $labQueue->save();
                }
            });
        }
        
        $billing = Billing::where('invoice_id', '=', $invoice->id)->get();
        return view('cashier.printview', ["title" => "Search Results", "search_result" => $result, 'billing' => $billing, 'appointment' => $appointment, 'invoice' => $invoice]);
        //return view('cashier.printview', ["title" => "Search Results", "search_result" => $result, 'billing' => $billing, 'appointment' => $appointment]);
    }

    public function inpatientQueue()
    {
        $app = Appointment::where('admit', '=', 'YES')->where('completed', '=', 'no')->where('department', 'LIKE', '%'. 'cashier' .'%')->get();

        return view('cashier.inpatient_list')->with('app', $app);
        
    }


    public function getService() {
        $services = HospitalMeasure::paginate(10);
        
        return json_encode($services);
    }


    public function searchService(Request $request)
    {
        //echo $request->search;
        $output = "";
        $services = HospitalMeasure::where('measure_name', 'LIKE', "%{$request->search}%")->get();
       
        if ($services) {
            foreach ($services as $key => $service) {
                $output.='<tr class="js-add" data-id="'. $service->id .'" data-measure_name="'. $service->measure_name .'" data-amount="'. $service->amount .'" >'.
               
                '<td>'.$service->id.'</td>'.
                '<td>'.$service->measure_name.'</td>'.
                '<td>'.$service->amount.'</td>'.
                '</tr>';
                }
        }

        return Response($output);
    }

    public function getServices($id)
    {
        $appointment = Appointment::find($id);
        $patient = Patients::find($appointment->patient_id);
        $services = PatentAppointmentService::where('appointment_id','=',$appointment->id)->get();
        $title = 'services';
        return view('cashier.services', compact('appointment','services','patient','title'));
    }

    
    /**
     * Queue view
     */
    public function queueView()
    {
        $number = 1;
        $title = 'cashier queue';
        $qs = CashierQueue::where('done', 0)->get();
        return view('cashier.queue', compact('title', 'qs', 'number'));
    }
}
