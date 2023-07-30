@extends('template.main')

@section('title', 'Cashier Search')

@section('content_title',__("Search Patient"))
@section('content_description')
@section('breadcrumbs')
<ol class="breadcrumb">
    <li><a href="#"><i class="fas fa-tachometer-alt"></i>Dashboard</a></li>
    <li class="active">Here</li>
</ol>

@endsection

@section('main_content')

<style>
    .callout {
        height: 40vh;
    }

    #keyword {
        margin-top: 50px;
        height: 50px;
        font-size: 20px; 
    }

    .btn-default {
        margin-top: 50px;
        height: 50px;
    }

    label {
        font-size: 16px; 
    }
</style>

<div class="row">
    <div class="col-md-12">
            @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
            @endif
            @if (session('unsuccess'))
            <div class="alert alert-danger">
                {{ session('unsuccess') }}
            </div>
            @endif
            <div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title">{{__('Cashier')}} <small class="ml-2" style="font-weight: bold">(Check queue for patient number)</small></h3>
                </div>

                <div class="box-body">
                    <div class="pl-5 pr-5 pb-5">
                        <h3>{{__('Enter Patient Name To Begin Billing')}}</h3>
                        <label class="mr-2" style="display: none">
                            <input onchange="changeFunc('Patient Number');" style="display:inline-block" checked type="radio"
                                name="cat" id="cat" value="patient_id">
                            {{__('Patient Number')}} <span class="ml-4" style="font-size: 14px; color: rgb(100, 100, 100);"> (Check Queue for Patient Number)</span>
                        </label>

                        <input required type="text"  class="form-control" id="keyword" name="keyword"
                                placeholder="Enter Patient Name" style="margin-top: 2px">
                        <button type="submit" id="search-btn" class="btn btn-success mt-3 text-center">Check</button>
                    </div>
                </div>
            </div>
    </div>

    <div id="patient-append">

    </div>
</div>

</form>


@if(Session::has('error'))

<div class="row myerror">
    <div class="col-md-1"></div>
        <div class="col-md-10">
            <div class="small-box bg-red">
                <div class="inner">
                    <h3>{{ Session::get('error') }}</h3>
                    <p>Sytem Warning</p>
                </div>
                <div class="icon">
                    <i class="ion ion-pie-graph"></i>
                </div>
            </div>
        </div>
    <div class="col-md-1"></div>
</div>

@endif


<script>

    $('#search-btn').on('click', function() {
        let data = new FormData;
        data.append('_token', "{{csrf_token()}}");
        data.append('keyword', $('#keyword').val());
        data.append('cat', 'name');
        $.ajax({
            type: "post",
            url: "{{route('searchcashierpost')}}",
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
                if (response.length > 0) {
                    for (let i = 0; i < response.length; i++) {
                            let template = `
                            <div class="col-md-12">
                                <div class="box box-successbox box-success">
                                    <div class="box-body pl-5 pr-5 pb-5">
                                        <form action="{{route('commencecashier')}}" method="post">
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

@endsection
