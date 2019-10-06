@extends('admin_layout')

@section('admin_content')

    <div class="row-fluid sortable">
        <div class="box span6">
            <div class="box-header" data-original-title>
                <h2><i class="halflings-icon user"></i><span class="break"></span>Customer Details</h2>
            </div>
            <div class="box-content">
                <table class="table table-striped table-bordered bootstrap-datatable ">
                    <thead>
                        <tr>
                            <th>Customer Name</th>
                            <th>Mobile Number</th>
                            <th>Payment Gateway</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            @foreach($all_info as $info)
                            @endforeach
                            <td>{{$info->customer_name}}</td>
                            <td>{{$info->mobile_number}}</td>
                            <td>{{$info->payment_method}}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div><!--/span-->

        <div class="box span6">
            <div class="box-header" data-original-title>
                <h2><i class="halflings-icon user"></i><span class="break"></span>Shipping Details</h2>
            </div>
            <div class="box-content">
                <table class="table table-striped table-bordered bootstrap-datatable ">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Address</th>
                            <th>Mobile Number</th>
                            <th>Email</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            @foreach($all_info as $info)
                            @endforeach
                            <td>{{$info->shipping_first_name.$info->shipping_last_name}}</td>
                            <td>{{$info->shipping_address}}</td>
                            <td>{{$info->shipping_mobile_number}}</td>
                            <td>{{$info->shipping_email}}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div><!--/span-->
    </div><!-- Row 1 end  -->


    <!-- Row 2 Start  -->
    <div class="row-fluid sortable">
        <div class="box span12">
            <div class="box-header" data-original-title>
                <h2><i class="halflings-icon user"></i><span class="break"></span>Order Details</h2>
            </div>
            <div class="box-content">
                <table class="table table-striped table-bordered bootstrap-datatable ">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Product Name</th>
                            <th>Product Price</th>
                            <th>Product Sales Quantity</th>
                            <th>Product Sub Total</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($all_info as $info)
                        <tr>
                            <td>{{$info->order_id}}</td>
                            <td>{{$info->product_name}}</td>
                            <td>{{$info->product_price}}</td>
                            <td>{{$info->product_sales_quantity}}</td>
                            <td>{{$info->product_price*$info->product_sales_quantity}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div><!--/span-->
    </div>


@endsection