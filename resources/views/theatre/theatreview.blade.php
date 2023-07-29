@extends('template.main')

@section('title', 'Theatre')

@section('content_title',__("Patient Theatre"))

@section('breadcrumbs')
<ol class="breadcrumb">
    <li><a href="#"><i class="fas fa-tachometer-alt"></i>Dashboard</a></li>
    <li class="active">Here</li>
</ol>

@endsection

@section('main_content')

<div class="row" id="createchannel4">
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
                
                <p>Start Time: {{$measures->start_time}}</p>

                <p>Procedure: {{ $measures->measrure_1 }}</p>

                <p>Surgon: {{ $measures->surgon }}</p>

                <p>Doc Note: {{ $measures->note }}</p>
                <button class="btn btn-primary" id="addLabResults">Add Theatre Results</button>
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>
    <div class="col-xs-1"></div>
    <!-- /.col -->
</div>

<div class="row" id="myhiddenrow">
    <div class="col-xs-1"></div>

    <div class="col-xs-10">
        <div class="box box-info">
            <div class="box-header">
                <h3 class="box-title">{{__('Theatre Results Form')}}</h3>
            </div>
            <div class="box-body">

                <form class="form-horizontal" action="{{route('addtheatre')}}" method="POST">

                   

                    @csrf

                    
                        <label for="">Anesthesia Given</label>
                        <br>
                       <input type="text" name="anesthesia" id="" placeholder="Enter Anesthesia Given" class="form-control">
                    
                    
                    <br>



                    
                    <label for="">Procedure Summary</label>
                    <textarea class="form-control text-capitalize" name="summary" id="diagnosys" cols="73"
                                rows="10"></textarea>
                    <br>

                
                        <label for="dis3" class="control-label">{{__('Note')}}</label>
                        
                            <textarea class="form-control" name="theatre_note" id="dis3" rows="3" cols="100"
                                placeholder="Enter note"></textarea>
                        
                    

                    <br>

                    <label for="">Enter End Time</label>

                    <input type="time" name="end_time" id="" class="form-control">

                    <br>


                    <label for="">Patient Status</label>
                    <input type="text" name="status" id="" class="form-control" placeholder="Enter Patient Status">

                    <br>

                    
                    <label for="">Enter Amount To Be Payed</label>
                    <input type="number" placeholder="Amount" class="form-control" name="amount">




                    
                    

                    <input type="hidden" name="patient_id" value="{{$search_result[0]->id}}">

                    <input type="hidden" value="{{ $appointment->id }}" name="appointment_id" />
                    
                    <input type="hidden" value="{{ $measures->start_time }}" name="start_time" />
                    <input type="hidden" value="theatre" name="billing_for" />
                    <input type="hidden" value="no" name="completed" />
                    <input type="hidden" name="payment_method" value="{{$appointment->mode_of_payment}}">
                    
                    <br>

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
                <h3 class="box-title">{{__('Theatre History')}}</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <div class="row">
                    <div class="col-md-12">
                       @foreach ($theatre as $dialysi)
                           
                       
                        <div id="presc{{ $dialysi->id }}" class="box box-success collapsed-box">
                            <div class="box-header with-border">
                                <h3 class="box-title">Visit On <span>({{ $dialysi->updated_at }})</span></h3>
                
                                <div class="box-tools pull-right">
                                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
                                    </button>
                                    
                                </div>
                            </div>
                            <div class="box-body" style="display:none">
                
                                
                
                                <h4 style="text-decoration: underline">Procedure Summary</h4>
                                <h5 class="text-primary" style="font-size:17px;font-weight:600">{{ $dialysi->summary }}</h5>
                                <br>
                                <h4 style="text-decoration: underline">Start/End Time</h4>
                                <h5 class="text-primary" style="font-size:17px;font-weight:600">{{$measures->start_time}} - {{$measures->end_time}}<small> 
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





<script>
    $('#myhiddenrow').hide();

    $('#addLabResults').on('click', function() {
        $('#myhiddenrow').slideToggle();
    });
</script>

@endsection