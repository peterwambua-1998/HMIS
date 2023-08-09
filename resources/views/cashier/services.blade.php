@extends('template.plain')
@section('content_title')
Patient Services
@endsection


@section('sidebar_content')

@endsection

@section('main_content')
<div class="row">
    <div class="col-md-12">
        <!-- Widget: user widget style 1 -->
        <div class="box box-widget widget-user">
            <!-- Add the bg color to the header using any of the bg-* classes -->
            <div class="widget-user-header bg-aqua-active">
                <h3 class="widget-user-username">NAME : {{ucwords($patient->name)}}</h3>
                <h5 class="widget-user-desc">PATIENT NO : {{$patient->id}}</h5>
                <h5 class="widget-user-desc">PHONE NO : {{$patient->contactnumber}}</h5>
            </div>
            <div class="widget-user-image">
            </div>
        </div>
        <!-- /.widget-user -->

    </div>

</div>

{{--
@if ($clinics=$patient->clinics->count()>0)
<div class="row mb-4">
    <div class="col-md-12">
        <h3>Attending Clinics</h3>
        @foreach ($patient->clinics as $clinic)
        <span style="display:inline-block;font-size:15px" class="mt-2 mb-2 badge bg-navy">{{$clinic->name_eng}}</span>
        @endforeach
    </div>
</div>
@endif
--}}


<div class="row">
    <div class="col-md-12">
       
        <div id="presc" class="box box-success">
            <div class="box-header with-border">
                <h3 class="box-title">Services</h3>

                
            </div>
            <div class="box-body" >
                <ul class="list-group">

                @foreach ($services as $service)
                    
                    <li class="list-group-item my-list">
                        <span style="font-weight: bold">Department: {{$service->department}}</span> <br>
                        <span>Service: {{$service->service}}</span>
                        
                    </li>
                    
                    {{--
                     <li class="list-group-item">{{$service->service}}</li> --}}
                @endforeach
             </ul>

            </div>
        </div>

    </div>
</div>


<style>
    .my-list {
        display: block;
        padding: 9.5px;
        margin: 0 0 10px;
        font-size: 13px;
        line-height: 1.42857143;
        color: #333;
        word-break: break-all;
        word-wrap: break-word;
        background-color: #f5f5f5;
        border: 1px solid #ccc;
        border-radius: 4px;
    }
</style>
@endsection