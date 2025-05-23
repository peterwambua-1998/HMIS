@auth
<?php $user = Auth::user();
$name = ucwords($user->name);
$user_type = ucfirst($user->user_type);
$image_path = $user->img_path;
$outlet = '';
\App::setLocale(Session::get('locale'));
?>


<!DOCTYPE html>

<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>WKMH | @yield('title')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="{{asset('bower_components/bootstrap/dist/css/bootstrap.min.css')}}">
    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/6557f5a19c.js" crossorigin="anonymous"></script>
    <!-- Ionicons -->
    <link rel="stylesheet" href="{{asset('bower_components/Ionicons/css/ionicons.min.css')}}">
    <!-- daterange picker -->
    <link rel="stylesheet" href="{{asset('bower_components/bootstrap-daterangepicker/daterangepicker.css')}}">
    <!-- bootstrap datepicker -->
    <link rel="stylesheet"
        href="{{asset('bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css')}}">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesnt work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    {{-- date picker start --}}
    <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
   
    {{-- date picker end --}}



    <!-- Google Font -->
    <link rel="stylesheet" href="{{asset('bower_components/bootstrap/dist/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('bower_components/Ionicons/css/ionicons.min.css')}}">
    <link rel="stylesheet" href="{{asset('dist/css/skins/skin-blue.min.css')}}">
    <link rel="stylesheet" href="{{asset('bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('bower_components/datatables.net-bs/css/buttons.dataTables.min.css')}}">
    <link rel="stylesheet"
        href="{{asset('bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css')}}">
    <link rel="stylesheet" href="{{asset('dist/css/adminLTE.min.css')}}">
    


    <script src="https://code.jquery.com/jquery-3.3.1.js"></script>

    @yield('custom_style_sheets')
    <link rel="stylesheet" href="{{ URL::asset('/css/bsutility.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" rel="stylesheet">

    <link rel="shortcut icon" type="image/png" href="{{asset('images/logo.png')}}" />

    <script src="https://code.jquery.com/jquery-3.4.1.js"
        integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU=" crossorigin="anonymous"></script>

    <style>
        @yield('custom_styles');
        .spinner {
            margin: 0;
            position: absolute;
            top: 50%;
            left: 50%;
            -ms-transform: translate(-50%, -50%);
            transform: translate(-50%, -50%);
            width: 50px;
            height: 40px;
            text-align: center;
            font-size: 20px;
            z-index: 9999;
        }

        input[readonly],
        input[readonly="readonly"] {
            background-color: white !important;
            font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;
            font-size: 16px;
            font-weight: 300
        }

        .spinner>div {

            background-color: #2A98E5;
            height: 100%;
            width: 6px;
            display: inline-block;

            -webkit-animation: sk-stretchdelay 1.2s infinite ease-in-out;
            animation: sk-stretchdelay 1.2s infinite ease-in-out;
        }

        .spinner .rect2 {
            -webkit-animation-delay: -1.1s;
            animation-delay: -1.1s;
        }

        .spinner .rect3 {
            -webkit-animation-delay: -1.0s;
            animation-delay: -1.0s;
        }

        .spinner .rect4 {
            -webkit-animation-delay: -0.9s;
            animation-delay: -0.9s;
        }

        .spinner .rect5 {
            -webkit-animation-delay: -0.8s;
            animation-delay: -0.8s;
        }

        @-webkit-keyframes sk-stretchdelay {

            0%,
            40%,
            100% {
                -webkit-transform: scaleY(0.4)
            }

            20% {
                -webkit-transform: scaleY(1.0)
            }
        }

        @keyframes sk-stretchdelay {

            0%,
            40%,
            100% {
                transform: scaleY(0.4);
                -webkit-transform: scaleY(0.4);
            }

            20% {
                transform: scaleY(1.0);
                -webkit-transform: scaleY(1.0);
            }
        }

        #preloader {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 9999;
            background-color: #F9FDFF;
            background-position: center;
        }

        #preloader1 {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 9999;
            background-color: rgba(0, 0, 0, 0.56);
            background-position: center;
        }
    </style>



</head>

