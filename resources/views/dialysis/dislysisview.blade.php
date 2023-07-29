@extends('template.main')

@section('title', $title)

@section('content_title',__("Dialysis"))
@section('content_description',__("Patient Dialysis"))
@section('breadcrumbs')
<ol class="breadcrumb">
    <li><a href="#"><i class="fas fa-tachometer-alt"></i>Dashboard</a></li>
    <li class="active">Here</li>
</ol>

@endsection

@section('main_content')


<div style="padding: 2px;">
<form action="{{ route('addDialysis') }}" method="post">
    @csrf
<div class="row" id="createchannel4" style="background: #303030; height: 20vh; padding: 20px">
    <div class="col-md-4">
        <div class="row">
            <div class="col-md-2">
                <p style="font-size: 18px; color: white">MR #</p>
            </div>
            <div class="col-md-6">
                <input type="text" readonly value="0126782">
            </div>
        </div>

        <div class="row">
            <div class="col-md-3">
                <p style="font-size: 18px; color: white">Reg Date</p>
            </div>
            <div class="col-md-6">
                <input type="text" readonly  value="{{ date('Y-m-d') }}">
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <p style="font-size: 18px; color: white; width: 100%">Blood Group</p>
            </div>
            <div class="col-md-6">
                <input type="text" readonly value="{{$measure->blood_group}}">
            </div>
        </div>

        
    </div>
    <div class="col-md-8">
        <div class="row">
            <div class="col-md-1">
                <p style="font-size: 18px; color: white">Name</p>
            </div>
            <div class="col-md-5">
                <input type="text" name="" readonly id="" value="{{ $search_result[0]->name }}" style="width: 100%; font-size: 18px">
            </div>

            <div class="col-md-1">
                <p style="font-size: 18px; color: white">Age</p>
            </div>
            <div class="col-md-2">
                <input type="text" name="" id="" readonly value="{{ $search_result[0]->getAge() }}" style="width: 100%; font-size: 18px">
            </div>

            <div class="col-md-1">
                <p style="font-size: 18px; color: white">Gender</p>
            </div>
            <div class="col-md-2">
                <input type="text" name="" readonly id="" value="{{ $search_result[0]->sex }}" style="width: 100%; font-size: 18px">
            </div>
        </div>


        <div class="row mt-2">
            <div class="col-md-3">
                <p style="font-size: 18px; color: white">Type Of Renal Failure</p>
            </div>
            <div class="col-md-9">
                <input type="text" value="{{$measure->renal_failure}}" readonly style="font-size: 18px; width: 100%">
            </div>
        </div>

        <div class="row">
            <div class="col-md-3">
                <p style="font-size: 18px; color: white">Diagnosis</p>
            </div>
            <div class="col-md-9">
                <input type="text" value="{{$measure->diagnosis}}" readonly style="font-size: 18px; width: 100%">
            </div>
        </div>
    </div>
    {{--
    <div class="col-xs-1"></div>
    <div class="col-xs-10">
        <div class="box box-info">
            <div class="box-header">
                <h3 class="box-title">{{__('Patient Details')}}</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <p>Patient Name: <span style="font-weight: bold">{{ $search_result[0]->name }}</span></p>
                <p>Patient Telephone: <span style="font-weight: bold">{{ $search_result[0]->telephone }}</span></p>
                
                
                <button class="btn btn-primary" id="addLabResults">Add Dialysis Results</button>
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>
    <div class="col-xs-1"></div>
    <!-- /.col -->
    --}}


</div>


<div class="row mt-3" style="font-size: 18px;border: 1px solid gray; padding: 12px;">
    <div class="col-md-1">Date</div>
    <div class="col-md-3"><input type="text" readonly value="{{ date('Y m d') }}"></div>
    <div class="col-md-2">Special Instructions</div>
    <div class="col-md-6"><input type="text" readonly style="width: 100%" value="{{$measure->note}}"></div>
    
</div>

<div class="row mt-3" style="font-size: 15px; border: 1px solid gray; padding: 12px;">
    <div class="row">
        <div class="col-md-12">
            <p class="pl-5">Pre Dialysis Vitals</p>
        </div>
    </div>
    <div class="row">
        <div class="col-md-1"><label>Bp</label></div>
        <div class="col-md-2"><input type="text" readonly value="{{$measure->pre_bp}}"></div>

        <div class="col-md-1"><label>Weight (Kg)</label></div>
        <div class="col-md-2"><input type="text" readonly value="{{$measure->pre_weight}}"></div>


        <div class="col-md-1"><label>Temp</label></div>
        <div class="col-md-2"><input type="text" readonly value="{{ $measure->pre_temp }}"></div>

        
        
    </div>
</div>

<div class="row mt-3" style="font-size: 15px; border: 1px solid gray; padding: 5px;">
    <div class="col-md-4">
        <div class="row">
            <div class="col-md-12">
                <h3>Start</h3>
                <input type="datetime-local" name="start_time" id="" required>
                <input type="text" placeholder="Doc Name" name="doc_start" required>
            </div>

            <div class="col-md-12">
                <h3>End</h3>
                <input type="datetime-local" name="end_time" id="">
                <input type="text" placeholder="Doc Name" name="doc_end" required>
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="row">
            <div class="col-md-4" style="display: grid; grid-template-columns: 1fr 1fr">
                <label>Bed No:</label><input type="text" name="bed_no" id="" required>
            </div>
            <div class="col-md-5" style="display: grid; grid-template-columns: 1fr 1fr">
                <label>Machine No:</label><input type="text" name="machine_no" id="" required>
            </div>
            
            
        </div>

        <div class="row mt-5">
            <div class="col-md-12">
                <label for="">Dialyzer Type</label>
                <input type="text" style="width: 70%" name="dialyzer_type" required>
            </div>
        </div>


        <div class="row mt-5">
            <div class="col-md-12">
                <h4 for="">Blood Transfusion</h4>
            </div>
            <div class="col-md-4" >
                <label for="">Done</label>
                <input type="text" placeholder="No" name="transfusion_done" required>
            </div>

            <div class="col-md-6" >
                <label for="">No of Bags</label>
                <input type="number" name="num_of_bag_blood" required>
            </div>
        </div>
    </div>
