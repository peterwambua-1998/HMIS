@extends('template.main')

@section('title', 'Triage Search')

@section('content_title',__("Search Patient"))
@section('content_description')
@section('breadcrumbs')
<ol class="breadcrumb">
    <li><a href="#"><i class="fas fa-tachometer-alt"></i>Dashboard</a></li>
    <li class="active">Here</li>
</ol>

@endsection

@section('main_content')

<style>
    body {
        font-size: 15px !important;
    }
    h6 {
        font-size: 16px !important;
        font-weight: bold;
        color: green;
    }
</style>

<section class="content-header">
    <div style="display: flex; flex-direction:row-reverse; gap: 1%">
        <form action="{{route('checkPatient')}}" method="post">
            @csrf
            <input type="hidden" name="appNum" value="{{$appointment->number}}">
            <input type="hidden" name="pid" value="{{$patient->id}}">
            <button type="submit" class="btn btn-warning">Back</button>
        </form>
        <button type="submit" class="btn btn-primary">Print</button>
    </div>
</section>

<div class="row" >
    <div class="col-md-12" style="padding: 10px;">
        <!-- card -->
        <div class="card">
            <div class="card-body">
                <!-- logo and heading -->
                <div class="row" style="padding-top: 2%; padding-left: 2%; padding-right: 2%;">
                    <div class="col-md-12" style="background: #FAF9F9;border: 1px solid rgba(0,0,0,.125);">
                        <div class="row">
                            <div class="col-md-1">
                                <img src="./WKMHLogo.png" alt="logo" class="img-fluid">
                            </div>
                            <div class="col-md-11">
                                <h5 style="padding-left: 40%; padding-top: 2%; font-weight: bold">APPOINTMENT REPORT</h5>
                            </div>
                        </div>
                    </div>
                    
                </div>
                <hr>
                <!-- patient info and appointment visits -->
                <div class="mb-3" style="display: grid; grid-template-columns: 1fr 1fr; gap: 2%; ">
                    <div style="background-color: #FAF9F9; border: 1px solid rgba(0,0,0,.125); padding-top: 2%; padding-left: 2%; padding-right: 2%;">
                        <h6>Patient Information</h6>
                        <div style="line-height: 15px; margin-top:5%;">
                            <p><span style="font-weight: 500;">Name:</span> {{$patient->name}}</p>
                            <p><span style="font-weight: 500;">Phone:</span> {{$patient->contactnumber}}</p>
                            <p><span style="font-weight: 500;">Age:</span> {{$patient->bod}}</p>
                        </div>
                    </div>
                    <div style="background-color: #FAF9F9; border: 1px solid rgba(0,0,0,.125); padding-top: 2%; padding-left: 2%; padding-right: 2%;">
                        <h6>Appoinment Visits</h6>
                        <div class="row">
                            <div class="col-md-6">
                                <ul>
                                   <?php
                                        $app_doc = $appointment->doctor_id;
                                        $doc = App\User::find($app_doc);
                                        if ($doc->user_type == "doctor_dentist") {
                                            $department = "Dentist";
                                        }

                                        if ($doc->user_type == "doctor_consultation") {
                                            $department = "Consultation";
                                        }
                                   ?>
                                    @if ($triage)
                                        <li>Triage</li>
                                    @endif
                                    @if ($labs->isNotEmpty())
                                        <li>Lab</li>
                                    @endif
                                    <li>{{$department}}</li>
                                </ul>
                            </div>
                            <div class="col-md-6">
                                <ul>
                                    
                                    @if ($imaging_radiology)
                                        <li>Radiology and Imaging</li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>
                    
                </div>
                <!-- patient info and appointment visits -->

                <!-- patient info and appointment visits -->
                <div class="mb-3" style="display: grid; grid-template-columns: 1fr;">
                    <div style="background-color: #FAF9F9; border: 1px solid rgba(0,0,0,.125); padding-top: 2%; padding-left: 2%; padding-right: 2%;">
                        <div class="">
                            <h6 >Triage Results</h6>
                            <div class="" style="line-height: 20px; margin-top:2%; display: flex; flex-wrap: wrap; flex-direction: column; height: 90px;">
                                <p><span style="font-weight: 500;">Weight:</span> <span class="text-green">{{ $triage->weight }} Kg</span></p>
                                <p><span style="font-weight: 500;">Blood Pressure:</span> {{$triage->blood_pressure}} mmHg</p>
                                <p><span style="font-weight: 500;">Temperature:</span> <span class="@if ($triage->blood_pressure>130) text-red @elseif ($triage->blood_pressure>125 ) text-yellow @else text-green @endif">{{ $triage->temp }} °C</span></p>
                                <p><span style="font-weight: 500;">Brief History:</span> {{$triage->history}}</p>
                                <p><span style="font-weight: 500;">Allergies:</span> {{$triage->allergies}}</p>
                                
                            </div>
                        </div>
                    </div>
                    
                </div>
                <!-- patient info and appointment visits -->

                <!-- lab results -->
                @if ($labs->isNotEmpty())
                <div class="mb-3" style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 2%;">
                    <div style="background-color: #FAF9F9; border: 1px solid rgba(0,0,0,.125); padding-top: 7%; padding-left: 7%; padding-right: 7%;">
                            <h6>Lab Test Requested</h6>
                            <div class="pt-2" style="line-height: 20px; margin-top:2%; display: flex; flex-wrap: wrap; flex-direction: column; height: 150px;">
                                @foreach ($lab_requests_final as $final)
                                <p>
                                    {{$final->measure_name}}
                                </p>
                                @endforeach
                            </div>
                    </div>
                    <div style="background-color: #FAF9F9; border: 1px solid rgba(0,0,0,.125); padding-top: 7%; padding-left: 7%; padding-right: 7%;">
                            <h6>Lab Results</h6>
                            <div class="pt-2" style="line-height: 20px; margin-top:2%; display: flex; flex-wrap: wrap; flex-direction: column; height: 150px;">
                                @foreach ($labs as $lab)
                                <p>
                                    <span style="font-weight: 500">{{$lab->measure_name}}:</span> <span class="text-green">{{ $lab->result }} {{$lab->unit}}</span>
                                </p>
                                @endforeach
                            </div>
                    </div>
                    <div style="background-color: #FAF9F9; border: 1px solid rgba(0,0,0,.125); padding-top: 7%; padding-left: 7%; padding-right: 7%;">
                            <h6>Lab Notes</h6>
                            <div class="pt-2" style="line-height: 15px; margin-top:2%;">
                                @if ($lab_note)
                                    <p>{{$lab_note}}</p>
                                @else
                                    <p>Not provided.</p>
                                @endif
                            </div>
                    </div>
                </div>
                <!-- lab results -->
                @endif
                <!-- radiology results -->
                <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 2%;">
                    <div style="background-color: #FAF9F9; border: 1px solid rgba(0,0,0,.125); padding-top: 7%; padding-left: 7%; padding-right: 7%;">
                        <h6 style="text-decoration: underline;">Requested Radiology Scan</h6>
                        <div class="pt-2" style="line-height: 15px; margin-top:2%; display: flex; flex-wrap: wrap; flex-direction: column; height: 150px;">
                            <p>MRI Scan</p>
                        </div>
                    </div>
                    <div style="background-color: #FAF9F9; border: 1px solid rgba(0,0,0,.125); padding-top: 7%; padding-left: 7%; padding-right: 7%;">
                        <h6 style="text-decoration: underline;">Radiology Image</h6>
                        <div class="pt-2" style="line-height: 15px; margin-top:2%; display: flex; flex-wrap: wrap; flex-direction: column; height: 150px;">
                            <p>
                                * Click <span style="font-weight: 500;">"view image"</span> where you will be taken to a different interface to view dicom image 
                            </p>
                            <button class="btn btn-success">view image</button>
                        </div>
                    </div>
                    <div style="background-color: #FAF9F9; border: 1px solid rgba(0,0,0,.125); padding-top: 7%; padding-left: 7%; padding-right: 7%;">
                            <h6 style="text-decoration: underline;">Radiologist Note</h6>
                            <div class="pt-2" style="line-height: 15px; margin-top:2%;">
                                <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Incidunt autem sed porro eius sit mollitia alias accusantium soluta beatae id, accusamus magnam dolores quam.</p>
                            </div>
                    </div>
                </div>
                <!-- patient info and appointment visits -->

            </div>
        </div>
    </div>
</div>

@endsection