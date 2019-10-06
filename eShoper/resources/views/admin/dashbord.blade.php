@extends('admin_layout')

@section('admin_content')

    <ul class="breadcrumb">
        <li>
            <i class="icon-home"></i>
            <a href="{{URL::to('/dashbord')}}">Home</a>
            <i class="icon-angle-right"></i>
        </li>
        <li><a href="#">Dashboard</a></li>
    </ul>

    <div class="row-fluid">
        <a class="quick-button metro yellow span2" href="{{url('/admin-profile')}}" >
            <i class="icon-group"></i>
            <p>Admin Profile</p>
        </a>
        <a class="quick-button metro blue span2" href="{{url('/manage-order')}}" >
            <i class="icon-shopping-cart"></i>
            <p>Orders</p>
        </a>
        <a class="quick-button metro green span2" href="{{url('/all-product')}}" >
            <i class="icon-barcode"></i>
            <p>Products</p>
        </a>
        <div class="clearfix"></div>
    </div><!--/row-->
@endsection