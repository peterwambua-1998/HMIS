{{--
@extends('template.main')

@section('title', 'Triage Search')

@section('content_title',__("Search Patient"))
@section('content_description')
@section('breadcrumbs')
<ol class="breadcrumb">
    <li><a href="#"><i class="fas fa-tachometer-alt"></i>Dashboard</a></li>
    <li class="active">Here</li>
</ol>

@endsection

@section('main_content')

<div class="row">
    <div class="col-md-1"></div>
    <div class="col-md-10">
        <form action={{route('searchDialysisPost')}} method="GET" role="search">
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
            <div class="callout callout-info">
                <label class="h4">{{__('Search Patient With ...')}}</label>
                <div class="row">
                    <div class="col-md-1"></div>
                    <div class="col-md-5">

                        <label class="mr-2">
                            <input onchange="changeFunc('Name');" style="display:inline-block" checked type="radio"
                                name="cat" id="cat" value="name">
                            {{__('Name')}}
                        </label>
                        
                        <label class="mr-2">
                            <input onchange="changeFunc('Patient Number');" style="display:inline-block" type="radio"
                                name="cat" id="cat" value="patient_id">
                            {{__('Patient Number')}}
                        </label>


                        <label class="ml-2 mr-4">
                            <input onchange="changeFunc('Telephone Number');" style="display:inline-block" type="radio"
                                name="cat" id="cat" value="telephone">
                            {{__('Telephone')}}
                        </label>


                        <label>
                            <input onchange="changeFunc('NIC Number');" style="display:inline-block" type="radio"
                                name="cat" id="cat" value="nic">
                            {{__('id Number')}}
                        </label>
                    </div>
                    <div class="col-md-1"></div>
                </div>
               
                <div class="row">
                    <div class="col-md-1"></div>
                    <div class="col-md-10">
                        <div class="input-group">
                            <input required type="text"  class="form-control" id="keyword" name="keyword"
                                placeholder="Enter Patient">
                            <span class="input-group-btn">
                                <button type="submit" class="btn btn-default">
                                    <span class="glyphicon glyphicon-search"></span>
                                </button>
                            </span>
                        </div>
                    </div>
                    <div class="col-md-1"></div>
                </div>

            </div>
    </div>
    <div class="col-md-1"></div>
</div>

</form>

<script>
    document.getElementById("keyword").placeholder ="Enter Patient Name";

    function changeFunc(txt){
        document.getElementById("keyword").placeholder ="Enter Patient " +txt;
    }
</script>

@endsection
--}}

@extends('template.main')

@section('title', 'Triage Search')

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
        font-size: 18px; 
    }
</style>

<div class="row">
    <div class="col-md-1"></div>
    <div class="col-md-10">
        <form action={{route('searchDialysisPost')}} method="GET" role="search">
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
            <div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title">{{__('Dialysis')}} <small class="ml-2" style="font-weight: bold">(Check in patient list for number)</small></h3>
                </div>
                
                <div class="box-body">
                    <div class="pl-5 pr-5 pb-5">
                        <h3>{{__('Enter Patient Number To Begin Lab Test')}}</h3>
                        <label class="mr-2" style="display: none">
                                    <input onchange="changeFunc('Patient Number');" style="display:inline-block" checked type="radio"
                                        name="cat" id="cat" value="patient_id">
                                {{__('Patient Number')}} <span class="ml-4" style="font-size: 14px; color: rgb(100, 100, 100);"> (Check Queue for Patient Number)</span>
                        </label>
                        
                            <input required type="number"  class="form-control" id="keyword" name="keyword"
                                placeholder="Enter Patient" style="margin-top: 2px">
                        <button type="button" class="btn btn-primary btn-lg mt-3 text-center" onclick="myPaste()">Paste</button>

                        <button type="submit" class="btn btn-success btn-lg mt-3 text-center">Check</button>
                        
                    </div>
                    
                {{--
                    <div class="row">
                        <div class="col-md-1"></div>
                        <div class="col-md-10">
                            

                            
                            <label class="mr-2">
                                <input onchange="changeFunc('Name');" style="display:inline-block"  type="radio"
                                    name="cat" id="cat" value="name">
                                {{__('Name')}}
                            </label>


                            
                            
                            <label class="ml-2 mr-4">
                                <input onchange="changeFunc('Telephone Number');" style="display:inline-block" type="radio"
                                    name="cat" id="cat" value="telephone">
                                {{__('Telephone')}}
                            </label>


                            <label>
                                <input onchange="changeFunc('NIC Number');" style="display:inline-block" type="radio"
                                    name="cat" id="cat" value="nic">
                                {{__('ID Number')}}
                            </label>
                            
                        </div>
                        <div class="col-md-1"></div>
                    </div>
                    --}}

                
                    
                    
                </div>
            </div>
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
    document.getElementById("keyword").placeholder ="Enter Patient Number";

    function changeFunc(txt){
        document.getElementById("keyword").placeholder ="Enter Patient " +txt;
    }

    if ("{{Session::has('error')}}") {
        setTimeout(() => {
            $('.myerror').fadeOut();
        }, 5000);
    }

    function myPaste() {
        let pasteText = document.querySelector("#keyword");

        pasteText.focus();

        navigator.clipboard.readText().then((clipText) =>
        document.getElementById("keyword").value = clipText);


        console.log(pasteText.textContent);
    }
</script>

@endsection