<?php

namespace App\Http\Controllers;

use App\DischargedPatient;
use App\inpatient;
use Illuminate\Http\Request;

class DischargedPatientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $patients = inpatient::where('discharged', 'LIKE', '%'. 'YES' . '%')->get();

     
        return view('inpatient.discharge')->with([
            'patients' => $patients
        ]);
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
     * @param  \App\DischargedPatient  $dischargedPatient
     * @return \Illuminate\Http\Response
     */
    public function show(DischargedPatient $dischargedPatient)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\DischargedPatient  $dischargedPatient
     * @return \Illuminate\Http\Response
     */
    public function edit(DischargedPatient $dischargedPatient)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\DischargedPatient  $dischargedPatient
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DischargedPatient $dischargedPatient)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\DischargedPatient  $dischargedPatient
     * @return \Illuminate\Http\Response
     */
    public function destroy(DischargedPatient $dischargedPatient)
    {
        //
    }
}
