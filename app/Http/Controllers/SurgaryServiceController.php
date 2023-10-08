<?php

namespace App\Http\Controllers;

use App\SurgaryService;
use Illuminate\Http\Request;

class SurgaryServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = 'Services';
        $collection = SurgaryService::all();
        return view('surgery.services.index', compact('collection', 'title'));
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
            'description' => 'required',
            'category' => 'required'
        ]);

        if (SurgaryService::createModel($data)) {
            return redirect()->route('surgery-services.index')->with('success', 'Record stored successfully');
        }
        return redirect()->route('surgery-services.index')->with('unsuccess', 'System error please try again');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\SurgaryService  $surgaryService
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'name' => 'required',
            'price' => 'required',
            'description' => 'required',
            'category' => 'required'
        ]);

        if (SurgaryService::updateModel($data, $id)) {
            return redirect()->route('surgery-services.index')->with('success', 'Record stored successfully');
        }
        return redirect()->route('surgery-services.index')->with('unsuccess', 'System error please try again');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\SurgaryService  $surgaryService
     * @return \Illuminate\Http\Response
     */
    public function destroy(SurgaryService $surgaryService)
    {
        //
    }
}
