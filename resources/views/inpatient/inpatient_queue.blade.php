@extends('template.main')

@section('title', 'In Patient List')

@section('content_title',__("In Patient"))
@section('content_description')
@section('breadcrumbs')
<ol class="breadcrumb">
    <li><a href="#"><i class="fas fa-tachometer-alt"></i>Dashboard</a></li>
    <li class="active">Here</li>
</ol>

@endsection

@section('main_content')


<div class="row">
    
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">{{__('In Patient List')}}</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <table id="inpatientTable" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            
                            <th>{{__('Name')}}</th>
                            <th>{{__('Patient No.')}}</th>
                            
                            
                            <th>{{__('Ward')}}</th>
                            <th>{{__('Wing')}}</th>
                            <th>{{__('Bed No')}}</th>

                            <th>{{__('Condition')}}</th>

                            <th>{{__('Current Department')}}</th>

                            <th>{{__('Payment Method')}}</th>

                            <th>Date Admitted</th>
                            
                           <th>Doctor In Charge</th>

                           <th>Edit</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($inpatient_appointments as $app)
                            
                            @if ($app->discharged == 'NO')
                                <tr>
                                    
                                    @php
                                    $appointment = App\Appointment::where('id', '=', $app->appointment_id)->get()->last();

                                    $inpat = App\inpatient::where('patient_id', '=', $app->patient_id)->where('appointment_id', '=', $app->appointment_id)->first();
                                    @endphp
                                        
                                    <td>{{$inpat->patient_name}}</td>
                                    <td >{{$app->patient_id}} <button onclick="myCopy({{$app->patient_id}})">copy</button></td>
                                    
                                    
                                    <td>{{ App\Ward::where('id', '=', $app->ward_id)->first()->ward_title }}</td>
                                    <td>Wing {{ App\Ward::where('id', '=', $app->ward_id)->first()->wing }}</td>
                                    
                                    <td>{{ $inpat->bed_no }}</td>
                                    
                                    <td>{{ $app->condition }}</td>

                                    <td>{{ $appointment->department}}</td>

                                    <td>{{ $appointment->mode_of_payment}}</td>

                                    <td>{{ $appointment->created_at }}</td>

                                    <td>{{ $app->approved_doctor }}</td>

                                    <td>
                                        <form action="{{ route('inptientedit', $app->patient_id) }}" method="post">
                                            @csrf
                                            <input type="hidden" name="appointment_id" value="{{$app->appointment_id}}">
                                            <button type="submit" class="btn btn-success" style="align-items: center">
                                                edit
                                            </button>
                                        </form>
                                        
                                    </td>
                                </tr>
                            @endif
                            
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
<!-- /.row -->
<!-- /.content -->



@if(Session::has('error'))

<div class="row myerror">
    <div class="col-md-1"></div>
        <div class="col-md-10">
            <div class="small-box bg-red">
                <div class="inner">
                    <h3>{{ Session::get('error') }}</h3>
                    <p>Sytem Warning</p>
                </div>
                <div class="icon">
                    <i class="ion ion-pie-graph"></i>
                </div>
            </div>
        </div>
    <div class="col-md-1"></div>
</div>

@endif

<script>
    /*
    document.getElementById("keyword").placeholder ="Enter Patient Number";

    function changeFunc(txt){
        document.getElementById("keyword").placeholder ="Enter Patient " +txt;
    }

    if ("{{Session::has('error')}}") {
        setTimeout(() => {
            $('.myerror').fadeOut();
        }, 5000);
    }
    */

    $(function () {



        $('#inpatientTable').DataTable({
            'paging': true,
           
            'searching': true,
            'ordering': true,
            'info': true,
            'autoWidth': false,
            
        })
    });


    function myCopy(copytext) {

        console.log(copytext);
        navigator.clipboard.writeText(copytext);

        alert("Copied the text: " + copytext);
    }
</script>

@endsection