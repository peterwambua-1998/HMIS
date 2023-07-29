@extends('template.main')

@section('title', $title)

@section('optional_scripts')
@endsection

@section('content_title',__('Check In Patient'))


@if ($user->user_type == 'consultation')
    @section('content_description',__('Consultation'))  
@endif

@if ($user->user_type == 'dentist')
    @section('content_description',__('Dentist'))  
@endif


@if ($user->user_type == 'doctor')
    @section('content_description',__('Check Patient here and update history from here !'))  
@endif


@if ($user->user_type == 'physiotherapy')
    @section('content_description',__('Check Patient here and update physiotherapy from here !'))  
@endif


@section('breadcrumbs')

<ol class="breadcrumb">
    <li><a href="{{route('dash')}}"><i class="fas fa-tachometer-alt"></i>Dashboard</a></li>
    <li class="active">Here</li>
</ol>
@endsection
@section('main_content')


<script src="js/typeahead/typeahead.bundle.js"></script>
{{-- <script src="js/typeahead/typeahead.jquery.js"></script> --}}
<script src="js/typeahead/bloodhound.js"></script>


<div id="remove_on_admit">
<div class="row">

    <div class="col-md-6">
        <div style="height:46.5vh;overflow-y:scroll;overflow-x:hidden;" class="mt-2 mb-1 box box-dark">
            <div class="box-header with-border">
                <h3 class="box-title"> <i class="fas fa-notes-medical"></i>&nbsp; InPatient's Details</h3>
            </div>
            <div class="box-body">
                
                <h4>Name : {{$pName}}</h4>
                <h4>Age : {{$pAge}}</h4>
                <h4>Sex : {{$pSex}}</h4>
                
                
                @if ($triage !== null)
                <hr>

                <h3 class="box-title">
                    Triage Results
                </h3>
                <h4>
                    Blood Pressure :
                    <span class="h4 @if ($triage->blood_pressure>130) text-red @elseif ($triage->blood_pressure>125 ) text-yellow @else text-green @endif ">
                        {{ $triage->blood_pressure }} mmHg <small> ({{ date_format($triage->created_at, 'M d Y H:i:s') }}) </small>
                    </span>
                </h4>
                
                
                <h4>
                    Weight : <span class="text-green">{{ $triage->weight }} Kg <small> ({{ date_format($triage->created_at, 'M d Y H:i:s') }}) </small></span>
                </h4>
                <h4>
                    Temp : <span class="@if ($triage->temp>37.2) text-red @elseif ($triage->blood_pressure<36.1 ) text-yellow @else text-green @endif">{{ $triage->temp }} °C <small> ({{ date_format($triage->created_at, 'M d Y H:i:s') }}) </small></span>
                </h4>

                
                @endif

                @if ($patient_medicines !== null)

                    <hr>
                    <h3 class="box-title">Prescription</h3>

                    @foreach ($patient_medicines as $patient_medicine)
                        <h4>Name : {{ App\Medicine::where('id', '=',$patient_medicine->medicine_id)->first()->name_english }}</h4>
                        <h5>Dosage : {{ $patient_medicine->note }}</h5>
                        <h5>Date Issued : {{ date_format($patient_medicine->updated_at, 'M d Y H:i:s') }}</h5>
                    @endforeach

                @endif
                
             
                @if ($lab !== null)
                    <hr>
                    <h3 class="box-title">
                        Lab Results
                    </h3>

                    @if ($lab->whitebooldcells !== null)
                        <h4>
                            White blood cell (WBC): <span class="text-green">{{ $lab->whitebooldcells }}</span>
                        </h4>
                    @endif

                    @if ($lab->redbooldcells !== null)
                    <h4>
                        Red blood cell (RBC) counts: <span class="text-green">{{ $lab->redbooldcells }}</span>
                    </h4>
                    @endif

                    @if ($lab->prothrombintime !== null)
                    <h4>
                        PT, prothrombin time: <span class="text-green">{{ $lab->prothrombintime }}</span>
                    </h4>
                    @endif

                    @if ($lab->activatedpartialthromboplastin !== null)
                    <h4>
                        APTT, activated partial thromboplastin time: <span class="text-green">{{ $lab->activatedpartialthromboplastin }}</span>
                    </h4>
                    @endif

                    @if ($lab->aspartateaminotransferase !== null)
                    <h4>
                        AST, aspartate aminotransferase: <span class="text-green">{{ $lab->aspartateaminotransferase }}</span>
                    </h4>
                    @endif

                    @if ($lab->alanineaminotransferase !== null)
                    <h4>
                        ALT, alanine aminotransferase: <span class="text-green">{{ $lab->alanineaminotransferase }}</span>
                    </h4>
                    @endif


                    @if ($lab->mlactatedehydrogenase !== null)
                    <h4>
                        LD, lactate dehydrogenase: <span class="text-green">{{ $lab->mlactatedehydrogenase }}</span>
                    </h4>
                    @endif


                    @if ($lab->bloodureanitrogen !== null)
                    <h4>
                        BUN, blood urea nitrogen: <span class="text-green">{{ $lab->bloodureanitrogen }}</span>
                    </h4>
                    @endif

                    @if ($lab->WBCcountWdifferential !== null)
                    <h4>
                        WBC count w/differential: <span class="text-green">{{ $lab->WBCcountWdifferential }}</span>
                    </h4>
                    @endif

                    @if ($lab->Quantitativeimmunoglobulin !== null)
                    <h4>
                        Quantitative immunoglobulin’s (IgG, IgA, IgM): <span class="text-green">{{ $lab->Quantitativeimmunoglobulin }}</span>
                    </h4>
                    @endif

                    @if ($lab->Erythrocytesedimentationrate !== null)
                    <h4>
                        Erythrocyte sedimentation rate (ESR): <span class="text-green">{{ $lab->Erythrocytesedimentationrate }}</span>
                    </h4>
                    @endif
                    

                    @if ($lab->alpha_antitrypsin !== null)
                    <h4>
                        Quantitative alpha-1-antitrypsin (AAT) level: <span class="text-green">{{ $lab->alpha_antitrypsin }}</span>
                    </h4>
                    @endif


                    @if ($lab->Reticcount !== null)
                    <h4>
                        Retic count: <span class="text-green">{{ $lab->Reticcount }}</span>
                    </h4>
                    @endif

                    @if ($lab->arterialbloodgasses !== null)
                    <h4>
                        Arterial blood gasses (ABGs): <span class="text-green">{{ $lab->arterialbloodgasses }}</span>
                    </h4>
                    @endif
                    
                    
                @endif

                

                @if ($imaging_radiology !== null)
                    <hr>

                    <h3 class="box-title">
                        Radiology/Imaging Results
                    </h3>

                    @if ($imaging_radiology->ct_scan !== null)
                    <h4>
                        CT Scan: <span class="text-green">{{ $imaging_radiology->ct_scan }}</span>
                    </h4>
                    @endif


                    @if ($imaging_radiology->x_ray !== null)
                    <h4>
                        X-Ray: <span class="text-green">{{ $imaging_radiology->x_ray }}</span>
                    </h4>
                    @endif

                    @if ($imaging_radiology->ultra_sound !== null)
                    <h4>
                        Ultra Sound: <span class="text-green">{{ $imaging_radiology->ultra_sound }}</span>
                    </h4>
                    @endif

                    @if ($imaging_radiology->mri !== null)
                    <h4>
                        MRI: <span class="text-green">{{ $imaging_radiology->mri }}</span>
                    </h4>
                    @endif

                    @if ($imaging_radiology->pet_scan !== null)
                    <h4>
                        PET Scan: <span class="text-green">{{ $imaging_radiology->pet_scan }}</span>
                    </h4>
                    @endif
                    <br>
                    

                @endif

                

                @if ($dialysis !== null)
                <hr>
                    <h3 class="box-title">
                        Dialysis Results
                    </h3>
                    <h4>
                        Dialyzer Type : <span class="text-green">{{ $dialysis->dialyzer_type }}</span>
                    </h4>
                    <h4>
                        No of Blood Bags : <span class="text-green">{{ $dialysis->blood_bags }}</span>
                    </h4>
                    <h4>
                        Summary: <span class="text-green">{{ $dialysis->summary }}</span>
                    </h4>
                @endif
                
                

                

                

                @if ($theatre !== null)
                <hr>
                    <h3 class="box-title">
                        Theatre Results
                    </h3>
                    <h4>
                        Procedure summary: <span class="text-green">{{ $theatre->summary }}</span>
                    </h4>
                    <h4>
                        Theatre Doc Note: <span class="text-green">{{ $theatre->note }}</span>
                    </h4>
                @endif
                {{--
                    @if ($pBloodPressure->flag)
                <h4>Blood Pressure : <span
                        class="h4 @if ($pBloodPressure->sys>130 || $pBloodPressure->dia>90) text-red @elseif ($pBloodPressure->sys>125 || $pBloodPressure->dia>85) text-yellow @else text-green @endif ">
                        {{$pBloodPressure->sys}}/{{$pBloodPressure->dia}}
                        mmHg</span><small> (Updated
                        {{explode(" ",$pBloodPressure->date)[0]}})</small></h4>
                @endif
                @if($pBloodSugar->flag)
               
                <h4>Blood Glucose Levels : <span
                        class="h4 @if($pBloodSugar->value > 72 && $pBloodSugar->value<100) text-green @else text-red @endif">{{$pBloodSugar->value}}
                        mg/dL</span><small> (Updated
                        {{explode(" ",$pBloodSugar->date)[0]}})</small></h4>
                @endif

                @if ($pCholestrol->flag)
                <h4>General Cholestrol Level : <span
                        class="h4 @if($pCholestrol->value>220) text-red @elseif($pCholestrol->value>200) text-yellow @else text-green @endif">{{$pCholestrol->value}}
                        mg/dL</span><small>
                        (Updated {{explode(" ",$pCholestrol->date)[0]}})</small></h4>
                @endif
                
                <div class="row mt-2 mb-0 pb-0">
                    <div class="col-md-3 mt-2 mb-0 pb-0">
                        <button onclick="window.open('{{route('patientHistory',$pid)}}','myWin','scrollbars=yes,width=720,height=690,location=no').focus();" class="btn btn-info">
                            View Patient History
                        </button>
                    </div>
                   
                </div>
                --}}
            </div>
        </div>
    </div>



    <!-- /.modal -->

    <div class="rounded col-md-6">

        <div style="height:46.5vh;" class="box box-dark mb-1 mt-2">
            <div class="box-header with-border">
                Add Medicines To Prescription
            </div>
            <div class="box-body">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-md-5 m-0 p-0">
                            <div id="bloodhound">
                                <input oninput="console.log(this.value);" id="medSearch" class="form-control"
                                    type="text" placeholder="Search Medicines">
                            </div>
                        </div>
                        <div class="col-md-7 m-0 p-0">
                            <input onkeydown="addMed(event,this)" id="medNote" disabled type="text" class="form-control"
                                placeholder="Notes">
                        </div>
                        <div id="suggestionList"></div>
                    </div>
                </div>


                <div style="height:30vh;overflow-y: scroll">
                    <table style="width:100%" id="medTable" class="table table-sm table-bordered w-100">

                        <colgroup>
                            <col span="1" style="width: 10%;">
                            <col span="1" style="width: 40%;">
                            <col span="1" style="width: 30%;">
                            <col span="1" style="width: 20%;">
                        </colgroup>

                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Medicine</th>
                                <th>Notes</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody class="m-0 p-0">

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


    <script>
        var medicines=[];
        var patient_id={{$pid}};
        var app_num={{$appNum}};

        $(document).ready(function () {
            if(sessionStorage.getItem('app')=={{$appNum}}){
                console.log(sessionStorage.getItem("medicines"));
                sessionStorage.setItem('app',{{$appNum}});
                if(sessionStorage.getItem("medicines")){
                medicines=JSON.parse(sessionStorage.getItem("medicines"));
                medTableUpdate();
                $("#diagnosys").val(sessionStorage.getItem('diagnosys'));
                $("#cholestrol").val(sessionStorage.getItem('cholestrol'));
                $("#glucose").val(sessionStorage.getItem('glucose'));
                $("#pressure").val(sessionStorage.getItem('pressure'));
                console.log("Found");
                }else{
                console.log("not found");
                return;
                }
            }
            sessionStorage.setItem('app',{{$appNum}});

            $("#diagnosys").change(function (e) { 
                var diag=$("#diagnosys").val();
                sessionStorage.setItem('diagnosys',diag)
            });

            $("#cholestrol").change(function (e) { 
                sessionStorage.setItem('cholestrol',$("#cholestrol").val());
            });

            $("#glucose").change(function (e) { 
                sessionStorage.setItem('glucose',$("#glucose").val());
            });
            $("#pressure").change(function (e) { 
                sessionStorage.setItem('pressure',$("#pressure").val());
            });
        });

        function addMed(e,obj) { 
            var note=obj.value;
            var med=$("#medSearch").val();
            if(e.keyCode === 13){
                e.preventDefault();
                var id = Math.floor(1000 + Math.random() * 9000); 
                var med={id:id,name:med,note:note}
                medicines.push(med);
                medTableUpdate();
                $("#medSearch").val('');
                $("#medSearch").focus();
                $('#medSearch').typeahead('val', '');
                $('#medSearch').typeahead('close');

                $("#medNote").val('');
                $("#medNote").attr('disabled', 'disabled');
            }else if(e.keyCode===9){
                e.preventDefault();
            }
         }

         function medTableUpdate() {
            medicines = medicines.filter(function (el) {
            return el != null;
            });
            sessionStorage.setItem("medicines", JSON.stringify(medicines));
            $("#medTable tbody tr").remove();
            var count=1
             medicines.forEach(element => {
                $('#medTable > tbody:last-child').append('<tr><td>'+count+'</td><td>'+element.name+'</td><td>'+element.note+'</td><td><div class="btn-group"><button onclick="delMed('+element.id+')" style="height:28px;" type="button" class="m-0 btn btn-danger btn-sm btn-flat"><i class="far fa-trash-alt"></i></button><button style="height:28px;" onclick="editMed('+element.id+')" type="button" class="btn m-0 btn-warning btn-sm btn-flat"><i class="far fa-edit"></i></button></div></td></tr>');
                count++;
             });
         }

         function editMed(id){
             $("#medSearch").val()
             count=0;
             medicines.forEach(element=>{
                if(element.id==id){
                    $("#medSearch").val(element.name);
                    $("#medNote").removeAttr("disabled");
                    $("#medNote").val(element.note);
                    $("#medNote").focus();
                    delMed(id);
                    return;
                }
                count++;
            })
         }

         function delMed(id){
            medicines = medicines.filter(function (el) {
            return el != null;
            });
            console.log(id);
            count=0;
            medicines.forEach(element=>{
                if(element.id==id){
                    delete medicines[count];
                    medTableUpdate();
                    return;
                }
                count++;
            })
         }

            
            var states = [
                @foreach($medicines as $med)
                    '{{ucWords($med->name_english)}}',
                @endforeach
            ];
        
            var states = new Bloodhound({
                datumTokenizer: Bloodhound.tokenizers.whitespace,
                queryTokenizer: Bloodhound.tokenizers.whitespace,
                // `states` is an array of state names defined in "The Basics"
                local: states
            });

      
    
            $('#bloodhound #medSearch').typeahead({
                hint: true,
                highlight: true,
                minLength: 2
            }, {
                name: 'states',
                source: states
            });
    
            $('#medSearch').bind('typeahead:select', function(ev, suggestion) {
                $("#medNote").removeAttr("disabled");
                $("#medNote").focus();
                // 

            });
    </script>

