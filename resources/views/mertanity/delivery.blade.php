@extends('template.main')

@section('title', $title)

@section('content_title',__('Delivery Form'))
@section('content_description',__('Delivery Form.'))
@section('breadcrumbs')

<ol class="breadcrumb">
    <li><a href="{{route('dash')}}"><i class="fas fa-tachometer-alt"></i>Dashboard</a></li>
    <li class="active">Here</li>
</ol>
@endsection

@section('main_content')
{{--  patient registration  --}}

<div @if (session()->has('regpsuccess') || session()->has('regpfail')) style="margin-bottom:0;margin-top:3vh" @else
    style="margin-bottom:0;margin-top:8vh" @endif class="row">
    <div class="col-md-1"></div>
    <div class="col-md-10">
        @if (session()->has('regpsuccess'))
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h4><i class="icon fa fa-check"></i> Success!</h4>
            {{session()->get('regpsuccess')}}
        </div>
        @endif
        @if (session()->has('regpfail'))
        <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h4><i class="icon fa fa-ban"></i> Error!</h4>
            {{session()->get('regpfail')}}
        </div>
        @endif

    </div>
    <div class="col-md-1"></div>

</div>



<div class="box box-info" id="reginpatient2">
    <div class="box-header with-border">
        <h3 class="box-title">{{__('Delivery Form')}}</h3>
    </div>
    <!-- /.box-header -->
    <!-- form start -->
    <form method="post" action="{{ route('savedeliveryinfo') }}" class="form-horizontal">
        {{csrf_field()}}
        <div class="box-body">
            <div class="box-header with-border" style="text-align: center">
                <h3 class="box-title">{{__('Mother Details')}}</h3>
            </div>

            <br>

            <div class="form-group">
                <label for="duration_of_labour" class="col-sm-2 control-label">{{__('Duration of labour')}}<span style="color:red">*</span></label></label></label>
                <div class="col-sm-2">
                    <input type="text" required  class="form-control" name="duration_of_labour" id="duration_of_labour">
                </div>
            </div>

            <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label">{{__('date_of_delivery')}}<span style="color:red">*</span></label>
                <div class="col-sm-10">
                    <input type="date" required  class="form-control" name="date_of_delivery" id="date_of_delivery"
                        >
                </div>
            </div>

            <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label">{{__('Duration of labour')}}<span style="color:red">*</span></label>
                <div class="col-sm-10">
                    <input type="text" required  class="form-control" name="duration_of_labour" id="duration_of_labour"
                        placeholder="Duration of labour">
                </div>
            </div>

            <div class="form-group">
                <label for="inputPassword3" class="col-sm-2 control-label">{{__('Time of Delivery')}}<span style="color:red">*</span></label>
                <div class="col-sm-10">
                    <input type="time" required  class="form-control" name="time_of_delivery" id="time_of_delivery"
                        >
                </div>
            </div>

            <div class="form-group">
                <label for="inputPassword3" class="col-sm-2 control-label">{{__('Gestation at birth (in weeks)')}}</label>
                <div class="col-sm-10">
                    <input type="text"  class="form-control" name="gestation_at_birth" id="gestation_at_birth"
                        placeholder="Gestation at birth in weeks">
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-2 control-label">{{__('Mode of delivery')}}<span style="color:red">*</span></label>
                <div class="col-sm-2">
                    <select required class="form-control" name="mode_of_delivery">
                        <option selected value="SVD">SVD</option>
                        <option value="CS">CS</option>
                        <option value="BREECH">BREECH</option>
                        <option value="AVD">AVD</option>
                        
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label for="inputPassword3" class="col-sm-2 control-label">{{__('Number of babies delivered')}}</label>
                <div class="col-sm-10">
                    <input type="text"  class="form-control" name="num_of_babies_delivered" id="num_of_babies_delivered"
                        placeholder="Number of babies delivered">
                </div>
            </div>

            
            <div class="form-group">
                <label class="col-sm-2 control-label">{{__('Placenta Complete')}}<span style="color:red">*</span></label>
                <div class="col-sm-2">
                    <select required class="form-control" name="placenta_complete">
                        <option selected value="yes">YES</option>
                        <option value="no">NO</option>
                        <option value="bba">BBA</option>
                       
                        
                    </select>
                </div>
            </div>


            <div class="form-group">
                <label class="col-sm-2 control-label">{{__('Uterotonic given')}}<span style="color:red">*</span></label>
                <div class="col-sm-2">
                    <select required class="form-control" name="uterotonic_given">
                        <option selected value="oxytocin">Oxytocin</option>
                        <option value="carbetocin">Carbetocin</option>
                        <option value="none">None</option>
                       
                        
                    </select>
                </div>
            </div>


            <div class="form-group">
                <label class="col-sm-2 control-label">{{__('Vaginal examination')}}<span style="color:red">*</span></label>
                <div class="col-sm-2">
                    <select required class="form-control" name="vaginal_examination">
                        <option selected value="Normal">Normal</option>
                        <option value="Episiotomy">Episiotomy</option>
                        <option value="Vaginal tear">Vaginal tear</option>
                        <option value="FGM">FGM</option>
                        <option value="Vaginal warts">Vaginal warts</option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label for="inputPassword3" class="col-sm-2 control-label">{{__('Blood loss (mls)')}}</label>
                <div class="col-sm-10">
                    <input type="text"  class="form-control" name="blood_loss" id="blood_loss"
                        placeholder="Blood Loss in (mls)">
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-2 control-label">{{__('Vaginal examination')}}<span style="color:red">*</span></label>
                <div class="col-sm-2">
                    <select required class="form-control" name="mother_status">
                        <option selected value="dead">Dead</option>
                        <option value="alive">Alive</option>
                        
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label for="inputPassword3" class="col-sm-2 control-label">{{__('Delivery complications')}}</label>
                <div class="col-sm-10">
                    <input type="text"  class="form-control" name="delivery_complications" id="delivery_complications"
                        placeholder="Delivery complications">
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-2 control-label">{{__('HIV Status for mother')}}<span style="color:red">*</span></label>
                <div class="col-sm-2">
                    <select required class="form-control" name="HIV_status_mother">
                        <option selected value="Positive">Positive</option>
                        <option value="Negative">Negative</option>
                        
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">{{__('Counselled on infant feeding')}}<span style="color:red">*</span></label>
                <div class="col-sm-2">
                    <select required class="form-control" name="Counselled_on_infant_feeding">
                        <option selected value="YES">YES</option>
                        <option  value="NO">NO</option>
                        
                    </select>
                </div>
            </div>


            
            <div class="box-header with-border" style="text-align: center">
                <h3 class="box-title">{{__('Baby Details')}}</h3>
            </div>
            <br>

            <div class="form-group">
                <label for="inputPassword3" class="col-sm-2 control-label">{{__('APGAR Score')}}</label>
                <div class="col-sm-10">
                    <input type="text"  class="form-control" name="APGAR_Score" id="APGAR_Score"
                        placeholder="APGAR Score">
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-2 control-label">{{__('Birth Outcome')}}<span style="color:red">*</span></label>
                <div class="col-sm-2">
                    <select required class="form-control" name="birth_outcome">
                        <option selected value="LB">LB</option>
                        <option value="FSB">FSB</option>
                        <option value="MSB">MSB</option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label for="inputPassword3" class="col-sm-2 control-label">{{__('Birth Weight (Kg)')}}</label>
                <div class="col-sm-10">
                    <input type="text"  class="form-control" name="birth_weight" id="birth_weight"
                        placeholder="Birth Weight">
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-2 control-label">{{__('Sex')}}<span style="color:red">*</span></label>
                <div class="col-sm-10">
                    <select required disabled class="form-control" name="sex" id="sex">
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-2 control-label">{{__('TEO given at birth')}}<span style="color:red">*</span></label>
                <div class="col-sm-2">
                    <select required class="form-control" name="TEO_given_at_birth">
                        <option selected value="YES">YES</option>
                        <option value="NO">NO</option>
                        
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-2 control-label">{{__('Chlorhexidine applied on cord stump')}}<span style="color:red">*</span></label>
                <div class="col-sm-2">
                    <select required class="form-control" name="chlorhexidine_applied_on_cord_stump">
                        <option selected value="YES">YES</option>
                        <option value="NO">NO</option>
                        
                    </select>
                </div>
            </div>


            <div class="form-group">
                <label class="col-sm-2 control-label">{{__('Birth with deformities')}}<span style="color:red">*</span></label>
                <div class="col-sm-2">
                    <select required class="form-control" name="birth_with_deformities">
                        <option  value="YES">YES</option>
                        <option selected value="NO">NO</option>
                        
                    </select>
                </div>
            </div>


            <div class="form-group">
                <label class="col-sm-2 control-label">{{__('Vitamin K Given')}}<span style="color:red">*</span></label>
                <div class="col-sm-2">
                    <select required class="form-control" name="vitamin_k_given">
                        <option selected value="YES">YES</option>
                        <option  value="NO">NO</option>
                        
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-2 control-label">{{__('VDRL RPR results')}}<span style="color:red">*</span></label>
                <div class="col-sm-2">
                    <select required class="form-control" name="VDRL_RPR_results">
                        <option  value="positive">positive</option>
                        <option selected value="negative">negative</option>
                        
                    </select>
                </div>
            </div>


            <div class="form-group">
                <label class="col-sm-2 control-label">{{__('HIV status baby')}}<span style="color:red">*</span></label>
                <div class="col-sm-2">
                    <select required class="form-control" name="HIV_status_baby">
                        <option  value="positive">positive</option>
                        <option selected value="negative">negative</option>
                        
                    </select>
                </div>
            </div>


            <div class="form-group">
                <label class="col-sm-2 control-label">{{__('ARV prophylaxis issued')}}<span style="color:red">*</span></label>
                <div class="col-sm-2">
                    <select required class="form-control" name="ARV_prophylaxis">
                        <option selected value="YES">YES</option>
                        <option  value="NO">NO</option>
                        
                    </select>
                </div>
            </div>


            <div class="form-group">
                <label class="col-sm-2 control-label">{{__('CTX to mother')}}<span style="color:red">*</span></label>
                <div class="col-sm-2">
                    <select required class="form-control" name="ARV_prophylaxis">
                        <option selected value="YES">YES</option>
                        <option  value="NO">NO</option>
                        <option  value="N/A">N/A</option>
                    </select>
                </div>
            </div>


            <div class="box-header with-border" style="text-align: center">
                <h3 class="box-title">{{__('Partner Details')}}</h3>
            </div>
            <br>

            <div class="form-group">
                <label class="col-sm-2 control-label">{{__('Tested for HIV')}}<span style="color:red">*</span></label>
                <div class="col-sm-2">
                    <select required class="form-control" name="tested_for_hiv">
                        <option selected value="YES">YES</option>
                        <option  value="NO">NO</option>
                        <option  value="N/A">N/A</option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-2 control-label">{{__('HIV Results Partner')}}<span style="color:red">*</span></label>
                <div class="col-sm-2">
                    <select required class="form-control" name="hiv_results">
                        <option  value="positive">positive</option>
                        <option selected value="negative">negative</option>
                        
                    </select>
                </div>
            </div>



            <div class="box-header with-border" style="text-align: center">
                <h3 class="box-title">{{__('Doctor Details')}}</h3>
            </div>
            <br>

            <div class="form-group">
                <label for="inputPassword3" class="col-sm-2 control-label">{{__('Delivery Conducted by')}}</label>
                <div class="col-sm-10">
                    <input type="text"  class="form-control" name="delivery_conducted_by" id="delivery_conducted_by"
                        >
                </div>
            </div>
            <!-- select -->
            
        <!-- /.box-body -->

        <input type="hidden" name="patient_id" value="{{$appointment->patient_id}}">
        <input type="hidden" name="appointment_id" value="{{$appointment->id}}">
        <div class="box-footer">
            <input type="submit" class="btn btn-info pull-right" value="Register">
            <input type="reset" class="btn btn-default" value="Cancel">
        </div>

</div>
</form>








@endsection
