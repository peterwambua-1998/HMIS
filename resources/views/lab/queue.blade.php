@extends('template.main')

@section('title', $title)

@section('content_title',__("Create Appoinments"))
@section('content_description',__("Create an appointment for the patient from here !"))
@section('breadcrumbs')

<ol class="breadcrumb">
    <li><a href="{{route('dash')}}"><i class="fas fa-tachometer-alt"></i>Dashboard</a></li>
    <li class="active">Here</li>
</ol>
@endsection
@section('main_content')

<div class="row" id="createchannel4">
    <div class="col-xs-12">
        <div class="box box-success">
            <div class="box-header">
                <h3 class="box-title">{{__('Patients Queue')}}</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <table id="example2" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>{{__('Queue No')}}</th>
                            <th>{{__('Name')}}</th>
                            <th>{{__('Patient No.')}}</th>
                            <th>{{__('Reason')}}</th>
                            <th>Doctor</th>
                            <th>Payment Method</th>
                        </tr>
                    </thead>
                    <tbody>
               
                        @foreach ($qs as $s)
                            <tr>
                                <td>{{$number}}</td>
                                <?php $number++; ?>
                                <td>{{App\Patients::where('id','=', $s->patient_id)->first()->name}}</td>
                                <td>{{$s->patient_id}}</td>
                                <td>{{$s->department}}</td>
                                <?php $app = App\Appointment::find($s->appointment_id); ?>
                                <td>Dr. {{ App\User::where('id', '=', $app->doctor_id)->first()->name }}</td>
                                <td>{{ $app->mode_of_payment }}</td>
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
@endsection