</div>

<div class="row">
    <div class="col-md-12">
        <div class="box mt-2 box-dark">
            <div class="box-header with-border">
                <p class="h4 m-0">In Patient</p>
            </div>
            <div class="row">
                <div class="col-md-5">
                    <div class="box-body">
                        <div class="form-group">
                            <label for="">Doctor Note</label>
                            <input type="text" class="form-control" id="doc_note" name="doc_notes">
                            <br>

                            <label for="">Patient Condition</label>
                            <input type="text" class="form-control" id="doc_note" name="doc_notes">
                            <br>
                            <label for="">Current Department</label>

                            <input type="text" readonly class="form-control" value="{{ $department }}">

                            <br>
                            <label for="">Ward</label>

                            <select class="form-control" id="selectdoc" name="docname" required>
                                @foreach ($wards as $ward)
                                
                                    <option @if($ward->id == $patient_ward->id) selected  @endif value="{{ $ward->id }}">{{ $ward->ward_title }}</option>
                                    
                                @endforeach
                            </select>

                            
                            <br>
                            <label for="">Bed No</label>
                            <input type="number" readonly name="bed_no" class="form-control" value="{{$bedNumber}}">

                        </div>
                    </div>
                </div>

                <div class="col-md-2">
                   
                    <div class="p-2 mt-5 ml-1 mr-1">
                        
                        <button type="button"  class="btn btn-block btn-info btn-lg" data-toggle="modal" data-target="#lab">Request
                            Lab</button>
                        <br>
                        <button type="button" class="btn btn-block btn-info btn-lg" data-toggle="modal" data-target="#radiology">Request
                            Radiology</button>
                        <br>
                        <button type="button" class="btn btn-block btn-info btn-lg" data-toggle="modal" data-target="#counselling">Request
                            HDU / ICU</button>
                        <br>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="p-2 mt-5 ml-1 mr-1">
                        <button type="button"  class="btn btn-block btn-info btn-lg" data-toggle="modal" data-target="#phlembotomy">Request
                            Phlembotomy</button>
                        <br>
                        <button type="button" class="btn btn-block btn-info btn-lg" data-toggle="modal" data-target="#dialysis">Request
                            Dialysis Unit</button>
                        <br>
                        <button type="button" class="btn btn-block btn-info btn-lg" data-toggle="modal" data-target="#physiotherapy">Request
                            Physiotherapy</button>
                        <br>
                        
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="p-2 mt-5 ml-1 mr-1">
                        
                        <button  type="button" class="btn btn-block btn-info btn-lg" data-toggle="modal" data-target="#theatre">Send To Theatre</button>
                       

                        <br>


                        <button  type="button" class="btn btn-block btn-info btn-lg" onclick="sendTriage()">Request Triage</button>
                        <br>

                        <button type="button" onclick="submit()" class="btn btn-block btn-success btn-lg">Save &
                            Next</button>
                        
                        
                    </div>
                </div>
            </div>

        </div>
    </div>

