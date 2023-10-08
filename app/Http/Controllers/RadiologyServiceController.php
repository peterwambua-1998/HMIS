<?php

namespace App\Http\Controllers;

use App\RadiologyService;
use Illuminate\Http\Request;

class RadiologyServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = 'Radiology Services';
        $collection = RadiologyService::all();
        return view('radiologyimaging.services.index', compact('title','collection'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
            'price' => 'required',
            'view' => 'required'
        ]);

        if (RadiologyService::createModel($data)) {
            return redirect()->route('radiology-services.index')->with('success', 'Record added successfully');
        }
        return redirect()->route('radiology-services.index')->with('unsuccess', 'System error pleas try again');
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\RadiologyService  $radiologyService
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'name' => 'required',
            'price' => 'required',
            'view' => 'required'
        ]);

        if (RadiologyService::updateModel($data, $id)) {
            return redirect()->route('radiology-services.index')->with('success', 'Record added successfully');
        }
        return redirect()->route('radiology-services.index')->with('unsuccess', 'System error pleas try again');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\RadiologyService  $radiologyService
     * @return \Illuminate\Http\Response
     */
    public function destroy(RadiologyService $radiologyService)
    {
        //
    }
}
