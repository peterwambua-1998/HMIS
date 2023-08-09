@extends('template.main')

@section('title', $title)

@section('content_title',__("Register New User"))
@section('content_description',__("Add a New User To The System"))
@section('breadcrumbs')

<ol class="breadcrumb">
    <li><a href="{{route('dash')}}"><i class="fas fa-tachometer-alt"></i>Dashboard</a></li>
    <li class="active">Lab Mesaure</li>
</ol>
@endsection

@section('main_content')

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div style="padding:10px;margin-top:4.5vh !important" class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">{{__('Edit Lab Measure Details')}}</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <form method="POST" action="{{ route('measure_update') }}">
                    @csrf
                    <input type="hidden" name="lab_measure_id" value="{{$lab_measure->id}}">
                    <div class="box-body">
                        <div class="form-group">
                            <label for="name">{{__('Measure')}} <span class="text-red">*</span></label>
                            <input id="name" type="text" class="form-control" name="measure" value="{{$lab_measure->measure_name}}" required autofocus>
                        </div>

                        <div class="form-group">
                            <label for="name">{{__('Unit Of Measure')}} <span class="text-red">*</span></label>
                            <input id="unit" type="text" class="form-control" name="unit" value="{{ $lab_measure->unit_of_measurement }}" required>
                        </div>

                        <div class="text-center">
                            <button type="submit" class="btn btn-primary">{{__('Update Measure')}}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection