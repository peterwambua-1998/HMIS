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
            <div style="padding:10px;margin-top:4.5vh !important" class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title">{{__('Add Lab Measure')}}</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <form method="POST" action="{{ route('saveMeasure') }}">
                    @csrf
                    <div class="box-body">
                        <div class="form-group">
                            <label for="name">{{__('Test Name')}} <span class="text-red">*</span></label>
                            <input id="name" type="text" class="form-control" name="measure" value="{{ old('measure') }}" required autofocus>
                        </div>

                        <div class="form-group">
                            <label for="name">{{__('Unit Of Measure')}} <span class="text-red">*</span></label>
                            <input id="unit" type="text" class="form-control" name="unit" value="{{ old('unit') }}" required>
                        </div>

                        <div class="form-group">
                            <label for="name">{{__('Price')}} <span class="text-red">*</span></label>
                            <input id="price" type="text" class="form-control" name="price" value="{{ old('price') }}" required>
                        </div>

                        <div class="text-center">
                            <button type="submit" class=" btn btn-primary">{{__('Add Measure')}}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection