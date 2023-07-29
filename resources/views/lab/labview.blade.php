@extends('template.main')

@section('title', $title)

@section('content_title',__("Patient Results"))
@section('content_description',__("Search,View & Update Patient Details"))
@section('breadcrumbs')
<ol class="breadcrumb">
    <li><a href="#"><i class="fas fa-tachometer-alt"></i>Dashboard</a></li>
    <li class="active">Here</li>
</ol>

@endsection

@section('main_content')

<div class="row" id="createchannel4">

    <div class="col-xs-12">
        <div class="box box-primary">
            <div class="box-header">
                <h3 class="box-title">{{__('Patient Details')}}</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <div class="mb-4" style="display: grid; grid-template-columns: 1fr 1fr; font-size: 15px; grid-row-gap: 12px; border: 1px solid gray; padding: 20px">
                <p>Patient Name: <span style="font-weight: bold">{{ $search_result->name }}</span></p>
                <p>Patient Telephone: <span style="font-weight: bold">{{ $search_result->telephone }}</span></p>
                <p>DOB: <span style="font-weight: bold">{{ $search_result->bod }}</span>
                <p>Current Doctor: <span style="font-weight: bold">{{ $docs->name }}</span></p>
                <p>Doctor Note: <strong>{{ $measure->note }}</strong></p>
                

                

                @if ($measure->measrure_1 !== null)
                <div style="display: flex">
                    <p>Test Requested:</p>
                    <p style="font-weight: bold">{{$measure->measrure_1 }}</p>
                </div>
                
                @endif

                @if ($measure->measrure_2 !== null)
                <div style="display: flex">
                    <p>Test Requested:</p>
              
                    <p  style="font-weight: bold">{{$measure->measrure_2 }}</p>
                </div>
                
                @endif

                @if ($measure->measrure_3 !== null)
                <div style="display: flex">
                    <p>Test Requested:</p>
                    
                    <p style="font-weight: bold">{{$measure->measrure_3 }}</p>
                </div>
                
                @endif

                @if ($measure->measrure_4 !== null)
                <div style="display: flex">
                    <p>Test Requested:</p>
                   
                    <p style="font-weight: bold">{{$measure->measrure_4 }}</p>
                </div>
                
                @endif

                @if ($measure->measrure_5 !== null)
                <div style="display: flex">
                    <p>Test Requested:</p>
                    
                    <p style="font-weight: bold">{{$measure->measrure_5 }}</p>
                </div>
                
                @endif

                @if ($measure->measrure_6 !== null)
                <div style="display: flex">
                    <p>Test Requested:</p>
                   
                    <p style="font-weight: bold">{{$measure->measrure_6 }}</p>
                </div>
                
                @endif

                @if ($measure->measrure_7 !== null)
                <div style="display: flex">
                    <p>Test Requested:</p>
                    
                    <p style="font-weight: bold">{{$measure->measrure_7 }}</p>
                </div>
            
                @endif

                @if ($measure->measrure_8 !== null)
                <div style="display: flex">
                    <p>Test Requested:</p>
                    
                    <p style="font-weight: bold">{{$measure->measrure_8 }}</p>
                </div>

                @endif

                @if ($measure->measrure_9 !== null)
                <div style="display: flex">
                    <p>Test Requested:</p>
                   
                    <p style="font-weight: bold">{{$measure->measrure_9 }}</p>
                </div>
                
                @endif

                @if ($measure->measrure_10 !== null)
                <div style="display: flex">
                    <p>Test Requested:</p>
                    
                    <p style="font-weight: bold">{{$measure->measrure_10 }}</p>
                </div>

                @endif

                @if ($measure->measrure_11 !== null)
                <div style="display: flex">
                    <p>Test Requested:</p>
                    
                    <p style="font-weight: bold">{{$measure->measrure_11 }}</p>
                </div>

                @endif

                @if ($measure->measrure_12 !== null)
                <div style="display: flex">
                    <p>Test Requested:</p>
                    
                    <p style="font-weight: bold">{{$measure->measrure_12 }}</p>
                </div>
                
                @endif

                @if ($measure->measrure_13 !== null)
                <div style="display: flex">
                    <p>Test Requested:</p>
                    
                    <p style="font-weight: bold">{{$measure->measrure_13 }}</p>
                </div>
 
                @endif

                @if ($measure->measrure_14 !== null)
                <div style="display: flex">
                    <p>Test Requested:</p>
                    
                    <p style="font-weight: bold">{{$measure->measrure_14 }}</p>
                </div>
                
                @endif
                
                
                </div>
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>
   
    <!-- /.col -->
</div>