</div>


<div class="row mt-3" style="font-size: 15px; border: 1px solid gray; padding: 12px;">
    <div class="row">
        <div class="col-md-12">
            <p class="pl-5">Post Dialysis Vitals</p>
        </div>
    </div>
    <div class="row">
        <div class="col-md-1">
            <label>Bp</label></div>
        <div class="col-md-2"><input type="text"  name="post_bp" required></div>

        <div class="col-md-1"><label>Weight (Kg)</label></div>
        <div class="col-md-2"><input type="text"  name="post_weight" required></div>


        <div class="col-md-1"><label>Temp</label></div>
        <div class="col-md-2"><input type="text" name="post_temp" required></div>

        
        
    </div>
</div>



<div class="row mt-3" style="font-size: 15px; border: 1px solid gray; padding: 12px;">
    

    <div class="row">
        <div class="col-md-12">
            <label for="">Procedure Summary</label>
            <textarea class="form-control text-capitalize" name="summary" id="summary" cols="160" required
                                rows="5"></textarea>
        </div>

        
    </div>

    <div class="row">
        <div class="col-md-6">
            <h5 style="font-weight: bold">Billing</h5>
            <label for="">Enter Amount To Charge Patient: </label>
            <input type="number" name="amount" required />
        </div>
        
    </div>

    <input type="hidden" name="patient_id" value="{{$search_result[0]->id}}">

    <input type="hidden" value="" name="amount" />
    <input type="hidden" value="{{ $appointment->id }}" name="appointment_id" />
    <input type="hidden" value="dialysis" name="billing_for" />
    <input type="hidden" value="no" name="completed" />
    <input type="hidden" value="{{$appointment->mode_of_payment}}" name="payment_method" />

    <div class="row">
        <div class="col-md-12" style="margin-top: 5%">
            <button class="btn btn-success" type="submit" style="width: 100%">Finish</button>
        </div>
    </div>
    
    

   

</div>

</form>

</div>
{{--

<div class="row" id="myhiddenrow">
    <div class="col-xs-1"></div>

    <div class="col-xs-10">
        <div class="box box-info">
            <div class="box-header">
                <h3 class="box-title">{{__('Lab Results Form')}}</h3>
            </div>
            <div class="box-body">

                <form class="form-horizontal" action="{{route('addDialysis')}}" method="POST">
                    @csrf
                    <label for="">Findings</label>
                    <textarea class="form-control text-capitalize" name="findings" id="diagnosys" cols="73"
                                rows="10"></textarea>

                    <label for="">Recommendation</label>
                    <textarea class="form-control text-capitalize" name="recommendation" id="diagnosys" cols="73"
                                rows="10"></textarea>
                    <br>

                    <input type="hidden" name="patient_id" value="{{$search_result[0]->id}}">

                    <input type="hidden" value="500" name="amount" />
                    <input type="hidden" value="{{ $appointment->id }}" name="appointment_id" />
                    <input type="hidden" value="dialysis" name="billing_for" />
                    <input type="hidden" value="no" name="completed" />
                    <input type="hidden" value="cash" name="payment_method" />

                    <button type="submit" class="btn btn-success">Submit Results</button>
                    

                    
                </form>

            </div>

        </div>
    </div>
    
    

    <div class="col-xs-1"></div>
</div>


<div class="row" id="createchannel4">
    <div class="col-xs-1"></div>
    <div class="col-xs-10">
        <div class="box box-info">
            <div class="box-header">
                <h3 class="box-title">{{__('Dialysis History')}}</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <div class="row">
                    <div class="col-md-12">
                       @foreach ($dialysis as $dialysi)
                           
                       
                        <div id="presc{{ $dialysi->id }}" class="box box-success collapsed-box">
                            <div class="box-header with-border">
                                <h3 class="box-title">Visit On <span>({{ $dialysi->updated_at }})</span></h3>
                
                                <div class="box-tools pull-right">
                                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
                                    </button>
                                    
                                </div>
                            </div>
                            <div class="box-body" style="display:none">
                
                                
                
                                <h4 style="text-decoration: underline">Findings</h4>
                                <h5 class="text-primary" style="font-size:17px;font-weight:600">{{ $dialysi->findings }}</h5>
                                <br>
                                <h4 style="text-decoration: underline">Recommendation</h4>
                                <h5 class="text-primary" style="font-size:17px;font-weight:600">{{ $dialysi->Recommendation }}<small> 
                                    </small></h5>
                
                                
                            </div>
                
                        </div>
                       
                        @endforeach
                    </div>
                </div>
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>
    <div class="col-xs-1"></div>
    <!-- /.col -->
</div>


--}}


<script>
    $('#myhiddenrow').hide();

    $('#addLabResults').on('click', function() {
        $('#myhiddenrow').slideToggle();
    });
</script>

@endsection