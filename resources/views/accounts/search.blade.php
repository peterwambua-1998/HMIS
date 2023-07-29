
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

<div class="col-xs-12">
    <div class="box">
        <div class="box-header">
            <h3 class="box-title">{{__('Invoices List')}}</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <table id="invoiceTable" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        
                        
                        <th>{{__('Patient No.')}}</th>
                        <th>{{__('Patient Name')}}</th>
                        
                        <th>{{__('Invoice No')}}</th>
                        <th>{{__('sub_total')}}</th>
                        

                        <th>{{__('Tax')}}</th>

                        <th>{{__('Total')}}</th>

                        <th>{{__('Paid Amount')}}</th>

                        <th>{{__('Balance')}}</th>

                        <th>{{__('Visit Date')}}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($invoices as $invoice)
                        
                      
                            <tr>
                               
                                <td>{{ $invoice->patient_id }}</td>
                                <td>{{ App\Patients::find($invoice->patient_id)->name }}</td>
                                <td>{{ $invoice->serial_number }}</td>
                                <td>{{ $invoice->sub_total }}</td>
                                <td>{{ $invoice->tax }}</td>
                                <td>{{ $invoice->total }}</td>
                                <td>{{ $invoice->paid_amount }}</td>
                                <td>{{ $invoice->balance }}</td>
                                <td>{{ App\Appointment::find($invoice->appointment_id)->created_at }}</td>
                            </tr>
                       
                        
                    @endforeach
                </tbody>
                

            </table>
        </div>
        <!-- /.box-body -->
    </div>
    <!-- /.box -->
</div>


<script>
    $(function() {
        $('#invoiceTable').DataTable();
    });
</script>
@endsection