<div class="row" id="">
    

    <div class="col-xs-12">
        <div class="box box-info">
            <div class="box-header">
                <h3 class="box-title">{{__('Lab Results Form')}}</h3>
            </div>
            <div class="box-body">

                <form class="form-horizontal" action="{{route('addLab')}}" method="POST">
                    @csrf
                    <div class="row">
                        @if ($measure->measrure_1 !== null)
                        <div class="col-md-6">
                            <label for="">White blood cell (WBC) </label>
                            <input class="form-control" type="text" placeholder="Enter White blood cell (WBC)" name="whitebooldcells"><br>
                        </div>

                        @endif
                        @if ($measure->measrure_2 !== null)
                        <div class="col-md-6">
                            <label for="">Red blood cell (RBC) counts</label>
                            <input class="form-control" type="text" placeholder="Enter Red blood cell (RBC) counts" name="redbooldcells" ><br>
                        </div>

                        @endif
                    </div>


                    <div class="row">
                        @if ($measure->measrure_3 !== null)
                        <div class="col-md-6">
                            <label for="">PT, prothrombin time</label>
                            <input class="form-control" type="text" placeholder="Enter Anemia Frequecy" name="prothrombintime" ><br>
                        </div>

                        @endif
                        @if ($measure->measrure_4 !== null)
                        <div class="col-md-6">
                            <label for="">APTT, activated partial thromboplastin time</label>
                            <input class="form-control" type="text" placeholder="Enter APTT, activated partial thromboplastin time" name="activatedpartialthromboplastin" ><br>
                        </div>

                        @endif
                    </div>

                    <div class="row">
                        @if ($measure->measrure_5 !== null)
                        <div class="col-md-6">
                            <label for="">AST, aspartate aminotransferase</label>
                            <input class="form-control" type="text" placeholder="Enter AST, aspartate aminotransferase" name="aspartateaminotransferase" ><br>
                        </div>

                        @endif
                        @if ($measure->measrure_6 !== null)
                        <div class="col-md-6">
                            <label for="">ALT, alanine aminotransferase</label>
                            <input class="form-control" type="text" placeholder="Enter ALT, alanine aminotransferase" name="alanineaminotransferase" ><br>
                        </div>

                        @endif
                    </div>


                    <div class="row">
                        @if ($measure->measrure_7 !== null)
                        <div class="col-md-6">
                            <label for="">LD, lactate dehydrogenase</label>
                            <input class="form-control" type="text" placeholder="Enter LD, lactate dehydrogenase" name="mlactatedehydrogenase" ><br>
                        </div>

                        @endif
                        @if ($measure->measrure_8 !== null)
                        <div class="col-md-6">
                            <label for="">BUN, blood urea nitrogen</label>
                            <input class="form-control" type="text" placeholder="Enter BUN, blood urea nitrogen" name="bloodureanitrogen" ><br>
                        </div>

                        @endif
                    </div>

                    <div class="row">
                        @if ($measure->measrure_9 !== null)
                        <div class="col-md-6">
                            <label for="">WBC count w/differential</label>
                            <input class="form-control" type="text" placeholder="Enter WBC count w/differential" name="WBCcountWdifferential" ><br>
                        </div>

                        @endif
                        @if ($measure->measrure_10 !== null)
                        <div class="col-md-6">
                            <label for="">Quantitative immunoglobulin’s (IgG, IgA, IgM)</label>
                            <input class="form-control" type="text" placeholder="Enter BUN, blood urea nitrogen" name="Quantitativeimmunoglobulin" ><br>
                        </div>

                        @endif
                    </div>



                    <div class="row">
                        @if ($measure->measrure_11 !== null)
                        <div class="col-md-6">
                            <label for="">Erythrocyte sedimentation rate (ESR)</label>
                            <input class="form-control" type="text" placeholder="Enter Erythrocyte sedimentation rate (ESR)" name="Erythrocytesedimentationrate" ><br>
                        </div>

                        @endif
                        @if ($measure->measrure_12 !== null)
                        <div class="col-md-6">
                            <label for="">Quantitative alpha-1-antitrypsin (AAT) level</label>
                            <input class="form-control" type="text" placeholder="Enter Quantitative alpha-1-antitrypsin (AAT) level" name="alpha_antitrypsin" ><br>
                        </div>

                        @endif
                    </div>


                    <div class="row">
                        @if ($measure->measrure_13 !== null)
                        <div class="col-md-6">
                            <label for="">Retic count</label>
                            <input class="form-control" type="text" placeholder="Enter Retic count" name="Reticcount" ><br>
                        </div>

                        @endif
                        @if ($measure->measrure_14 !== null)
                        <div class="col-md-6">
                            <label for="">Arterial blood gasses (ABGs)</label>
                            <input class="form-control" type="text" placeholder="Enter Quantitative alpha-1-antitrypsin (AAT) level" name="arterialbloodgasses" ><br>
                        </div>

                        @endif
                    </div>

                    
                    
                    <input type="hidden" value="500" name="amount" />
                    <input type="hidden" value="{{ $appointment->id }}" name="appointment_id" />
                    <input type="hidden" value="{{ $appointment->patient_id }}" name="patient_id" />
                    <input type="hidden" value="lab" name="billing_for" />
                    <input type="hidden" value="no" name="completed" />
                    <input type="hidden" value="{{ $appointment->mode_of_payment }}" name="payment_method" />
                    <button type="submit" class="btn btn-success">Submit Results</button>
                    
                    
                </form>

            </div>

        </div>
    </div>
    
    

</div>


<div class="row" id="createchannel4">
   
    <div class="col-xs-12">
        <div class="box box-primary">
            <div class="box-header">
                <h3 class="box-title">{{__('Lab History')}}</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <div class="row">
                    <div class="col-md-12">
                       
                        <div id="presc" class="box box-success collapsed-box">
                            <div class="box-header with-border">
                                <h3 class="box-title">Visit On </h3>
                
                                <div class="box-tools pull-right">
                                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
                                    </button>
                                    
                                </div>
                            </div>
                            <div class="box-body" style="display:none">
                
                                
                
                                
                
                            </div>
                
                        </div>
                       
                
                    </div>
                </div>
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>

    <!-- /.col -->
</div>







@endsection