@extends('admin_layout')

@section('admin_content')
    <ul class="breadcrumb">
        <li>
            <i class="icon-home"></i>
            <a href="{{URL::to('/dashbord')}}">Home</a>
            <i class="icon-angle-right"></i>
        </li>
        <li>
            <i class="icon-edit"></i>
            <a href="#">Edit Admin Profile</a>
        </li>
    </ul>

    <div class="row-fluid sortable">
        <div class="box span12">
            <div class="box-header" data-original-title>
                <h2><i class="halflings-icon edit"></i><span class="break"></span>Edit Admin Profile</h2>
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
                <form class="form-horizontal" method="post" action="{{url('/update-admin-profile', $admin_info->admin_id)}}">
                    {{csrf_field()}}
                    <fieldset>
                        <div class="control-group">
                            <label class="control-label" for="date01">Admin Name</label>
                            <div class="controls">
                                <input type="text" class="input-xlarge " name="admin_name" value="{{$admin_info->admin_name}}" required="">
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" for="date01">Admin Email</label>
                            <div class="controls">
                                <input type="email" class="input-xlarge " name="admin_email" value="{{$admin_info->admin_email}}" required="">
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" for="date01">Admin password</label>
                            <div class="controls">
                                <input type="text" class="input-xlarge " name="admin_password" placeholder="enter Password" required="">
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" for="date01">Admin Mobile No</label>
                            <div class="controls">
                                <input type="text" class="input-xlarge " name="admin_phone" value="{{$admin_info->admin_phone}}" required="">
                            </div>
                        </div>

                        <div class="form-actions">
                            <button type="submit" class="btn btn-primary">Update Profile</button>
                        </div>
                    </fieldset>
                </form>

            </div>
        </div><!--/span-->

    </div><!--/row-->
@endsection