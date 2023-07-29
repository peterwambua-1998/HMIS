@extends('template.main')

@section('title', $title)

@section('content_title',"Pharmacy")
@section('content_description',"Issue Medicines here.")
@section('breadcrumbs')

<ol class="breadcrumb">
    <li><a href="{{route('dash')}}"><i class="fas fa-tachometer-alt"></i>Dashboard</a></li>
    <li class="active">Here</li>
</ol>
@endsection

@section('main_content')

<style>
    .patient-input {
        font-size: 18px;
    }
</style>

<div class="row mt-1 pt-5">
    <div class="col-md-12">
        <div class="box box-success" id="issuemedicine1">
            <div class="box-header with-border">
                <h3 class="box-title">{{__('Enter Patient Number')}}</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <div class="form-group">
                    <label for="p_id" class="control-label"
                        style="font-size:18px">{{__('Enter Patient Name To Begin:')}}</label>
                    <input type="text" required class="form-control mt-2 patient-input" name="keyword"
                        id="keyword"
                        placeholder="Enter Patient Name" />
                </div>
                <div class="form-group">
                    <button type="button" id="search-btn" class="btn btn-success btn-lg mt-3 text-center" {{--onclick="issuemedicinefunction1()"--}}>Check</button>
                </div>
            </div>
            <!-- /.box-body -->

            <div class="box-footer">

            </div>
            <!-- /.box-footer -->
        </div>

        <div id="patient-append">

        </div>

        <div class="box box-info" id="issuemedicine2" style="display:none">
            <div class="box-header with-border">
                <h3 class="box-title">Approved to Issue Medicine</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body mt-0">
                <h4>Registration No : <span id="patient_id"></span></h4>
                <h4>Patient Name : <span id="p_name"></span></h4>
                <h4>Queue No &nbsp;: <span id="p_appnum"></span></h4>
                <button id="btn-issue" type="button" class="btn btn-primary btn-lg mt-3 text-center"
                    value="Issue Medicine Now" onclick="go()" id="btn">Issue Medicine Now</button>
                <button onclick="cancel()" class="btn btn-warning btn-lg mt-3 text-center">Cancel</button>
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
            </div>
            <!-- box-footer -->

            <!-- /.box -->
        </div>
    </div>
</div>


<div class="row myerror" id="myerror">
        <div class="col-md-12">
            <div class="small-box bg-red">
                <div class="inner">
                    <h3>Please Enter Patient Number In Today Queue!</h3>
                    <p>Sytem Warning</p>
                </div>
                <div class="icon">
                    <i class="ion ion-pie-graph"></i>
                </div>
            </div>
        </div>
</div>


<script>
    var presid=1;
    function go(){
        window.location.href="/issue/"+presid;
    }

    function cancel(){
        $("#issuemedicine2").slideUp(1000);
        $("#issuemedicine1").slideDown(1000);
    }

    $('#search-btn').on('click', function() {
        let data = new FormData;
        data.append('_token', "{{csrf_token()}}");
        data.append('keyword', $('#keyword').val());
        data.append('cat', 'name');
        $.ajax({
            type: "post",
            url: "{{route('searchPharmacy')}}",
            processData: false,
            cache: false,
            contentType: false,
            data: data,
            error: function(err) {
                console.log(err);
            },
            success: function (response) {
                console.log(response);
                $('#patient-append').children().remove();
                for (let i = 0; i < response.length; i++) {
                        if (response[i].prescription) {
                            let template = `
                            <div class="col-md-12">
                                <div class="box box-successbox box-success">
                                    <div class="box-body pl-5 pr-5 pb-5">
                                        <form action="/issue/${response[i].prescription.id}" method="get">
                                            @csrf
                                            <input type="hidden" name="patient_id" value="${response[i].id}">
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

                            $('#patient-append').append(template);
                        }
                        
                }
            }
        })
    })
</script>


<script>

    $("#myerror").hide();
    function issuemedicinefunction1() {
        
        var x, text;
        x = document.getElementById("p_id").value;
        patientid=x;
        
            var data=new FormData;
            data.append('pNum',x);
            data.append('_token','{{csrf_token()}}');


            $.ajax({
                type: "post",
                url: "{{route('issueMedicine2')}}",
                data: data,
                processData: false,
                contentType: false,
                cache: false,
                error: function(data){
                    console.log(data);
                },
                success: function (im) {
                    if(im.exist){
                        console.log(im.name);
                        $("#p_name").text(im.name);
                        $("#patient_id").text(im.pNUM);
                        $("#p_appnum").text(im.appNum);
                        presid=im.pres_id;
                        $("#btn-issue").focus();
                        $("#issuemedicine2").slideDown(1000);
                        $("#issuemedicine1").slideUp(1000);
                        console.log('check');
                    }else{
                        console.log('not found');
                        $("#myerror").fadeIn();
                    }
                }
            });
            
    }

    function issuemedicinefunction2()
    {
       
        $("#issuemedicine3").slideDown(1000);
        document.getElementById("btn").disabled = true;
        
    }

</script>













@endsection