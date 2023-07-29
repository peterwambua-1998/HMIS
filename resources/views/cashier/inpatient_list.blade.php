@extends('template.main')

@section('title', 'in patient list')

@section('content_title',"In Patients")
@section('content_description',__("Discharged In Patients"))

@section('breadcrumbs')

<ol class="breadcrumb">
    <li><a href="{{route('dash')}}"><i class="fas fa-tachometer-alt"></i>Dashboard</a></li>
    <li class="active">Here</li>
</ol>
@endsection

@php
    use App\Patients;
@endphp
@section('main_content')


<div class="row">
    <div class="col-md-1"></div>
    <div class="col-md-10">

        <div class="box box-solid">
            <div class="box-header with-border">
                <h3 class="box-title">In Patient List</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <div id="example1_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                    <div class="row">
                        <div class="col-sm-12">
                            <table id="example1" class="table table-bordered table-striped dataTable" role="grid"
                                aria-describedby="example1_info">
                                <thead>
                                    <tr>
                                        <th>Patient</th>
                                        <th>ID</th>
                                        <th>Department</th>
                                        <th>Payment Method</th>
                                        

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($app as $apps)
                                    <tr>
                                        <td>{{Patients::find($apps->patient_id)->name}}</td>
                                        <td>{{$apps->patient_id}}</td>
                                        <td>{{$apps->department}}</td>
                                        <td>{{ $apps->mode_of_payment }}</td>
                                       


                                    </tr>
                                    @endforeach
                                </tbody>
                                
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.box-body -->
        </div>


    </div>
    <div class="col-md-1"></div>
</div>


@endsection

@section('optional_scripts')
<script>
    $(function () {

        $('#example1').DataTable({
            'paging': true,
            'lengthChange': true,
            'searching': true,
            'ordering': true,
            'info': true,
            'autoWidth': false
        })
    })

</script>

@endsection
