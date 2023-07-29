<?php

namespace App\Http\Controllers;

use App\BillFinal;
use App\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InvoiceController extends Controller
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

        DB::transaction(function () use ($request) {
   
                $invoice = new Invoice();
                $invoice->patient_id = $request->patient_id;
                $invoice->appointment_id = $request->appointment_id;
                $invoice->serial_number = 'INV' . date('Ymd') . rand(1, 100000);
                $invoice->title = $request->title;
                $invoice->sub_total = $request->sub_total;
                $invoice->tax = 0;
                $invoice->total = $request->total;
                $invoice->paid_amount = $request->paid_amount;
                $invoice->balance = $request->balance;


                $invoice->save();

                $medicines = $request->medicines;

                foreach ($medicines as $medicine) {
                    $billfinal = new BillFinal();
                    $billfinal->invoice_id = $invoice->id;
                    $billfinal->med_name = $medicine->name;
                    $billfinal->med_qty = $medicine->qty;
                    $billfinal->med_price = $medicine->price;
                    $billfinal->save();
                }
            
        });

        return redirect()->route('cashiercheckp');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function show(Invoice $invoice)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function edit(Invoice $invoice)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Invoice $invoice)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function destroy(Invoice $invoice)
    {
        //
    }
}
