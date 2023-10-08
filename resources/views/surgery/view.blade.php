@extends('template.main')

@section('title', $title)

@section('content_title',__("Radiology Panel"))

@section('breadcrumbs')
<ol class="breadcrumb">
    <li><a href="#"><i class="fas fa-tachometer-alt"></i>Dashboard</a></li>
    <li class="active">Here</li>
</ol>

@endsection

@section('main_content')
<script src="js/typeahead/typeahead.bundle.js"></script>
{{-- <script src="js/typeahead/typeahead.jquery.js"></script> --}}
<script src="js/typeahead/bloodhound.js"></script>

<div class="row" id="createchannel4">
    <div class="col-xs-12">
        <div class="box box-success">
            <div class="box-header">
                <h3 class="box-title">{{__('Patient Details:')}}</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <div class="mb-4" style="display: grid; grid-template-columns: 1fr 1fr; font-size: 15px; grid-row-gap: 12px; border: 1px solid gray; padding: 20px">
                    <p>Patient Name: <span style="font-weight: bold">{{ $search_result->name }}</span></p>
                    <p>Patient Telephone: <span style="font-weight: bold">{{ $search_result->telephone }}</span></p>
                    <p>DOB: <span style="font-weight: bold">{{ $search_result->bod }}</span>
                    <p>Current Doctor: <span style="font-weight: bold">{{ $docs->name }}</span></p>
                        @foreach ($measures as $item)
                            @if ($item->measure_id)
                            <div style="display: flex">
                                <p>Surgery Requested:</p>
                                <p style="font-weight: bold">{{App\SurgaryService::where('id',$item->measure_id)->first()->name}}</p>
                            </div>
                            @endif
                        @endforeach
                    
                    <p>Doctors Note: <span style="font-weight: bold">{{$note}}</span></p>
                </div>
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>
    <div class="col-xs-12">
        <div class="box box-success">
            <div class="box-header">
                <h3 class="box-title">{{__('Surgery Results Report:')}}</h3>
            </div>
            @if($measures->count() > 0)
            <div class="box-body">
                <div style="border: 1px solid gray; padding: 20px">
                    
                    <form class="form-horizontal" action="{{route('surgeryStore')}}" method="POST" id="my-form">
                        @csrf
                        @foreach ($measures as $item)
                        <div class="row">
                            <div class="row ">
                                
                                <div class="col-md-12">
                                    <div style="display: grid; grid-template-rows: 14% 1fr">
                                    <label for="">Enter Surgery Report:</label>
                                    <textarea name="measures_results[]" id="" cols="30" rows="10" class="form-control measures_results"></textarea>
                                    </div>
                                </div>
                                <input type="hidden" name="measure_id[]" id="measure_id" class="measure_id" value="{{$item->measure_id}}">
                            </div>
                            <br>
                        </div>
                        
                        @endforeach

                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label for="">Send to:</label>
                                <select name="send_to" id="send_to" class="form-control">
                                    <option value="consultation">Consultation</option>
                                    <option value="pharmacy">Pharmacy</option>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="rounded col-md-12">
                                <div style="height:46.5vh;" class="box box-dark mb-1 mt-2">
                                    <div class="box-header with-border">
                                        <label for="">Add Medicines To Prescription</label>
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
                                                <input type="hidden" name="medicines[]" id="input-med">
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
                        </div>
                        
                        
                        <input type="hidden" value="2000" name="amount" />
                        <input type="hidden" value="{{ $appointment->id }}" name="appointment_id" />
                        <input type="hidden" value="{{ $appointment->patient_id }}" name="patient_id" />
                        <input type="hidden" value="radiology and imaging" name="billing_for" />
                        <input type="hidden" value="no" name="completed" />
                        <input type="hidden" value="{{ $appointment->mode_of_payment }}" name="payment_method" />
                        <button type="submit" class="btn btn-success" id="my-submit">Submit Results</button>
                    </form>
                </div>
            </div>
            @else
            <div class="p-4">
                <div class="alert alert-danger">
                    <h5>Patient not sent to surgery</h5>
                </div>
            </div>
            
            @endif

        </div>
    </div>
    <!-- /.col -->
</div>
<div class="row" id="createchannel4">
    
</div>    



<script>
    $('#myhiddenrow').hide();

    $('#addLabResults').on('click', function() {
        $('#myhiddenrow').slideToggle();
    });
</script>
<script>
    var medicines=[];
    var patient_id={{$appointment->patient_id }};
    var app_num={{$appointment->id}};
    var payment_method='{{$appointment->mode_of_payment}}';

    $(document).ready(function () {
        if(sessionStorage.getItem('app')=={{$appointment->number }}){
            console.log(sessionStorage.getItem("medicines"));
            sessionStorage.setItem('app',{{$appointment->number}});
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
        sessionStorage.setItem('app',{{$appointment->number}});

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

        $('#my-submit').on('click', (e) => {
            e.preventDefault();
            let measure_ids = [];
            let measure_results = [];
            $('.measure_id').each(function(i, e) {
                measure_ids.push($(e).val())
            });
            $('.measures_results').each(function(i, e) {
                measure_results.push($(e).val())
            });
            var data={
                _token:'{{csrf_token()}}',
                patient_id:patient_id,
                appointment_num:app_num,
                appointment_id:{{$appointment->id}},
                medicines:medicines,
                payment_method: payment_method,
                department: $('#send_to').val(),
                measure_id: measure_ids,
                measures_results: measure_results
            };

            $.ajax({
                type: "POST",
                url: "{{route('surgeryStore')}}",
                processData: false,
                contentType: "application/json",
                cache: false,
                data:JSON.stringify(data),
                success: function (response) {
                    console.log(response);

                    // if(response==200){
                    //     clearAll();
                    //     window.location.replace("{{route('surgerySearchPatient')}}");
                    // }
                },
                error: function(response){
                    bootbox.alert({
                        title:"Error Occured On Save",
                        message: "Error Occured! Try Later.",
                        backdrop: true
                    });
                },
            })
            
            //$('#my-form').submit()
        })


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