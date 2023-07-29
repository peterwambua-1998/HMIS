@extends('template.main')

@section('title', $title)

@section('content_title',__("Triage"))

@section('breadcrumbs')
<ol class="breadcrumb">
    <li><a href="#"><i class="fas fa-tachometer-alt"></i>Dashboard</a></li>
    <li class="active">Here</li>
</ol>

@endsection

@section('main_content')

@if(Session::has('success_message'))

<div class="row">

    <div class="col-md-12">
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h4><i class="icon fa fa-check"></i> Success!</h4>

            <h4>{{session()->get('success_message')}}</h4>
            
            {{---
            <button
                onclick="window.open('{{route('pregcard',session()->get('pid'))}}','myWin','scrollbars=yes,width=830,height=500,location=no').focus();"
                class="btn btn-warning ml-5"><i class="fas fa-print"></i> Print Registration Card </button>
            {{session()->get('regpsuccess')}}
            --}}
        </div>
    </div>
    
</div>

@endif


<div class="row" id="createchannel4">
 
    <div class="col-xs-12">
        <div class="box box-success">
            <div class="box-header">
                <h3 class="box-title">{{__('Patient Details')}}</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <div style="display: grid; grid-template-columns: 1fr 1fr; font-size: 15px; border: 1px solid gray; padding: 20px">
                    <p>Patient ID: <span style="font-weight: bold">{{ $search_result->id }}</span></p>
                    <p>Patient Name: <span style="font-weight: bold">{{ $search_result->name }}</span></p>
                    <p>Patient Telephone: <span style="font-weight: bold">{{ $search_result->telephone }}</span></p>
                    <p>DOB: <span style="font-weight: bold">{{ $search_result->bod }}</span>
                    <p>Current Doctor: <span style="font-weight: bold">{{ $doctor->name }}</span></p>
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
        <div class="box box-success">
            <div class="box-header">
                <h3 class="box-title">{{__('Triage History')}}</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <form class="form-horizontal" action="{{route('addTriage')}}" method="POST">
                    @csrf
                    <input class="form-control" type="hidden" name="patient_id" value="{{ $search_result->id }}">

                    <div class="row">
                        <div class="col-md-6">
                            <label class="control-label" for="" >Weight</label>
                            <input class="form-control" type="text" placeholder="Enter Weight" name="weight" required>
                        </div>
                        <div class="col-md-6">
                            <label class="control-label" for="" >Temperature</label>

                            <input class="form-control" type="text" placeholder="Enter Temperature" name="temp" required> <br>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <label class="control-label" for="" >Blood Pressure</label>

                            <input class="form-control" type="text" placeholder="Enter Blood Pressure" name="blood_pressure" required><br> 
                        </div>
                        <div class="col-md-6">
                            <label class="control-label" for="" >Brief History</label>
                            <input class="form-control" type="text" placeholder="Enter Brief History" name="history" required><br> 
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <label class="control-label" for="" >Allergies</label>
                            <input class="form-control" type="text" placeholder="Enter Allergies if any" name="allergies"><br> 
                        </div>
                        <div class="col-md-6">
                            <label class="control-label" for="" >Send To:</label>
                            <div >
                                <select class="form-control" id="selectDept" name="department" required>
                                    <option selected>consultation</option>
                                    <option>dentist</option>
                                    <option>lab</option>
                                    <option>physiotherapy</option>
                                    <option>counselling</option>
                                    <option>antenatal</option>
                                    
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <label class="control-label" for="">Select Doctor:</label>
                            <div>
                                <select class="form-control" id="selectdoc" name="docname" required>
                                    @foreach ($docs as $doc)
                                    
                                        <option @if($doctor->id == $doc->id) selected  @endif value="{{ $doc->id }}">{{ $doc->name }} - {{ substr($doc->user_type, 7) }}</option>
                                        
                                    @endforeach
                                    
                                    
                                    
                                </select>
                            </div>
                        </div>
                    </div>

                    

                    
                    

                    
                       
                    
                
                    <br>
                    <input type="hidden" name="app_id" value="{{ $appointment->id }}">

                    <button type="submit" class="btn btn-block btn-success">Submit Results</button>
                </form>
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>
    
    <!-- /.col -->
</div>

<div class="row" id="createchannel4">
    
    <div class="col-xs-12">
        <div class="box box-success">
            <div class="box-header">
                <h3 class="box-title">{{__('Triage Results Form')}}</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <table id="example2" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Date / Time</th>
                            <th>Blood Pressure</th>
                            <th>Weight</th>
                            <th>Temp</th>
                            <th>Allergies</th>
                            <th>History</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($triage as $app)
                        <tr>
                            <td>{{$app->created_at}}</td>
                            <td>{{$app->blood_pressure}}</td>
                            <td>{{$app->weight}}</td>
                            <td>{{$app->temp}}</td>
                            <td>{{$app->allergies}}</td>
                            <td>{{$app->history}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    

                </table>
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>
   
    <!-- /.col -->
</div>







<script>
$('#myhiddenrowtriage').hide();

$('#addTriageResults').on('click', function() {
    $('#myhiddenrowtriage').slideToggle();
});
</script>

@endsection