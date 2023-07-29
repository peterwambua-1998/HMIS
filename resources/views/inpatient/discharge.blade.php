@extends('template.main')

@section('title', 'Discharged Patients List')

@section('content_title',__("Discharged Patients List"))
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
                <h3 class="box-title">{{__('Discharged Patients List')}}</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <table id="inpatientTable" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            
                            <th>{{__('Name')}}</th>
                            <th>{{__('Patient No.')}}</th>
                            
                            
                            <th>{{__('Address')}}</th>
                            <th>{{__('Telephone')}}</th>
                            <th>{{__('Discharge Status')}}</th>

                            <th>{{__('Certified by')}}</th>

                            <th>{{__('Referred To')}}</th>

                            <th>{{__('Dischage Date')}}</th>

                            <th>{{__('Date and Time Diseased')}}</th>

                            <th>{{__('Date and Time To Atted Clinic')}}</th>

                            
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($patients as $app)
                            @php
                            $appointment = App\Appointment::where('id', '=', $app->appointment_id)->get()->last();

                            $inpat = App\Patients::where('id', '=', $app->patient_id)->first();
                            @endphp
                            
                            <td>{{$app->patient_name}}</td>
                            <td>{{$app->patient_id}}</td>
                            <td>{{$inpat->address}}</td>
                            <td>{{$inpat->contactnumber}}</td>
                            <td>{{$app->discharge_status}}</td>
                            <td>{{$app->certified_officer}}</td>
                            <td>{{$app->reffered_to}}</td>
                            <td>{{$app->discharged_date}}</td>
                            <td>{{$app->if_diseased}}</td>
                            <td>{{$app->if_toattendclinic}}</td>
                            
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


</script>

@endsection