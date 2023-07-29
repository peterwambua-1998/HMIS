@extends('template.main')

@section('title', 'Edit In Patient')

@section('content_title',__("In Patient Edit"))
@section('content_description')
@section('breadcrumbs')
<ol class="breadcrumb">
    <li><a href="#"><i class="fas fa-tachometer-alt"></i>Dashboard</a></li>
    <li class="active">Here</li>
</ol>

@endsection

@section('main_content')



<div class="row">
    <!-- right column -->
    <div class="col-md-1"></div>
    <div class="col-md-10">
        <!-- Horizontal Form -->
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">{{__('Patient Registration Form')}}</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form method="post" action="{{ route('inptienteditsave', $inpatient->patient_id) }}" class="form-horizontal">
                {{csrf_field()}}

                @method('PATCH')
                <div class="box-body">
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 control-label">{{__('Full Name')}} </label>
                        <div class="col-sm-10">
                            <input type="text" minlength="10" pattern="^[a-zA-Z]+(([',. -][a-zA-Z ])?[a-zA-Z]*)*$"
                                required class="form-control" name="inpname" readonly value="{{ $inpatient->patient_name }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 control-label">{{__('ID Number')}}</label>
                        <div class="col-sm-10">
                            <input type="text"  maxlength="12"
                                class="form-control" name="inpid" readonly value="{{$inpatient->patientidnumber}}">
                        </div>
                    </div>
                    
                    

                    <div class="form-group">
                        <label for="" class="col-sm-2 control-label">{{ __('Ward Type') }}</label>
                        <div class="col-sm-10">
                            <select class="form-control" id="selectdoc" name="ward_id" required>
                                @foreach ($wards as $ward)
                                
                                    <option @if($ward->id == $inpatient->ward_id) selected  @endif value="{{ $ward->id }}">{{ $ward->ward_title }}</option>
                                    
                                @endforeach
                                
                                
                                
                            </select>
                        </div>
                    </div>

                    <!-- select -->
                    <div class="form-group">
                        <label class="col-sm-2 control-label">{{__('Bed Number')}}</label>
                        <div class="col-sm-2 mr-0 pr-0">
                            <input type="text" name="bed_no" value="{{$inpatient->bed_no}}" class="form-control">
                        </div>

                        


                        
                    </div>

                    
                    <input type="hidden" name="appointment_id" value="{{ $inpatient->appointment_id}}">
                    <div class="box-footer">
                        
                        <input type="submit" class="btn btn-success pull-right" value="{{__('Save')}}">
                        <a href="{{ route('inpatientqueue') }}" class="btn btn-default">Cancel</a>
                        {{--<input type="reset" class="btn btn-default" value="{{__('Cancel')}}">--}}
                    </div>
                    <!-- /.box-footer -->
                </div>
            </form>

            



           

        </div>
    </div>
    <div class="col-md-1"></div>
</div>






@endsection