@extends('template.plain')
@section('content_title')
Patient Treatment History
@endsection
@section('title', $title)
@php
use App\Medicine;
use App\Clinic;
use App\Triage;
@endphp
@section('sidebar_content')

@foreach ($prescs as $presc)
<li>
<a href="#presc{{$presc->id}}">
    <i class="fas fa-history"></i>
         <span>
            &nbsp; {{explode(" ",$presc->created_at)[0]}}
        </span>
    </a>
</li>
@endforeach



@endsection

@section('main_content')
<div class="row">
    <div class="col-md-12">
        <!-- Widget: user widget style 1 -->
        <div class="box box-widget widget-user">
            <!-- Add the bg color to the header using any of the bg-* classes -->
            <div class="widget-user-header bg-aqua-active">
                <h3 class="widget-user-username">NAME : {{ucwords($patient->name)}}</h3>
                <h5 class="widget-user-desc">PATIENT NO : {{$patient->id}}</h5>
                <h5 class="widget-user-desc">PHONE NO : {{$patient->contactnumber}}</h5>
            </div>
            <div class="widget-user-image">
                {{--
                <img class="img-circle" height="128px" width="128px" src="#"
                    alt="User Avatar">
                    --}}
            </div>
            <div class="box-footer">
                <div class="row">
                    <div class="col-xs-6 border-right">
                        <div class="description-block">
                            <h5 class="description-header"><span class="@if($status=='Active') text-green @else
                                    text-danger @endif">No Of Visits</span>
                            </h5>
                            <span class="description-text">{{$hospital_visits}}</span>
                        </div>
                        <!-- /.description-block -->
                    </div>
                    <!-- /.col -->
                    <div class="col-xs-6 border-right">
                        <div class="description-block">
                            <h5 class="description-header">Last Seen</span>
                            </h5>
                            <span class="description-text">{{$last_seen}}</span>
                        </div>
                        <!-- /.description-block -->
                    </div>
                  
                    <!-- /.col -->
                    
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div>
        </div>
        <!-- /.widget-user -->

    </div>

</div>

{{--
@if ($clinics=$patient->clinics->count()>0)
<div class="row mb-4">
    <div class="col-md-12">
        <h3>Attending Clinics</h3>
        @foreach ($patient->clinics as $clinic)
        <span style="display:inline-block;font-size:15px" class="mt-2 mb-2 badge bg-navy">{{$clinic->name_eng}}</span>
        @endforeach
    </div>
</div>
@endif
--}}


