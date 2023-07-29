<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <link rel="stylesheet" href="{{asset('bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css')}}">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css"
        integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
    <script src="https://code.jquery.com/jquery-3.4.1.js"
        integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU=" crossorigin="anonymous"></script>
        <style>
            *{
                    padding: 0px;
                    margin:  0px;
                }
                html,body{
                    height: 100%;
                    overflow: hidden;
                }
                .main{
                    margin-top: 10%;	
                }
                #admin, #user{
                    border:2px solid;
                    width: 180px;
                    margin-right: 10px;
                }
                #admin:hover,#user:hover{
                    background-color: green;
                }
                #container{
                    display: grid;
                    grid-template-columns: auto 38%;
                    grid-template-rows: 20% auto 10%;
                    grid-template-areas: 
                    "header header"
                    "content sidebar"
                    "footer footer";
                    height: 100vh;
                    background-color: #032401;
                }
                #header{
                    grid-area: header;
                    display: grid;
                    grid-template-columns: 25% auto 40%;
                    width: 100vw;
                }
                #header_image{
                    height: 80px;
                }
                ul{
                    list-style-type: none;
                }
                ul li{
                    margin-bottom: 10px;
                }
                .header_price{
                    border:1px white;
                    background-color: black;
                    margin: 10px;
                    color: #39FF14;
                }
                #content{
                    grid-area: content;
                    display: grid;
                    grid-template-rows: auto 15%;
                    
                }
                #price_column{
                    border:2px solid black;
                    background-color: white;
                }
                #table_buttons{
                    display: grid;
                    grid-template-columns: 60% auto ;
                    grid-gap:30px;
                    margin-left: 8px;
                    margin-top: -40px;
                }
                #buttons{
                    height:50px;
                }
                #sidebar{
                    margin: 8px;
                    grid-area: sidebar;
                    display: grid;
                    grid-template-rows: 10% 74% auto;
                }
                #search{
                    float: right;
                }
                #product_area{
                    background-color: white;
                    border:2px solid black;
                    margin-top: 0px;
                }
                #enter_area{
                    display: grid;
                    grid-template-columns: 1fr;
                }
                #footer{
                    width: 100vw;
                    grid-area: footer;
                    display: grid;
                    grid-template-columns: 2fr 1fr 1fr 1fr 1fr 1fr 1fr;
                }
                #tableData tr:hover,#products tr:hover{
                    background-color: #ffff99;
                }
                #table1 th{
                    font-style: bold;
                    padding: 20px !important;
                }


                .my-custom-scrollbar-a{
                    position: relative;
                    height: 350px;
                    overflow: auto;
                }

                .my-custom-scrollbar{
                    position: relative;
                    height: 300px;
                    overflow: auto;
                }

                .table-wrapper-scroll-y{
                    display: block;
                }


            </style>
