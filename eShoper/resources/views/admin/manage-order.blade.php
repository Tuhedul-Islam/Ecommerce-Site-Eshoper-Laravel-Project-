@extends('admin_layout')

@section('admin_content')
    <ul class="breadcrumb">
        <li>
            <i class="icon-home"></i>
            <a href="index.html">Home</a>
            <i class="icon-angle-right"></i>
        </li>
        <li><a href="#">Order Details</a></li>
    </ul>

    <div class="row-fluid sortable">
        <div class="box span12">
            <div class="box-header" data-original-title>
                <h2><i class="halflings-icon user"></i><span class="break"></span>Order Details</h2>
            </div>
            <p class="alert-success">
                <?php
                //use Illuminate\Support\Facades\Session;
                $message = Session::get('msg');
                if ($message){
                    echo $message;
                    Session::put('msg', null);
                }
                ?>
            </p>
            <div class="box-content">
                <table class="table table-striped table-bordered bootstrap-datatable">
                    <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Customer Name</th>
                        <th>Order Total</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    @foreach($all_order_info as $order_info)
                        <tbody>
                        <tr>
                            <td>{{$order_info->order_id}}</td>
                            <td class="center">{{$order_info->customer_name}}</td>
                            <td class="center">{{$order_info->order_total}}</td>
                            <td class="center">
                                <span class="label label-success">{{$order_info->order_status}}</span>
                            </td>
                            <td class="center">

                            @if($order_info->order_status  == 'pending')
                                <a class="btn btn-danger" href="{{URL::to('/active-inactive-order/'.$order_info->order_id)}}">
                                    <i class="halflings-icon white thumbs-up"></i>
                                </a>
                            @else
                                <a class="btn btn-danger" href="{{URL::to('/active-inactive-order/'.$order_info->order_id)}}">
                                    <i class="halflings-icon white thumbs-down"></i>
                                </a>
                            @endif
                                <a class="btn btn-info" href="{{URL::to('/view-order-details/'.$order_info->order_id)}}">
                                    <i class="halflings-icon white edit"></i>
                                </a>
                                <a class="btn btn-danger" href="{{url('/delete-order/'.$order_info->order_id)}}" id="delete">
                                    <i class="halflings-icon white trash"></i>
                                </a>
                            </td>
                        </tr>
                        </tbody>
                    @endforeach
                </table>
            </div>
        </div><!--/span-->
@endsection