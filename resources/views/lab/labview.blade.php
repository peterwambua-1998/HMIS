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
{{-- Get measures for the appoinment if any --}}

<div class="row" id="createchannel4">
    <div class="col-xs-12">
        <div class="box box-success">
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
                <p>Doctor Note: <strong>@if($note) {{ $note }} @else n/a @endif</strong></p>
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>
   
    <!-- /.col -->

    <div class="col-xs-12" id="createchannel4">
        <div class="box box-success">
            <div class="box-header">
                <h3 class="box-title">{{__('Lab Test Results Form')}}</h3>
            </div>
            <div class="box-body">
                <form class="form-horizontal" action="{{route('addLab')}}" method="POST" style="padding: 0; margin: 0">
                    <div class="mb-4" style="font-size: 15px; border: 1px solid gray; padding: 20px">
                        @csrf
                        <div class="row">
                            @foreach ($measures as $measure)
                                @if ($measure->measure_id != 0)
                                    <?php
                                        $prev = App\LabMeasureResult::where('appointment_id','=',$appointment->id)->where('measure_id','=', $measure->measure_id)->first();
                                    ?>
                                    <div class="col-md-6">
                                        <label for="">{{$measure->measure_name}} ({{$measure->unit}})</label>
                                        <input required class="form-control" type="text" placeholder="Enter {{$measure->measure_name}}" name="measures[]" @if($prev) value="{{$prev->result}}" @endif><br>
                                        <input type="hidden" name="measure_id[]" value="{{$measure->measure_id}}">
                                    </div>
                                @endif
                            @endforeach
                        </div>
                        
                        <input type="hidden" value="500" name="amount" />
                        <input type="hidden" value="{{ $appointment->id }}" name="appointment_id" />
                        <input type="hidden" value="{{ $appointment->patient_id }}" name="patient_id" />
                        <input type="hidden" value="lab" name="billing_for" />
                        <input type="hidden" value="no" name="completed" />
                        <input type="hidden" value="{{ $appointment->mode_of_payment }}" name="payment_method" />
                    </div>
                    <button type="submit" class="btn btn-success">Submit Results</button>
                </form>
            </div>

        </div>
    </div>

    <div class="col-xs-12">
        <div class="box box-success">
            <div class="box-header">
                <h3 class="box-title">{{__('Lab History')}}</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <div class="row">
                    <div class="col-md-12">
                        @foreach ($lab_history as $history)
                        <div id="presc" class="box box-success collapsed-box">
                            <div class="box-header with-border">
                                <h5 class="box-title" style="font-size: 14px;">Visit On {{$history->created_at->toFormattedDateString()}}</h5>
                
                                <div class="box-tools pull-right">
                                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
                                </div>
                            </div>
                            <div class="box-body" style="display:none">
                                @if ($history->lab_measure_results)
                                    @foreach ($history->lab_measure_results as $result)
                                        <div class="col-md-4">
                                            <?php $ms = App\LabMeasure::where('id','=', $result->measure_id)->first(); ?>
                                            <h5 style="font-weight: bold">{{$ms->measure_name}}</h5>
                                            <h5><span class="text-success">Result</span>: {{$result->result}} ({{$ms->unit_of_measurement}})</h5>
                                        </div>
                                    @endforeach
                                @else
                                    <h5>Did not visit lab</h5>
                                @endif
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
</div>
@endsection