</head>
<body>
    <form action="{{ route('cashiercheckprint') }}" method="post">

        @csrf
    
    <div class="" id="container">
        
		<div id="header">
            
            
            
			<div>
				<img class="img-fluid " src="/images/WKMHLogo.png" style="height: 20vh; width: 15vw"/>
			</div>
			<div class="text-white mt-0 ml-5">
				<table class="table-responsive-sm">
					<tbody>
						<tr>
							<td valign="baseline"><small>User Logged on:</small></td>
							<td valign="baseline"><small><p class="pt-3 ml-5"><i class="fas fa-user-shield"></i> {{Auth::user()->name}}</p></small></td>
						</tr>
						<tr>
							<td valign="baseline"><small class="mt-5">Customer Name:</small></td>
							<td valign="baseline"><small><div class="content p-0 ml-5"><input type="text" class="form-control form-control-sm customer_search" autocomplete="off" data-provide="typeahead" id="customer_search" value="{{$search_result->name}}" name="patient_name"/></small></div>
							</td>
							
						</tr>
						<tr>
							<td valign="baseline"><small class="mt-5">Payment Method:</small></td>
							<td valign="baseline"><small><div class="content p-0 ml-5"><input type="text" class="form-control form-control-sm customer_search" autocomplete="off" data-provide="typeahead" id="payment_method" value="{{ $appointment->mode_of_payment }}" name="payment_method"/></small></div>
							</td>
							
						</tr>
					</tbody>
				</table>
			</div>
			<div class="header_price border p-0">
				<h5>Grand Total</h5>
				<p class="pb-0 mr-2" style="float: right; font-size: 40px;" >KSH<span id="t_amounts">0.00</span></p>
			</div>
		</div>
		<div id="content" class="mr-2" >
			<div id="price_column" class="m-2 table-responsive-sm table-wrapper-scroll-y my-custom-scrollbar-a">
				
				<table class="table-striped w-100 font-weight-bold" style="cursor: pointer; " id="table2">
					<thead>
						<tr class='text-center'>
							
							<th>Service</th>
							<th>Price</th>
							
							<th>Qty</th>
							<th>Sub.Total</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody id="tableData" style="text-align: center">
                        
                        
                     
					</tbody>
				</table>
				
			</div>
			<div id="table_buttons">
                
				
				<div class="">
                    <label for="" style="color: white; font-size: 23px;">Enter Paid Amout: </label>
                    <input type="number" name="paid_amount" class="form-control" style="height: 60px; font-size: 23px" id="paidamounts">
				</div>

                <div class="">
                    <label for="" style="color: white; font-size: 23px;">Balance: </label>
                    <input type="number" name="balance" class="form-control" readonly style="height: 60px; font-size: 23px; width: 70%" id="balances">
				</div>
			</div>
		</div>
        <div id="sidebar">
			<div class="mt-1 ">
			<div class="input-group"><div class="input-group-prepend"><span class="input-group-text" id="basic-addon1"><i class="fas fa-search"></i></span></div>
   				<input class="form-control" type="text" placeholder="Product Search" aria-label="Search" id="search" name="search" />
   			</div></div>
			<div id="product_area" class="table-responsive-sm mt-2 table-wrapper-scroll-y my-custom-scrollbar" >
				<table class="w-100 table-striped font-weight-bold" style="cursor: pointer; " id="table1">
					<thead>
						<tr claclass='text-center'><b>
							<td style="width: 25%">ID</td>
							<td>Service Name</td>
							<td>Price</td>
						
						</tr></b>
						<tbody id="products">
							
						</tbody>
					</thead>
				</table>
			</div>
			<div class="w-100 mt-2" id="enter_area">
				<button id="buttons" style="visibility: hidden" type="button" class="cancel btn btn-secondary border"><i class="fas fa-ban"></i> Cancel</button>
			</div>
		</div>
        
		<div id="footer" >
                {{--
			    @foreach ($billing as $bill)
                    <input type="hidden" value="{{ $bill->billing_for }}" name="medicines[]">
                    <input type="hidden" value="{{ $bill->amount }}" name="amount[]">
                    <input type="hidden" value="{{ $bill->qty }}" name="qty[]">
                   
                    
                @endforeach

                <input type="hidden" name="total" id="totals" >
                <input type="hidden" value="{{ $appointment->id }}" id="appointment" name="appointment">
                <input type="hidden" name="keyword" value="{{$search_result->id}}">

                --}}
                <input type="hidden" name="total" id="totals" >
                <input type="hidden" value="{{ $appointment->id }}" id="appointment" name="appointment">
                <input type="hidden" id="keyword" name="keyword" value="{{$search_result->id}}">
                <button id="buttons" type="submit" style="width: 90%"  name='enter' class="btn btn-success  mr-2 ml-2" type="submit"><i class="fas fa-handshake"></i> Finish and Print Receipt</button>
            
			<button id="buttons" type="button" onclick="window.open('{{route('services',$appointment->id)}}','myWin','scrollbars=yes,width=720,height=690,location=no').focus();"  class="btn btn-warning mr-2"><i class="fas fa-box-open"></i> Services</button>
			<button id="buttons" type="button" style="visibility: hidden" class="btn btn-secondary  mr-2"><i class="fas fa-user-tie"></i> Supplier</button>
			
			<button id="buttons" style="visibility: hidden"  class="btn btn-secondary border mr-2"><i class="fas fa-globe"></i> Logs</button>
			
			<button id="buttons" style="visibility: hidden" class="btn btn-secondary border mr-2"><i class="fas fa-shopping-cart"></i> Sales</button>
			<button id="buttons" style="visibility: hidden" class="btn btn-secondary border mr-2"><i class="fas fa-truck"></i> Deliveries</button>
            <a id="buttons" class="logout btn btn-danger  mr-2" href="{{ route('cashiercheckp') }}" ><i class="fas fa-ban"></i> Cancel</a>
			
		</div>
	</div>

    {{--
    <div style="display: none">
        <input type="text" value="{{ $appointment->id }}" id="appointment">
        <input type="text" value="{{ $search_result->id }}" id="keywordp">
    </div>
    --}}