</div>


@include('inpatient.include.labmeasures')


@include('inpatient.include.theatremeasures')

@include('inpatient.include.radiologymeasures')

@include('inpatient.include.dialyisis_intro_form')




<script>
    var inpatient='{{$inpatient}}';

    $("#reginpatient2form").hide(1000);
    $("#some").hide(1000);
    console.log({{$pid}});

    function removeinfo() {
        $("#remove_on_admit").show(1000);
        $("#reginpatient2form").hide(1000);
    }

    function myfunc() {
        console.log('iii');
        var data=new FormData;
            data.append('pNum',{{$pid}});
            data.append('_token','{{csrf_token()}}');


            $.ajax({
                type: "post",
                url: "{{route('regInPatient')}}",
                data: data,
                processData: false,
                contentType: false,
                cache: false,
                error: function(data){
                    console.log(data);
                },
                success: function (inp) {
                    if(inp.exist){
                        console.log(inp);
                        $("#patient_name").val(inp.name);
                        $("#patient_age").val(inp.age);
                        $("#patient_sex").val(inp.sex);
                        $("#patient_telephone").val(inp.telephone);
                        $("#patient_nic").val(inp.nic);
                        $("#patient_address").val(inp.address);
                        $("#patient_occupation").val(inp.occupation);
                        $("#patient_id").val(inp.id);

                        $("#remove_on_admit").hide(1000);
                        $("#reginpatient2form").show(1000);

                    }else{
                        console.log('not found');
                        alert("Please Enter a Valid Admitted Patient Registration Number or Appointment Number!");
                    }
                }
            })
        
    }

    

    function admitPatient(status){
        bootbox.confirm({
            title:"<h2>Confirm Admit Patient</h2>",
            message: "<p>This Will Make This Patient(Out Patient) an Inpatient.<br>Press Admit Patient To Admit The Patient.<br>Note:This Action Cannot Be Undone.</p>",
            buttons: {
                confirm: {
                    label: 'Admit Patient',
                    className: 'btn-success'
                },
                cancel: {
                    label: 'Cancel',
                    className: 'btn-danger'
                }
            },
            callback: function (result) {
                if(result){
                    var data=new FormData;
                    data.append('_token','{{csrf_token()}}');
                    data.append('admit',status);
                    data.append('pid',{{$pid}});
                    data.append('app_num',{{$appNum}});
                    $.ajax({
                        type: "POST",
                        url: "{{route('markInPatient')}}",
                        processData: false,
                        contentType: false,
                        cache: false,
                        data:data,
                        success: function (response) {
                            //console.log('success');
                            //console.log(response);
                            if(response.success){
                                $("#admit-btn").attr('disabled','disabled');
                                $("#admit-btn").text("Patient Admitted");
                                $("#admit-btn").removeClass('btn-warning');
                                $("#admit-btn").addClass('btn-primary');
                            }else{
                                $("#admit-btn").attr('disabled','disabled');
                                $("#admit-btn").text("Error Occured");
                                $("#admit-btn").removeClass('btn-warning');
                                $("#admit-btn").addClass('btn-danger');
                            }
                        },
                        error: function(data){
                            //console.log('error occured');
                            //console.log(data);
                            $("#admit-btn").attr('disabled','disabled');
                            $("#admit-btn").text("Error Occured");
                            $("#admit-btn").removeClass('btn-warning');
                            $("#admit-btn").addClass('btn-danger');
                            bootbox.alert({
                                title:"Error Occured On Admit Patient",
                                message: "Error Occured! Try Later."+data,
                                backdrop: true
                            });
                        },
                    });
                }
            }
        });
        
    }


    function sendTriage() {
        bootbox.confirm({
            title:"<h2>Request For Triage</h2>",
            message: "<p>This patient is about to undergo the triage process. Please confirm to begin. </p>",
            buttons: {
                confirm: {
                    label: 'Request',
                    className: 'btn-success'
                },
                cancel: {
                    label: 'Cancel',
                    className: 'btn-danger'
                }
            },

            callback: function (result) {

                if (result) {
                    
                
                    var data = new FormData;
                    data.append('_token','{{csrf_token()}}');
                    data.append('appointment_id', {{$appID}});
                    data.append('patient_id', {{$pid}});
                    $.ajax({
                        type: "POST",
                        url: "{{route('inpatientTriage')}}",
                        processData: false,
                        contentType: false,
                        cache: false,
                        data:data,
                        success: function (response) {

                            if (response==200) {
                                window.location.replace("{{route('inpatientqueue')}}");
                            }
                            
                        },
                        error:  function(response){
                                    bootbox.alert({
                                        title:"Error Occured",
                                        message: "Error Occured! Try Later."+response,
                                        backdrop: true
                                });
                        },
                    });
                }

            }
        });
    }

    /*
    function validate(){
        var diag=$('textarea').val();
        var pressure=$('#pressure').val();
        var cholestrol=$('#cholestrol').val();
        var glucose=$('#glucose').val();
        if(diag.length<5){
            $('textarea').addClass('border-danger');
            diag=false;
        }else{
            $('textarea').removeClass('border-danger');
            diag=true;
        }
        if($('#pressure').val()==""){
            pressure=true;
           
        }
        if($('#cholestrol').val()==""){
            cholestrol=true;
        }
        if($('#glucose').val()==""){
            glucose=true;   
        }

        if(cholestrol){
            $('#cholestrol').removeClass('border-danger');
        }else{
            $('#cholestrol').addClass('border-danger');
        }

        if(glucose){
            $('#glucose').removeClass('border-danger');
        }else{
            $('#glucose').addClass('border-danger');
        }

        if(pressure){
            $('#pressure').removeClass('border-danger');
        }else{
            $('#pressure').addClass('border-danger');
        }

        if(pressure && cholestrol && glucose && diag){
            return true;
        }else{
            return false;
        }
    }

    */
    function submit(){
        
            bootbox.confirm({
                title:"<h2>Done With Appointment</h2>",
                message: "<p>This will finish the Appointment for the patient.<br>No changes can be done to the prescription after saving.<br>Please check your actoin before comfirm.<br>Note:This Action Cannot Be Undone.</p>",
                buttons: {
                    confirm: {
                        label: 'Confirm Save',
                        className: 'btn-success'
                    },
                    cancel: {
                        label: 'Cancel',
                        className: 'btn-danger'
                    }
                },
                callback:function(result){
                    if (result) {
                        window.scrollTo(0,0);
                        var diag=$('textarea').val();
                        

                        

                       
                        var amount = 1500;
                        var billing_for = "inpatient consultation";
                        
                        
                        
                        var payment_method = 'cash';
                        var completed = 'no';
                        var docnote = $('#doc_note').val();
                        var data={
                            _token:'{{csrf_token()}}',
                            patient_id:patient_id,
                            appointment_num:app_num,
                            appointment_id:{{$appID}},
                            medicines:medicines,
                            //diagnosis:diag,
                            amount: amount,
                            billing_for:billing_for,
                            payment_method: payment_method,
                            completed: completed,
                            department: 'ward',
                            note: docnote,
                        };
                        $.ajax({
                            type: "POST",
                            url: "{{route('checksaveinpatient')}}",
                            processData: false,
                            contentType: "application/json",
                            cache: false,
                            data:JSON.stringify(data),
                            success: function (response) {
                                if(response==200){
                                    clearAll();
                                    window.location.replace("{{route('checkinpatientsearch')}}");
                                }
                            },
                            error: function(response){
                                bootbox.alert({
                                    title:"Error Occured On Save",
                                    message: "Error Occured! Try Later."+response,
                                    backdrop: true
                                });
                            },
                        });

                    };
        
                }
            });
    
    }

    function clearAll(){
        medicines=[];
        medTableUpdate();
        sessionStorage.clear();
        $('input').val("");
        $('textarea').val("");
    }
