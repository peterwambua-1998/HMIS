<?php

namespace App\Http\Controllers;

use App\Appointment;
use App\BillFinal;
use App\Billing;
use App\Cashier;
use App\Department;
use App\HospitalMeasure;
use App\Invoice;
use App\PatentAppointmentService;
use App\Patients;
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
        return view('cashier.pos', ["title" => "Search Results", "search_result" => $result,  'appointment' => $appointment]);
    }


    public function print(Request $request)
    {

        
        //$bill_final = new BillFinal();
        //return $request;

        $result = Patients::withTrashed()->where('id', '=', $request->keyword)->get();

        if ($result == null) {
            return redirect()->back();
        }
            //$triage = Lab::where('patient_id', '=', $result[0]->id)->get();
        $appointment = Appointment::where('patient_id', '=', $result[0]->id)->get()->last();
        $invoice = new Invoice();

        DB::transaction(function () use ($request, $invoice) {
   
            
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
                # code...
            
                $billfinal = new Billing();
                $billfinal->invoice_id = $invoice->id;
                $billfinal->billing_for = $request->service[$i];
                $billfinal->qty = $request->qty[$i];
                $billfinal->amount = $request->amount[$i];
                //$billfinal->payment_method = $request->payment_method;
                $billfinal->save();
            }
        
        });

        $billing = Billing::where('invoice_id', '=', $invoice->id)->get();
       
        return view('cashier.printview', ["title" => "Search Results", "search_result" => $result, 'billing' => $billing, 'appointment' => $appointment]);
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
}
