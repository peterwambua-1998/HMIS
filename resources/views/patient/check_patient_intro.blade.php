@extends('template.main')

@section('title', $title)

@section('content_title',__('Check Patient'))
@section('content_description',__('Check Patient here and update history from here !'))
@section('breadcrumbs')

<ol class="breadcrumb">
    <li><a href="{{route('dash')}}"><i class="fas fa-tachometer-alt"></i>Dashboard</a></li>
    <li class="active">Here</li>
</ol>
@endsection
@section('main_content')


<script>
$(document).ready(function () {
    $("#appNum").focus();
});

</script>

<div class="row">
    <div class="col-md-12">
        <div class="box box-success mt-5">
            <div class="box-header with-border">
                <h3 class="box-title">{{__('Check Patient')}}</h3>
            </div>
            <div class="box-body">
                
                    
                    <h3>{{__('Enter Patient Name To Begin')}}</h3>
                    <input id="appNum" name="keyword" class="form-control input-lg" type="string" placeholder="Patient Name" value="{{$key_word}}">
                    <input id="btn_submit" type="button" class="btn btn-success btn-lg mt-3 text-center"
                        value={{__("Check Patient")}}>
                
            </div>
        </div>
        @if (session()->has('fail'))
        <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h4><i class="icon fa fa-ban"></i> Already Attended To</h4>

            {{session()->get('fail')}}
        </div>
        @endif
    </div>

    <div id="patient-appendsssssssss">

    </div>

</div>


<script>
    function myPaste() {
        let pasteText = document.querySelector("#appNum");

        pasteText.focus();

        navigator.clipboard.readText().then(function(clipText){
            pasteText.value = clipText; 
            validateNum(clipText);
        });
    }

    $(function() {
        $('#btn_submit').on('click', () => {
            let data = new FormData
            data.append('keyword', $('#appNum').val());
            data.append('_token', "{{csrf_token()}}");
            $.ajax({
                type: 'post',
                url: "{{route('validateAppNum')}}",
                processData: false,
                cache: false,
                contentType: false,
                data: data,
                error: function(err) {
                    console.log(err);
                },
                success: function(response) {
                    console.log(response);
                    for (let i = 0; i < response.length; i++) {
                        if (response[i].appointment.department == "consultation") {
                            let template = `
                                <div class="col-md-12">
                                    <div class="box box-success mt-5">
                                        <div class="box-body">
                                            <form action="{{route('checkPatient')}}" method="post">
                                                @csrf
                                                <input name="pid" type="hidden" value="${response[i].id}">
                                                <input name="appNum" type="hidden" value="${response[i].appointment.number}">
                                                <div class="form-group">
                                                    <label for="inputEmail3" class="col-sm-2 control-label">{{__('Full Name')}}</label>
                                                    <div class="col-sm-10">
                                                        <input readonly value="${response[i].name}" type="text" required class="form-control"
                                                            name="reg_pname" placeholder="Enter Patient Full Name">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="inputEmail3" class="col-sm-2 control-label">{{__('ID/PP/Military No')}}</label>
                                                    <div class="col-sm-10">
                                                        <input readonly value="${response[i].nic}" type="text" required class="form-control"
                                                            name="reg_pnic" placeholder="National Identity Card Number">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="inputPassword3" class="col-sm-2 control-label">{{__('Address')}}</label>
                                                    <div class="col-sm-10">
                                                        <input readonly type="text" value="${response[i].address}" required class="form-control"
                                                            name="reg_paddress" placeholder="Enter Patient Address ">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="inputPassword3" class="col-sm-2 control-label">{{__('Telephone')}}</label>
                                                    <div class="col-sm-10">
                                                        <input readonly value="${response[i].telephone}" type="tel" class="form-control"
                                                            name="reg_ptel" placeholder="Patient Telephone Number">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="inputPassword3" class="col-sm-2 control-label">{{__('Occupation')}}</label>
                                                    <div class="col-sm-10">
                                                        <input readonly value="${response[i].occupation}" type="text" required class="form-control"
                                                            name="reg_poccupation" placeholder="Enter Patient Occupation ">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label">{{__('Gender')}}</label>
                                                    <div class="col-sm-10">
                                                        <input readonly value="${response[i].sex}" type="text" required class="form-control"
                                                            name="reg_poccupation" placeholder="Enter Patient Occupation ">
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label">{{__('DOB')}}</label>
                                                    <div class="col-sm-10">
                                                        <div class="input-group date">
                                                            <div class="input-group-addon">
                                                                <i class="fa fa-calendar"></i>
                                                            </div>
                                                            <input readonly value="${response[i].bod}" type="text" class="form-control pull-right"
                                                                name="reg_pbd" placeholder="Birthday">
                                                            <input readonly value="${response[i].id}" type="text" class="form-control pull-right"
                                                                name="reg_pid" style="display:none">

                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <div class="col-sm-2">
                                                        <button type="submit" class="btn bg-green mt-3">Check</button>
                                                    </div>
                                                    <div class="col-md-5"></div>
                                                    <div class="col-md-5"></div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            `;
                            console.log($('#patient-appendsssssssss'));
                            
                            $('#patient-appendsssssssss').append(template);
                        }
                            
                    }
                }
            })
        })
    })


</script>
@endsection