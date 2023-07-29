@extends('template.main')

@section('title', $title)

@section('content_title',__("Search Patient"))
@section('content_description',__("Search,View & Update Patient Details"))
@section('breadcrumbs')
<ol class="breadcrumb">
    <li><a href="#"><i class="fas fa-tachometer-alt"></i>Dashboard</a></li>
    <li class="active">Here</li>
</ol>

@endsection

@section('main_content')

<div class="row">
    <div class="col-md-12">
        <form action={{route('searchData')}} method="GET" role="search">
            @csrf

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
            <div class="callout callout-success">
                <label class="h4">{{__('Search Patient With ...')}}</label>
                <div class="row">
                    
                    <div class="col-md-12 mt-2 mb-2">

                        <label class="">
                            <input onchange="changeFunc('Name');" style="display:inline-block" checked type="radio"
                                name="cat" id="cat" value="name">
                            {{__('Name')}}
                        </label>


                        <label class="ml-2 mr-4">
                            <input onchange="changeFunc('Telephone Number');" style="display:inline-block" type="radio"
                                name="cat" id="cat" value="telephone">
                            {{__('Telephone')}}
                        </label>


                        <label>
                            <input onchange="changeFunc('ID Number');" style="display:inline-block" type="radio"
                                name="cat" id="cat" value="nic">
                            {{__('ID Number')}}
                        </label>
                    </div>
                    
                   
                </div>
                <script>
                    function changeFunc(txt){
                        document.getElementById("keyword").placeholder ="Enter Patient " +txt;
                    }
                </script>
                <div class="row">
                    <div class="col-md-12">
                        <div class="input-group">
                            <input required type="text" value="{{$old_keyword}}" class="form-control" id="keyword" name="keyword"
                                placeholder="Enter Patient">
                            <span class="input-group-btn">
                                <button type="submit" class="btn btn-default">
                                    <span class="glyphicon glyphicon-search"></span>
                                </button>
                            </span>
                        </div>
                    </div>
                </div>

            </div>
    </div>
</div>

</form>

@if($search_result)
@if(!$search_result->isEmpty())