</script>



@endsection

@section('custom_styles')
.typeahead,
.tt-query,
.tt-hint {
width: 100%;
height: 100%;
{{-- padding: 8px 12px; --}}
{{-- font-size: 24px; --}}
{{-- line-height: 30px; --}}
border: 2px solid #ccc;
-webkit-border-radius: 8px;
-moz-border-radius: 8px;
border-radius: 8px;
outline: none;
}

.typeahead {
background-color: #fff;
}

.typeahead:focus {
border: 2px solid #0097cf;
}

.tt-query {
-webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
-moz-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
}

.tt-hint {
color: #999
}

.tt-menu {
width:100% ;
margin: 3px 0;
padding: 8px 0;
background-color: #fef;
border: 1px solid #ccc;
border: 1px solid rgba(0, 0, 0, 0.2);
-webkit-border-radius: 2px;
-moz-border-radius: 2px;
border-radius: 2px;
-webkit-box-shadow: 0 5px 10px rgba(0,0,0,.2);
-moz-box-shadow: 0 5px 10px rgba(0,0,0,.2);
box-shadow: 0 5px 10px rgba(0,0,0,.2);
}

.tt-suggestion {
padding: 3px 20px;
font-size: 15px;
line-height: 20px;
}

.tt-suggestion:hover {
cursor: pointer;
color: #fff;
background-color: #0097cf;
}

.tt-suggestion.tt-cursor {
color: #fff;
background-color: #0097cf;

}

.tt-suggestion p {
margin: 0;
}

@endsection