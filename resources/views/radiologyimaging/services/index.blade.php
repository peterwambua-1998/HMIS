@extends('template.main')

@section('title', 'Inventory')

@section('content_title',"Inventory")
@section('content_description',"medicine table")
@section('breadcrumbs')

<ol class="breadcrumb">
    <li><a href="{{route('dash')}}"><i class="fas fa-tachometer-alt"></i>Dashboard</a></li>
    <li class="active">Here</li>
</ol>
@endsection

<style>
    .edit:hover {
        cursor: pointer;
    }
</style>

@section('main_content')
<section class="content">
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

<div class="row mb-3">
    <div class="col-md-10"></div>
    <div class="col-md-2" style="display: flex; flex-direction:row-reverse">
        <a class="btn btn-success" style="width: 100%" href="#" data-toggle="modal" data-target="#add-service">Add Service</a>
    </div>
</div>

<div class="row">
    <div class="col-xs-12">
        <div class="box box-success">
            <div class="box-header">
                <h3 class="box-title">Radiology Services</h3>
            </div>
            
            <div class="box-body">
                <table id="medTable" class="table table-bordered table-hover table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>View</th>
                            <th>Price (KSH)</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $number = 1; ?>
                        @foreach ($collection as $item)
                            <tr>
                                <td>{{$number}}</td>
                                <?php $number++; ?>
                                <td>{{$item->name}}</td>
                                <td>{{$item->view}}</td>
                                <td>{{$item->price}}</td>
                                <td><a href="#">Edit</a></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
</section>

<div class="modal fade" id="add-service" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <form action="{{route('radiology-services.store')}}" method="post">
    @csrf
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel" style="font-weight: bold; font-size: 14px;">ADD SERVICE</h5>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="inputPassword3" class="col-sm-2 control-label">{{__('Name')}} <span style="color:red">*</span></label>
                    <div class="col-sm-10">
                        <input type="text" required class="form-control" name="name" placeholder="Enter service name">
                    </div>
                </div>
                <br>
                <br>
                <div class="form-group">
                    <label for="inputPassword3" class="col-sm-2 control-label">{{__('View')}} <span style="color:red">*</span></label>
                    <div class="col-sm-10">
                        <input type="text" required class="form-control" name="view" placeholder="Enter view">
                    </div>
                </div>
                <br>
                <br>
                <div class="form-group">
                    <label for="inputPassword3" class="col-sm-2 control-label">{{__('Price')}} <span style="color:red">*</span></label>
                    <div class="col-sm-10">
                        <input type="text" required class="form-control" name="price" placeholder="Enter price">
                    </div>
                </div>
                <br>
            </div>
            <div class="modal-footer text-center">
                <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-success">Save changes</button>
            </div>
        </div>
    </div>
    </form>
</div>


<script defer>
    $(document).ready( function () {
        $('#medTable').DataTable();
    });
</script>

@endsection