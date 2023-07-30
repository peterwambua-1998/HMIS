@extends('template.main')

@section('title', 'Inventory')

@section('content_title',"Inventory")
@section('content_description',"medicine table")
@section('breadcrumbs')

<ol class="breadcrumb">
    <li><a href="{{route('dash')}}"><i class="fas fa-tachometer-alt"></i>Dashboard</a></li>
    <li class="active">Here</li>
</ol>
@endsection

<style>
    .edit:hover {
        cursor: pointer;
    }
</style>

@section('main_content')
<section class="content">
<div class="row">
    <div class="col-md-12">
        @if (Session::has('success'))
            <div class="alert alert-success" role="alert" id="success">
                {{Session::get('success')}}
            </div>
        @endif

        @if (Session::has('unsuccess'))
            <div class="alert alert-danger" role="alert" id="danger">
                {{Session::get('unsuccess')}}
            </div> 
        @endif
    </div>
</div>

<div class="row">
    <div class="col-xs-12">
        <div class="box box-success">
            <div class="box-header">
                <h3 class="box-title">Medicine Inventory</h3>
            </div>
            
            <div class="box-body">
                <table id="medTable" class="table table-bordered table-hover table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Unit Of Measure</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $number = 1; ?>
                        @foreach ($lab_measures as $lab_measure)
                            <tr>
                                <td>{{$number}}</td>
                                <?php $number++; ?>
                                <td>{{$lab_measure->measure_name}}</td>
                                <td>{{$lab_measure->unit_of_measurement}}</td>
                                <td><a href="{{route('measure_edit', $lab_measure->id)}}">Edit</a></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
</section>



<script defer>
    $(document).ready( function () {
        $('#medTable').DataTable();
    });
</script>

@endsection