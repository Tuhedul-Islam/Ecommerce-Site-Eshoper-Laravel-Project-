@extends('admin_layout')

@section('admin_content')
    <ul class="breadcrumb">
        <li>
            <i class="icon-home"></i>
            <a href="index.html">Home</a>
            <i class="icon-angle-right"></i>
        </li>
        <li><a href="#">All Slider</a></li>
    </ul>

    <div class="row-fluid sortable">
        <div class="box span12">
            <div class="box-header" data-original-title>
                <h2><i class="halflings-icon user"></i><span class="break"></span>All Slider</h2>
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
                <table class="table table-striped table-bordered bootstrap-datatable ">
                    <thead>
                    <tr>
                        <th>Product ID</th>
                        <th>Slider Image</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    @foreach($all_slider as $v_slider)
                        <tbody>
                        <tr>
                            <td>{{$v_slider->slider_id}}</td>
                            <td class="center"><img src="{{URL::to($v_slider->slider_image)}}" height="50px" width="80px" class="img-responsive" alt=""></td>


                            <td class="center">
                                @if($v_slider->publication_status == 1)
                                    <span class="label label-success">Active</span>
                                @else
                                    <span class="label label-danger">Inactive</span>
                                @endif
                            </td>
                            <td class="center">
                                @if($v_slider->publication_status == 1)
                                    <a class="btn btn-danger" href="{{URL::to('/active-inactive-slider/'.$v_slider->slider_id."/".$v_slider->publication_status)}}">
                                        <i class="halflings-icon white thumbs-down"></i>
                                    </a>
                                @else
                                    <a class="btn btn-success" href="{{URL::to('/active-inactive-slider/'.$v_slider->slider_id."/".$v_slider->publication_status)}}">
                                        <i class="halflings-icon white thumbs-up"></i>
                                    </a>
                                @endif
                                <a class="btn btn-danger" href="{{url('/delete-slider', $v_slider->slider_id)}}" id="delete">
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