<div class="row">
    <div class="col-md-12">
        @foreach ($prescs as $presc)
        <div id="presc{{$presc->id}}" class="box box-success collapsed-box">
            <div class="box-header with-border">
                <h3 class="box-title">Visit On ({{explode(" ",$presc->created_at)[0]}})</h3>

                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
                    </button>
                    
                </div>
            </div>
            <div class="box-body" style="display:none">

                @php

                $pres_med=json_decode($presc->medicines);
               
                
                @endphp

                <div style="border: 1px solid gray; padding: 10px">
                    <h4 style="text-decoration: underline">Diagnosis</h4>
                    <p class="text-primary" style="font-size:17px;font-weight:600">{{$presc->diagnosis}}</p>
                </div>
                
                

                   
                @php
                    
                    $appointID = $presc->appointment->id;

                    $triage = \App\Triage::where('appointment_id', '=', $appointID)->first();

                    $lab = \App\Lab::where('appointment_id', '=', $appointID)->first();
                    

                    if(! $lab){
                        $lab = null;
                    }

                    

                @endphp
                <div style="border: 1px solid gray; padding: 10px">
                    <h4 style="text-decoration: underline">Triage</h4>
                    <h4>
                        Blood Pressure :
                        <span class="h4 @if ($triage->blood_pressure>130) text-red @elseif ($triage->blood_pressure>125 ) text-yellow @else text-green @endif ">
                            {{ $triage->blood_pressure }} mmHg <small> ({{ $triage->created_at }}) </small>
                        </span>
                    </h4>
                    
                    
                    <h4>
                        Weight : <span class="text-green">{{ $triage->weight }} Kg <small> ({{ $triage->created_at }}) </small></span>
                    </h4>
                    <h4>
                        Temp : <span class="@if ($triage->blood_pressure>130) text-red @elseif ($triage->blood_pressure>125 ) text-yellow @else text-green @endif">{{ $triage->temp }} °C <small> ({{ $triage->created_at }}) </small></span>
                    </h4>
                    <h4>
                        Brief History : <span class="text-green">{{ $triage->history }}</span>
                    </h4>
                    <h4>
                        Allergies : <span class="text-green">{{ $triage->allergies }}</span>
                    </h4>
                </div>
                
                @if ($lab != null)
                    <div style="border: 1px solid gray; padding: 10px">
                        <h4 style="text-decoration: underline">Lab Results</h4>
                        @if ($lab->whitebooldcells !== null)
                        <h4>
                            White blood cell (WBC): <span class="text-green">{{ $lab->whitebooldcells }}</span>
                        </h4>
                        @endif

                        @if ($lab->redbooldcells !== null)
                        <h4>
                            Red blood cell (RBC) counts: <span class="text-green">{{ $lab->redbooldcells }}</span>
                        </h4>
                        @endif

                        @if ($lab->prothrombintime !== null)
                        <h4>
                            PT, prothrombin time: <span class="text-green">{{ $lab->prothrombintime }}</span>
                        </h4>
                        @endif

                        @if ($lab->activatedpartialthromboplastin !== null)
                        <h4>
                            APTT, activated partial thromboplastin time: <span class="text-green">{{ $lab->activatedpartialthromboplastin }}</span>
                        </h4>
                        @endif

                        @if ($lab->aspartateaminotransferase !== null)
                        <h4>
                            AST, aspartate aminotransferase: <span class="text-green">{{ $lab->aspartateaminotransferase }}</span>
                        </h4>
                        @endif

                        @if ($lab->alanineaminotransferase !== null)
                        <h4>
                            ALT, alanine aminotransferase: <span class="text-green">{{ $lab->alanineaminotransferase }}</span>
                        </h4>
                        @endif


                        @if ($lab->mlactatedehydrogenase !== null)
                        <h4>
                            LD, lactate dehydrogenase: <span class="text-green">{{ $lab->mlactatedehydrogenase }}</span>
                        </h4>
                        @endif


                        @if ($lab->bloodureanitrogen !== null)
                        <h4>
                            BUN, blood urea nitrogen: <span class="text-green">{{ $lab->bloodureanitrogen }}</span>
                        </h4>
                        @endif

                        @if ($lab->WBCcountWdifferential !== null)
                        <h4>
                            WBC count w/differential: <span class="text-green">{{ $lab->WBCcountWdifferential }}</span>
                        </h4>
                        @endif

                        @if ($lab->Quantitativeimmunoglobulin !== null)
                        <h4>
                            Quantitative immunoglobulin’s (IgG, IgA, IgM): <span class="text-green">{{ $lab->Quantitativeimmunoglobulin }}</span>
                        </h4>
                        @endif

                        @if ($lab->Erythrocytesedimentationrate !== null)
                        <h4>
                            Erythrocyte sedimentation rate (ESR): <span class="text-green">{{ $lab->Erythrocytesedimentationrate }}</span>
                        </h4>
                        @endif
                        

                        @if ($lab->alpha_antitrypsin !== null)
                        <h4>
                            Quantitative alpha-1-antitrypsin (AAT) level: <span class="text-green">{{ $lab->alpha_antitrypsin }}</span>
                        </h4>
                        @endif


                        @if ($lab->Reticcount !== null)
                        <h4>
                            Retic count: <span class="text-green">{{ $lab->Reticcount }}</span>
                        </h4>
                        @endif

                        @if ($lab->arterialbloodgasses !== null)
                        <h4>
                            Arterial blood gasses (ABGs): <span class="text-green">{{ $lab->arterialbloodgasses }}</span>
                        </h4>
                        @endif
                    </div>
                @endif
                
                
                <div style="border: 1px solid gray; padding: 10px">
                    <h4 style="text-decoration: underline">Issued Medicines</h4>
                    <ul style="font-size:16px">
                        @foreach($pres_med as $med)
                        <li>
                            {{ucwords($med->name)}}({{Medicine::where('name_english',$med->name)->first()->name_english}})
                        </li>
                        <ul>
                            <li> {{$med->note}} </li>
                        </ul>
                        @endforeach
                    </ul>
                </div>

                



            </div>

        </div>
        @endforeach

        
    </div>
</div>

@endsection