</form>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js" integrity="sha512-3P8rXCuGJdNZOnUx/03c1jOTnMn3rP63nBip5gOP2qmUh5YAdVAvFZ1E+QLZZbC1rtMrQb+mah3AfYW11RUrWA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.6.6/dist/sweetalert2.all.min.js"></script>
    <script defer>
        /*
        var amt = document.querySelectorAll('#amount');
        
        
        var t_amounts = document.getElementById('t_amounts');
        var appointment_id = document.getElementById('appointment');
        amt.forEach(element => {
            x = x + parseInt(element.innerText);
        });
        
        t_amounts.innerHTML = "KSH " + x;
        */
        var x = 0;

        $('#balances').val(x);

        $('#paidamounts').on('input', function() {
            calcBalance($(this).val());
        });

        //$('#totals').val(x);

        function calcBalance(paidamount) {
            var total = $('#t_amounts').text() - 0;
            var bal = paidamount - total;
            $('#balances').val(bal);
        }
        
        
        function printcashier() {
            var appointment_id = document.getElementById('appointment').value;
            var keyword = document.getElementById('keywordp').value;
            var data = new FormData;
            data.append('appNum', appointment_id);
            data.append('depatment', 'done');
            data.append('keyword', keyword);
            data.append('appointment', appointment_id);
            data.append('_token', '{{csrf_token()}}');


            $.ajax({
                type: "POST",
                url: "",
                processData: false,
                contentType: false,
                cache: false,
                data:data,
                success: function () {
                    if(response==200){
                    window.location = 'cashiercheckpprint';
                    }
                }
            });

        }
        


        function getProds() {
            $.ajax({
            type: "get",
            url: "{{ route('allservices') }}",
            processData: false,
            contentType: false,
            cache: false,
            dataType: 'json',
            success: function (response) {
                for (let i = 0; i < response.data.length; i++) {
                    
                    var fieldhtml = '<tr class="js-add" data-id=' + response.data[i].id + ' data-measure_name="'+ response.data[i].measure_name + '" data-amount='+response.data[i].amount+'><td>'+ response.data[i].id +'</td><td>'+response.data[i].measure_name+'</td><td > KSH '+ response.data[i].amount +'</td></tr>';

                    $('#products').append(fieldhtml);
                    
                }
            }
        })
        }


        //getProds();
        

        $('body').on('click', '.js-add', function(){
            var totalPrice = 0;
   		    var target = $(this);
            var service = target.attr('data-measure_name');
            var total = target.attr('data-amount');
            //var unit = target.attr('data-unt'); 

            

            Swal.fire({
                    title: "Enter number of items:",
                    input: "text",
               
            }).then((value) => {
                var val = value.value;
                if (val == '') {
                    swal("Error","Entered none!","error");
                } else {
                    var qtynum = val;
                    var amount = parseInt(val,10) * total;
                    var myhtml = '<tr class="prd"><td class="service">'+service+'<input type="hidden" name="service[]" value="' + service + '" /></td><td>' + amount +'<input type="hidden" name="amount[]" value="'+amount+'"/></td><td class="qty">'+ qtynum +'<input type="hidden" name="qty[]" class="qtyInput" value="'+ qtynum +'"></td><td class="totalPrice">'+ amount +'<input type="hidden" name="totalprice[]" value="'+ amount +'" /></td><td><button class="btn btn-danger btn-sm" type="button" id="delete-row"><i class="fas fa-times-circle"></i></button></td></tr>';
                    $('#tableData').append(myhtml);
                    GrandTotal();
                }
            })

            

            

            
        });



        function GrandTotal() {
            var TotalValue = 0;
            var TotalPriceArr = $('#tableData tr .totalPrice').get();

            $(TotalPriceArr).each(function(){
                TotalValue += parseFloat($(this).text());
            });

            //console.log(TotalValue);

            $('#t_amounts').text(TotalValue);
            $('#totals').val(TotalValue);

        }

        $("body").on('click','#delete-row', function(){
            
                    $(this).parents("tr").remove();
                    
                    GrandTotal();
        });
        
        function searchProducts() {

        }
        $('#search').on('keyup',function(){
            $value=$(this).val();
            $.ajax({
                type : 'get',
                url : "{{route('searchservice')}}",
                data:{'search':$value},
                success:function(data){
                $('#products').html(data);
                }
            });
        });
        /*
        function submitForm(){
    
            var total = $('#t_amounts').text() - 0;

            var paid_amount = $('#paidamounts').val() - 0;
            var balance = $('#balances').val() - 0;

            var services = [];
            var amount = [];
            var qty = [];

            $('.totalPrice').each(function(){
                amount.push($(this).text() - 0);
            });


            $('.service').each(function(){
                services.push($(this).text());
            });


            $('.qty').each(function(){
                qty.push($(this).text() - 0);
            });

            var payment_method = $('#payment_method').val();
            var appointment = $('#appointment').val();
            var pid = $('#keyword').val();

            var data=new FormData;
            data.append('keyword', pid);
            data.append('_token','{{csrf_token()}}');
            data.append('total', total);
            data.append('paid_amount', paid_amount);
            data.append('balance', balance);
            data.append('services', services);
            data.append('totalprice', amount);
            data.append('qty', qty);
            data.append('payment_method', payment_method);
            data.append('appointment', appointment);
            

            $.ajax({
                type: "POST",
                url: "",
                processData: false,
                contentType: false,
                cache: false,
                data:data,
                error: function(data){
                    console.log(data);
                },
                success: function (appointment) {
                    console.log(appointment);
                    /*
                    if(appointment.exist){
                        console.log(appointment);
                        $("#btn_submit").removeAttr("disabled");
                        $("#btn_submit").focus();
                        $("#details").fadeIn();
                        $("#p_name").text(appointment.name);
                        $("#pnum").val(appointment.pNum);
                        $("#finger").text(appointment.finger);
                        $("#appt_num").text(appointment.appNum);
                        $("#appt_num_1").val(appointment.appNum);
                        $("#appNum").focus();
                    }else{
                        $("#details").fadeOut();
                        $("#btn-submit").attr("disabled","disabled");
                        $("#validation").text("Invalid Patient Number. Check Again...");
                        $("#appNum").focus();
                    }
                   
                }
            });
            

        }
         */
       
    </script>
</body>
</html>




