@extends('template.main')

@section('title', $title)

@section('content_title',__("Radiology Panel"))

@section('breadcrumbs')
<ol class="breadcrumb">
    <li><a href="#"><i class="fas fa-tachometer-alt"></i>Dashboard</a></li>
    <li class="active">Here</li>
</ol>

@endsection

@section('main_content')

<div class="row" id="createchannel4">
    <div class="col-xs-12">
        <div class="box box-success">
            <div class="box-header">
                <h3 class="box-title">{{__('Patient Details:')}}</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <div class="mb-4" style="display: grid; grid-template-columns: 1fr 1fr; font-size: 15px; grid-row-gap: 12px; border: 1px solid gray; padding: 20px">
                    <p>Patient Name: <span style="font-weight: bold">{{ $search_result->name }}</span></p>
                    <p>Patient Telephone: <span style="font-weight: bold">{{ $search_result->telephone }}</span></p>
                    <p>DOB: <span style="font-weight: bold">{{ $search_result->bod }}</span>
                    <p>Current Doctor: <span style="font-weight: bold">{{ $docs->name }}</span></p>
                        @foreach ($measures as $item)
                            @if ($item->measure_id)
                            <div style="display: flex">
                                <p>Surgery Requested:</p>
                                <p style="font-weight: bold">{{App\SurgaryService::where('id',$item->measure_id)->first()->name}}</p>
                            </div>
                            @endif
                        @endforeach
                    
                    <p>Doctors Note: <span style="font-weight: bold">{{$note}}</span></p>
                </div>
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>
    <div class="col-xs-12">
        <div class="box box-success">
            <div class="box-header">
                <h3 class="box-title">{{__('Surgery Results Report:')}}</h3>
            </div>
            @if($measures->count() > 0)
            <div class="box-body">
                <div style="border: 1px solid gray; padding: 20px">
                    
                    <form class="form-horizontal" action="{{route('surgeryStore')}}" method="POST">
                        @csrf
                        @foreach ($measures as $item)
                        <div class="row">
                            <div class="row ">
                                
                                <div class="col-md-12">
                                    <div style="display: grid; grid-template-rows: 14% 1fr">
                                    <label for="">Enter Surgery Report:</label>
                                    <textarea name="measures_results[]" id="" cols="30" rows="10" class="form-control"></textarea>
                                    </div>
                                </div>
                                <input type="hidden" name="measure_id[]" value="{{$item->measure_id}}">
                            </div>
                            <br>
                        </div>
                        
                        @endforeach

                        <div class="row">
                            <div class="col-md-12">
                                <label for="">Send to:</label>
                                <option value="consultation"></option>
                            </div>
                        </div>
                        
                        <input type="hidden" value="2000" name="amount" />
                        <input type="hidden" value="{{ $appointment->id }}" name="appointment_id" />
                        <input type="hidden" value="{{ $appointment->patient_id }}" name="patient_id" />
                        <input type="hidden" value="radiology and imaging" name="billing_for" />
                        <input type="hidden" value="no" name="completed" />
                        <input type="hidden" value="{{ $appointment->mode_of_payment }}" name="payment_method" />
                        <button type="submit" class="btn btn-success">Submit Results</button>
                    </form>
                </div>
            </div>
            @else
            <div class="p-4">
                <div class="alert alert-danger">
                    <h5>Patient not sent to surgery</h5>
                </div>
            </div>
            
            @endif

        </div>
    </div>
    <!-- /.col -->
</div>
<div class="row" id="createchannel4">
    
</div>    



<script>
    $('#myhiddenrow').hide();

    $('#addLabResults').on('click', function() {
        $('#myhiddenrow').slideToggle();
    });
</script>

@endsection