<body onload="startTime();setdate()" class="hold-transition skin-blue sidebar-mini">

    <script>
        $(document).ready(function () {
    $(document).ready(function () {

        $(document).ajaxSend(function(){
            $("#preloader1").fadeIn();
            $("#spinner").fadeIn();
        });

        $(document).ajaxComplete(function(){
            $("#preloader1").fadeOut();
            $("#spinner").fadeOut();
        });
    });

});

        function setdate(){
            var today = new Date();
            var dd = String(today.getDate()).padStart(2, '0');
            var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
            var yyyy = today.getFullYear();
            today =  dd+ '-'+ mm  + '-' + yyyy;
            document.getElementById("today").innerHTML=today;
        }

        function startTime() {
          var today = new Date();
          var h = today.getHours();
          var c = ((h > 12) ? 'pm' : 'am');
          h=h%12;
          if(h==0){
            h=12;
          }
          var m = today.getMinutes();
          var s = today.getSeconds();
          m = checkTime(m);
          s = checkTime(s);
          document.getElementById('time').innerHTML =
          h + ":" + m + ":" + s + " "+c;
          var t = setTimeout(startTime, 1000);
        }
        function checkTime(i) {
          if (i < 10) {i = "0" + i};  // add zero in front of numbers < 10
          return i;
        }
    </script>

    <div id="preloader"></div>
    <div style="display:none" id="preloader1"></div>
    <div id="spinner" class="spinner">
        <div class="rect1"></div>
        <div class="rect2"></div>
        <div class="rect3"></div>
        <div class="rect4"></div>
        <div class="rect5"></div>
    </div>

    <div class="wrapper">

        <!-- Main Header -->
        <header class="main-header" >

            <!-- Logo -->
            <a href="/" class="logo" style="background: rgb(0, 78, 0)">
                <!-- mini logo for sidebar mini 50x50 pixels -->
                <span class="logo-mini">WKMH</span>
                <!-- logo for regular state and mobile devices -->
                <span class="logo-lg">WKM</span>
            </a>

            <!-- Header Navbar -->
            <nav class="navbar navbar-static-top" role="navigation" style="background: green">
                <!-- Sidebar toggle button-->
                <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                    <i class="fas fa-sliders-h"></i>
                    <span class="sr-only">Toggle Navigation</span>
                </a>
                <!-- Navbar Right Menu -->
                <div class="navbar-custom-menu">
                    <ul class="nav navbar-nav">
                        <!-- Messages: style can be found in dropdown.less-->

                        <li class="nav-item mr-auto">
                            <p style="padding-top:1.3rem;font-weight:400;margin-right:1.5vw;color:ivory;font-size:1.7rem">
                                <span class="mr-3" id="today"></span><span id="time"></span></p>
                        </li>

                        <li class="dropdown messages-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                @if(\Session::get('locale')=='si')
                                සිං
                                @else
                                EN
                                @endif
                            </a>
                            
                        </li>


                        <!-- User Account Menu -->
                        <li class="dropdown user user-menu">
                            <!-- Menu Toggle Button -->
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <!-- The user image in the navbar-->
                                <img src="{{asset("$image_path")}}" class="user-image" alt="User Image">
                                <!-- hidden-xs hides the username on small devices so only the image appears. -->
                                <span class="hidden-xs">{{ucwords($name)}}</span>
                            </a>
                            <ul class="dropdown-menu">
                                <!-- The user image in the menu -->
                                <li class="user-header">
                                    <img src="{{asset("$image_path")}}" class="img-circle" alt="User Image">

                                    <p>
                                        {{$name}}
                                        <small>{{$user_type}}</small>
                                    </p>
                                </li>
                                <!-- Menu Body -->
                                <li class="user-body">
                                    <h5 class="text-center">{{$outlet}}</h5>
                                </li>
                                <!-- Menu Footer-->
                                <li class="user-footer">
                                    <div class="pull-left">
                                        <a href="{{route('profile')}}" class="btn btn-default btn-flat">Profile</a>
                                    </div>

                                    <div class="pull-right">
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST">
                                            @csrf
                                            <input type="submit" href="#" class="btn btn-default btn-flat"
                                                value="Sign Out">
                                        </form>

                                    </div>
                                </li>
                            </ul>
                        </li>
                        <!-- Control Sidebar Toggle Button -->
                    </ul>
                </div>
            </nav>
        </header>

        <aside class="main-sidebar">

            <!-- sidebar: style can be found in sidebar.less -->
            <section class="sidebar">

                <!-- Sidebar user panel (optional) -->
                <div class="user-panel">
                    <div class="pull-left image">
                        <img src="{{asset("$image_path")}}" class="img-circle" alt="User Image">
                    </div>
                    <div class="pull-left info">
                        <p>{{$name}}</p>
                        <!-- Status -->
                        <a href="#"><i class="fas fa-circle text-success"></i> Online</a>
                    </div>
                </div>

                <!-- Sidebar Menu -->

                <ul class="sidebar-menu" data-widget="tree">
                    <li class="header">Main Menu</li>
                    <li class="{{Active::checkRoute('dash')}}"><a href="{{route('dash')}}">
                            <i class="fas fa-tachometer-alt"></i>
                            <span> Dashboard</span></a>
                    </li>

                    
                    
                    @if(Auth::user()->user_type == 'reception' || Auth::user()->user_type == 'admin')
                    {{--patient--}}
                    <li
                        class="treeview {{Active::checkRoute(['patient','register_in_patient_view','searchPatient','searchData','patientProfileIntro','patientProfile'])}}">
                        <a href="#"><i class="fas fa-user-injured"></i><span> Records</span>
                            <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu">
                            <li class="{{Active::checkRoute('patient')}}"><a href="{{route('patient')}}"></i><i
                                        class="fas fa-user-plus" aria-hidden="true"></i>
                                    Register New</a></li>

                            <li class="{{Active::checkRoute(['searchPatient','searchData'])}}"><a
                                    href="{{route('searchPatient')}}"></i><i class="fas fa-search"
                                        aria-hidden="true"></i> Search Patient</a>
                            </li>

                            <li class="{{Active::checkRoute(['patientProfileIntro','patientProfile'])}}"><a
                                    href="{{route('patientProfileIntro')}}"></i><i class="fas fa-id-card"
                                        aria-hidden="true"></i> Patient Profile</a>
                            </li>

                            {{--register in patient--}}
                            <li class="{{Active::checkRoute('register_in_patient_view')}}"><a
                                    href="{{route('register_in_patient_view')}}"><i class="fas fa-user-plus"
                                    area-hidden="true"></i><span> Register In Patient</span></a>
                            </li>
                        </ul>
                    </li>
                    @endif
                    
                    {{--create channel--}}
                    @if ($user_type =='Admin')
                    <li class="{{Active::checkRoute('create_channel_view')}}">
                        <a href="{{route('create_channel_view')}}">
                            <i class="fas fa-folder-plus"></i>
                            <span>Queue</span>
                        </a>
                    </li>
                    @endif

                    

                    @if($user_type =='Admin' || $user_type =='Triage')
                    <li class="{{Active::checkRoute('searchTriage')}}">
                        <a href="{{route('searchTriage')}}">
                        <i class="fa-solid fa-stethoscope" aria-hidden="true"></i>
                            <span> Triage</span>
                        </a>
                    </li>
                    
                    @endif
                    @if($user_type =='admin' || $user_type=='Lab')
                        <li class="{{Active::checkRoute('labqueue')}}">
                            <a href="{{route('labqueue')}}">
                                <i class="fas fa-folder-plus"></i>
                                <span>Queue</span>
                            </a>
                        </li>
                        <li class="{{Active::checkRoute('searchLab')}}"><a href="{{route('searchLab')}}"><i class="fa fa-flask" aria-hidden="true"></i><span> Lab</span></a></li>
                       
                        <li class="{{Active::checkRoute('labMeasure')}}"><a href="{{route('labMeasure')}}"><i class="fa-solid fa-list"></i><span class="ml-2"> Lab Tests List</span></a></li>
                    @endif
                    
                    @if(Auth::user()->user_type=='admin' || $user_type=='Doctor' || $user_type=="Doctor_consultation")
                    {{--check patient--}}
                    <li class="{{Active::checkRoute('check_patient_view')}}"><a
                            href="{{route('check_patient_view')}}"><i class="fa fa-user-md" aria-hidden="true"></i><span> Consultation</span></a></li>
                    @endif

                    @if ($user_type == "Doctor_dentist" || Auth::user()->user_type=='admin')
                    <li class="{{Active::checkRoute('check_patient_view')}}"><a
                        href="{{route('check_patient_view')}}">
                        <i class="fa fa-tooth"></i>
                    <span> Dentist</span></a></li>
                    @endif

                    @if ($user_type=='Doctor_physiotherapy' || Auth::user()->user_type=='admin')
                    <li class="{{Active::checkRoute('check_patient_view')}}"><a
                        href="{{route('check_patient_view')}}"><i class="fa fa-wheelchair" aria-hidden="true"></i><span> Physiotherapy</span></a></li>
                    @endif

                    @if ($user_type=='Doctor_counselling' || Auth::user()->user_type=='admin')
                    <li class="{{Active::checkRoute('check_patient_view')}}"><a
                        href="{{route('check_patient_view')}}"><i class="fa fa-couch" aria-hidden="true"></i><span> Counselling</span></a></li>
                    @endif

                    @if (Auth::user()->user_type == "doctor_radiology_imaging"  || Auth::user()->user_type=="admin")
                    <li class="{{Active::checkRoute('searchRadiology')}}">
                        <a href="{{route('searchRadiology')}}">
                            <i class="fa fa-image"></i><span>Radiology and Imaging</span>
                        </a>
                    </li>
                    <li class="{{Active::checkRoute('radiology-services')}}">
                        <a href="{{route('radiology-services.index')}}">
                            <i class="fa fa-image"></i><span>Radiology Services</span>
                        </a>
                    </li>
                    @endif

                    @if (Auth::user()->user_type == "doctor_radiology_imaging"  || Auth::user()->user_type=="admin")
                    <li class="{{Active::checkRoute('surgery-services')}}">
                        <a href="{{route('surgery-services.index')}}">
                            <i class="fa fa-image"></i><span>Services</span>
                        </a>
                    </li>
                    <li class="{{Active::checkRoute('surgerySearchPatient')}}">
                        <a href="{{route('surgerySearchPatient')}}">
                            <i class="fa fa-image"></i><span>Surgery</span>
                        </a>
                    </li>
                    @endif
                   
                    @if(Auth::user()->user_type=='pharmacist' || Auth::user()->user_type=='admin')
                    {{--Issue Medicine--}}
                    <li class="{{Active::checkRoute('issueMedicineView')}}"><a href="{{route('issueMedicineView')}}">
                        <i class="fa fa-capsules"></i><span> Pharmacy</span></a></li>  
                    
                    <li class="{{Active::checkRoute('medinventory')}}"><a href="{{route('medinventory')}}">
                        <i class="fa fa-list-alt" aria-hidden="true"></i><span> Medicine Inventory</span></a></li>  
                        <li class="{{Active::checkRoute('medinventoryadd')}}"><a href="{{route('medinventoryadd')}}">
                        <i class="fa-solid fa-notes-medical"></i><span> Add Medicine</span></a></li>  
                    @endif
                    
                    @if (Auth::user()->user_type == "Theatre"  || Auth::user()->user_type=="admin")
                    <li class="{{Active::checkRoute('searchtheatre')}}"><a href="{{route('searchtheatre')}}" aria-hidden="true"><i class="fa-solid fa-temperature-arrow-up"></i> <span>Theatre</span></a></li>
                    @endif

                    @if (Auth::user()->user_type == "Dialysis"  || Auth::user()->user_type=="admin")
                    <li class="{{Active::checkRoute('searchDialysis')}}"><a href="{{route('searchDialysis')}}"><i class="fa-solid fa-boxes-packing"></i> <span> Dialysis</span></a></li>
                    @endif

                    {{--maternity--}}
                    @if (Auth::user()->user_type == "doctor_maternity" || Auth::user()->user_type=="admin")
                        <li
                        class="treeview {{Active::checkRoute(['checkmertanitypatient', 'deliveryinto'])}}">
                        <a href="#"><i class="fa fa-baby-carriage"></i><span> Maternity</span>
                            <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu">
                            <li class="{{Active::checkRoute('checkmertanitypatient')}}"><a href="{{route('checkmertanitypatient')}}"></i><i
                                        class="fa fa-baby-carriage" aria-hidden="true"></i>
                                        Antenatal</a></li>

                            <li class="{{Active::checkRoute('deliveryinto')}}"><a href="{{route('deliveryinto')}}"></i><i
                                        class="fa fa-baby-carriage" aria-hidden="true"></i>
                                        Delivery</a></li>
                        </ul>
                    </li>
                    @endif

                    @if (Auth::user()->user_type == "cashier" || Auth::user()->user_type=="admin")
                    <li class="{{Active::checkRoute('cashier-queue')}}">
                        <a href="{{route('cashierqueue')}}">
                            <i class="fas fa-folder-plus"></i>
                            <span>Queue</span>
                        </a>
                    </li>

                    <li class="{{Active::checkRoute('cashiercheckp')}}">
                        <a href="{{route('cashiercheckp')}}">
                            <i class="fa fa-credit-card" aria-hidden="true"></i>
                            <span>Cashier</span>
                        </a>
                    </li>
                    @endif
                    {{--
                    @if ($user_type == "Cashier" || $user_type=="admin")
                    <li class="{{Active::checkRoute('inpatientlist')}}">
                        <a href="{{route('inpatientlist')}}">
                            <i class="fa fa-credit-card" aria-hidden="true"></i>
                            <span>Cashier In Patient</span>
                        </a>
                    </li>
                    @endif
                    --}}
                    @if (Auth::user()->user_type=="admin")
                    <li
                        class="treeview {{Active::checkRoute(['inpatientqueue', 'checkinpatientsearch', 'discharge_inpatient', 'dischaged'])}}">
                        <a href="#"><i class="fas fa-user-injured"></i><span> In Patient</span>
                            <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu">
                            <li class="{{Active::checkRoute('inpatientqueue')}}"><a href="{{route('inpatientqueue')}}"></i><i
                                        class="fas fa-user-plus" aria-hidden="true"></i>
                                    Inpatient List</a></li>

                                    <li class="{{Active::checkRoute('checkinpatientsearch')}}"><a href="{{route('checkinpatientsearch')}}"></i><i
                                        class="fas fa-user-plus" aria-hidden="true"></i>
                                    Check Inpatient</a></li>

                                    @if(Auth::user()->user_type=='Doctor' || Auth::user()->user_type=='admin')
                                    {{--discharge in patient--}}
                                    <li class="{{Active::checkRoute('discharge_inpatient')}}"><a
                                            href="{{route('discharge_inpatient')}}"><i class="fa fa-hospital-o"
                                                area-hidden="true">
                                            </i><span>Discharge In Patient</span></a>
                                    </li>
                                    @endif

                                    <li class="{{Active::checkRoute('dischaged')}}"><a href="{{route('dischaged')}}"></i><i
                                        class="fa fa-minus-circle" aria-hidden="true"></i>
                                        Dischaged Patients</a></li>
                        </ul>
                    </li>
                    @endif
                    

                    {{--
                    
                    @if ($user_type == "Physiotherapy" || $user_type=="admin")
                    <li class="{{Active::checkRoute('searchphysiotherapy')}}"><a href="{{route('searchphysiotherapy')}}"><i
                        class="fa fa-plus-square"></i><span>Physiotherapy</span></a></li>
                    @endif


                    --}}
                    
                    {{--
                    <li class="treeview {{Active::checkRoute(['attendmore','myattend'])}}">
                        <a href="#"><i class="fas fa-calendar-check"></i></i><span> Attendance</span>
                            <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu">
                            <li class="{{Active::checkRoute('myattend')}}"><a href="{{route('myattend')}}"><i
                                        class="fas fa-calendar-day" aria-hidden="true"></i>&nbsp; My
                                    Attendance</a></li>
                            @if($user_type=='Admssin')
                            <li class="{{Active::checkRoute('attendmore')}}"><a href="{{route('attendmore')}}"><i
                                        class="fas fa-plus-square" aria-hidden="true"></i>&nbsp; More</a></li>
                            @endif
                        </ul>
                    </li>

                    --}}
                    @if(Auth::user()->user_type=='admin' || Auth::user()->user_type == 'Accounts')
                    <li class="{{Active::checkRoute('accountsearch')}}">
                        <a href="{{route('accountsearch')}}">
                            <i class="fa-solid fa-receipt"></i>
                            <span>Invoices</span>
                        </a>
                    </li>
                    @endif

                    @if(Auth::user()->user_type=='admin')
                    {{-- Users Operations --}}

                    <li class="{{Active::checkRoute(['newuser','regfinger','resetuser'])}} treeview">
                        <a href="#"><i class="fas fa-users-cog"></i><span> Users</span>
                            <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu">
                            <li class="{{Active::checkRoute('newuser')}}"><a href="{{route('newuser')}}"><i
                                        class="fa fa-user-plus" aria-hidden="true"></i>New
                                    User</a></li>
                            <li class="{{Active::checkRoute('regfinger')}}"><a href="{{route('regfinger')}}"><i
                                        class="fa fa-fingerprint" aria-hidden="true"></i>Register Fingerprint</a></li>
                            <li class="{{Active::checkRoute('resetuser')}}"><a href="{{route('resetuser')}}"><i
                                        class="fa fa-user-edit" aria-hidden="true"></i>Reset
                                    User</a></li>
                        </ul>
                    </li>
                    @endif

                    {{-- Profile --}}

                    <li class="{{Active::checkRoute('profile')}}"><a href="{{route('profile')}}"><i
                                class="fas fa-user"></i><span> Profile</span></a></li>

                    {{-- Wards --}}

                    @if(Auth::user()->user_type=='admin' || Auth::user()->user_type == 'nurse')
                    <li class="{{Active::checkRoute('wards')}}"><a href="{{route('wards')}}"><i
                                class="fas fa-warehouse"></i>
                            <span>&nbsp;Wards</span></a></li>
                    @endif

                    @if($user_type=="admin")
                    {{--add notices--}}
                    <li class="{{Active::checkRoute('createnoticeview')}}">
                        <a href="{{route('createnoticeview')}}">
                            <i class="fas fa-envelope-open-text"></i>
                            <span> Notices</span>
                        </a>
                    </li>
                    @endif

                    

                    @if($user_type=="admin"||$user_type=="Doctor")
                    {{--statistics--}}
                    <li class="{{Active::checkRoute(['stats','stats_old'])}}">
                        <a href="{{route('stats')}}">
                            <i class="fas fa-chart-line"></i></i>
                            <span> Statistics</span>
                        </a>
                    </li>
                    @endif


                    {{--report generation--}}
                    @if($user_type=="admin"||$user_type=="Doctor")
                    <li
                        class="treeview {{Active::checkRoute(['inPatientReport','inPatientReportData','clinic_reports','mob_clinic_report','mon_stat_report','out_p_report','attendance_report'])}}">
                        <a href="#">
                            <i class="fas fa-sticky-note"></i>
                            <span> Report Generation</span>
                            <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu">
                            

                            @if($user_type=="admin"||$user_type=="Doctor")
                            <li class="{{Active::checkRoute('mon_stat_report')}}"><a
                                    href="{{route('mon_stat_report')}}"><i class="fa fa-sticky-note"
                                        aria-hidden="true"></i> Monthly Statistic Report</a></li>
                            


                            <li class="{{Active::checkRoute(['inPatientReport','inPatientReportData'])}}"><a
                                    href="{{route('inPatientReport')}}"><i class="fa fa-hospital-o"
                                        area-hidden="true"></i><span>In Patient Stats</span></a>
                            </li>

                            
                                        @endif
                        </ul>
                    </li>

                    @endif
                </ul>

                <!-- /.sidebar-menu -->
            </section>
            <!-- /.sidebar -->
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            {{--  
            <section class="content-header">
                <h1>
                    @yield('content_title')
                    <small>@yield('content_description')</small>
                </h1>
                @yield('breadcrumbs')

            </section>
--}}
            <!-- Main content -->
            <section class="content container-fluid">
                @yield('main_content')
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        <!-- Main Footer -->
        <footer class="main-footer">
            <!-- To the right -->
            <div class="pull-right hidden-xs">
                Version 1.0
            </div>
            <!-- Default to the left -->
            <strong>Copyright &copy; {{date('Y')}} <a href="http">Zulten-WS</a>.</strong> All rights reserved.
        </footer>



        <div class="control-sidebar-bg"></div>
    </div>


    <script src="{{asset('bower_components/bootstrap/dist/js/bootstrap.js')}}"></script>
    <script src="{{asset('bower_components/fastclick/lib/fastclick.js')}}"></script>
    <script src="{{asset('dist/js/adminlte.min.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/5.4.0/bootbox.min.js"></script>
    <script>
        $("#preloader").fadeOut();
    $("#spinner").fadeOut();
    </script>
    <!--Datepicker-->
    <script src="{{asset('bower_components/moment/min/moment.min.js')}}"></script>
    <script src="{{asset('bower_components/bootstrap-daterangepicker/daterangepicker.js')}}"></script>
    <script src="{{asset('bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js')}}"></script>
    <script src="{{asset('bower_components/datatables.net/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js')}}"></script>
    <script src="{{asset('bower_components/datatables.net-bs/js/dataTables.buttons.min.js')}}"></script>
    <script src="{{asset('bower_components/jquery-slimscroll/jquery.slimscroll.min.js')}}"></script>
    
    


    @yield('optional_scripts')

</body>

</html>

@endauth

@guest
"aaaa";
@endguest
