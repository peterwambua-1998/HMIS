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

<style>
    .callout {
        height: 40vh;
    }

    #appNum {
        
        height: 40px;
        font-size: 16px; 
    }

    .btn-default {
        margin-top: 50px;
        height: 50px;
    }

    label {
        font-size: 14px; 
    }
</style>

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
    <div class="col-md-12">
        <div class="box box-success mt-5">
            <div class="box-header with-border">
                <h3 class="box-title">{{__('Check Patient')}}</h3>
            </div>
            <div class="box-body">
                <div class="pl-5 pr-5 pb-5">
                    <h4>{{__('Enter patient name')}}</h4>
                    <input id="appNum" name="keyword" class="form-control input-lg" type="string" placeholder="Patient Name" value="{{$key_word}}">
                    <input id="btn_submit" type="button" class="btn btn-success mt-3 text-center"
                        value={{__("Check Patient")}}>
                </div>
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
                    $('#patient-appendsssssssss').children().remove();
                    if (response.length > 0) {
                        for (let i = 0; i < response.length; i++) {
                            if (response[i].appointment) {
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
                                                            <input readonly value="${response[i].contactnumber}" type="tel" class="form-control"
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
                    } else {
                        let errorTemplate = `
                            <div class="col-md-12">
                                <div style="background: #fcdce1; color: #f26982; padding: 2%; border; font-size: 14px; border-radius: 0.375rem;">
                                    <p><span class="mr-2"><i class="fa-solid fa-triangle-exclamation"></i></span> <span>Kindly try again, search returned zero results</span></p>    
                                </div>    
                            </div>
                        `;

                        $('#patient-appendsssssssss').append(errorTemplate);
                    }
                }
            })
        })
    })


</script>
@endsection