@foreach($search_result as $patient)
{{-- Search Results --}}
<div class="row">
    <!-- right column -->
    <div class="col-md-12">
        <!-- Horizontal Form -->
        <div class="box box-success">
            <div class="box-header with-border">
                <h3 class="box-title">{{__('Search Results')}}</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->

            <div class="form-horizontal">
                <form action="{{ route('makeappoint') }}" class="appointment-form" method="post" style="display: inline-block">
                    @csrf
                <div class="box-body">
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 control-label">{{__('Patient NO')}}</label>
                        <div class="col-sm-8">
                            <input readonly value="{{$patient->id}}" type="text" required class="form-control"
                                name="reg_pid">
                            
                        </div>
                        <div class="col-sm-2">
                            <button class="btn btn-success" type="button" onclick="myCopy({{$patient->id}})">Copy</button>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 control-label">{{__('Full Name')}}</label>
                        <div class="col-sm-10">
                            <input readonly value="{{$patient->name}}" type="text" required class="form-control"
                                name="reg_pname" placeholder="Enter Patient Full Name">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 control-label">{{__('ID/PP/Military No')}}</label>
                        <div class="col-sm-10">
                            <input readonly value="{{$patient->nic}}" type="text" required class="form-control"
                                name="reg_pnic" placeholder="National Identity Card Number">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputPassword3" class="col-sm-2 control-label">{{__('Address')}}</label>
                        <div class="col-sm-10">
                            <input readonly type="text" value="{{$patient->address}}" required class="form-control"
                                name="reg_paddress" placeholder="Enter Patient Address ">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputPassword3" class="col-sm-2 control-label">{{__('Telephone')}}</label>
                        <div class="col-sm-10">
                            <input readonly value="{{$patient->telephone}}" type="tel" class="form-control"
                                name="reg_ptel" placeholder="Patient Telephone Number">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputPassword3" class="col-sm-2 control-label">{{__('Occupation')}}</label>
                        <div class="col-sm-10">
                            <input readonly value="{{$patient->occupation}}" type="text" required class="form-control"
                                name="reg_poccupation" placeholder="Enter Patient Occupation ">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">{{__('Gender')}}</label>
                        <div class="col-sm-10">
                            <input readonly value="{{$patient->sex}}" type="text" required class="form-control"
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
                                <input readonly value="{{$patient->bod}}" type="text" class="form-control pull-right"
                                    name="reg_pbd" placeholder="Birthday">
                                <input readonly value="{{$patient->id}}" type="text" class="form-control pull-right"
                                    name="reg_pid" style="display:none">

                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Payment Method</label>
                        <div class="col-sm-10">
                            <select class="form-control" id="select1" name="modeofpayment" required>
                                <option value="cash">Cash</option>
                                <option value="mpesa">Mpesa</option>
                                <option value="nhif">NHIF</option>
                            </select>
                        </div>
                    </div>
                    <!-- select -->
                    <div class="form-group">

                        

                        <label class="col-sm-2 control-label" for="" >Department</label>
                        <div class="col-sm-10">
                            <select class="form-control" id="selectDept" name="department" required>
                                <option selected>triage</option>
                                <option>lab</option>
                                <option>physiotherapy</option>
                                <option>counselling</option>
                                <option>dentist</option>
                                <option>antenatal</option>
                            </select>
                        </div>
                        
                        
                        
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="">Select Doctor</label>
                        <div class="col-sm-10">
                            <select class="form-control" id="selectdoc" name="docname" required>
                                @foreach ($docs as $doc)
                                    <option value="{{ $doc->id }}">{{ $doc->name }} - {{ substr($doc->user_type, 7) }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-4"></div>
                        <div class="col-md-4">
                            <div class="btn-group" role="group" aria-label="Button group">
                                {{-- edit patient --}}
                                
                                    <button type="button" @if($patient->trashed())  disabled @endif class="btn btn-warning ml-2 edit"><i class="fas fa-edit"></i> {{__('Edit')}}</button>
                                
                                {{-- patient profile  --}}
                                <button type="button" onclick="go('{{$patient->id}}')" class="btn bg-navy ml-2"><i class="far fa-id-card"></i> {{__('Profile')}}</button>
                                {{-- create appointment --}}
                                
                                    <input type="hidden" name="patient_id" value="{{$patient->id}}">
                                    <button type="button" class="btn bg-green ml-2 appointment-button"><i class="far fa-id-card"></i> {{__('Create Appointment')}}</button>
                            </div>
                        </div>
                        <div class="col-md-4"></div>
                    </div>
                </div>
            </form>
            <form  action="{{route('editpatient')}}" class="edit-form" method="POST" style="display: inline-block; margin: 0">
                @csrf
                <input  value="{{$patient->id}}" type="hidden" required class="form-control"
                    name="reg_pid">
                </form>
        </div>
    </div>
    
</div>
@endforeach
<script>
    function go(pid){
        window.location.href = "/patient/"+pid;
    }


    function myCopy(copytext) {

        console.log(copytext);
        navigator.clipboard.writeText(copytext);

        alert("Copied the text: " + copytext);
    }

    $(function() {
        $('.appointment-button').each((i, e) => {
            $(e).on('click', (ev) => {
               $(e).parent().parent().parent().parent().parent().submit();
            });
        });

        $('.edit').each((i, ec) => {
            $(ec).on('click', function() {
                $(ec).parent().parent().parent().parent().parent().next().submit();
            })
        })
    });
</script>


@else
<div class="row">
    <div class="col-md-1"></div>
    <div class="col-md-10">
        <h4>{{__('No results found...')}}</h4>
    </div>
    <div class="col-md-1"></div>
</div>

@endif
@endif

@endsection