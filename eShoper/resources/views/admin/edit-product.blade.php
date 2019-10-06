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
            <a href="#">Edit Product</a>
        </li>
    </ul>

    <div class="row-fluid sortable">
        <div class="box span12">
            <div class="box-header" data-original-title>
                <h2><i class="halflings-icon edit"></i><span class="break"></span>Edit Product</h2>
            </div>


            <div class="box-content">
                <form class="form-horizontal" method="post" action="{{url('/update-product', $product_info->product_id)}}" enctype="multipart/form-data">
                    {{csrf_field()}}
                    <fieldset>
                        <div class="control-group">
                            <label class="control-label" for="date01">Product Name</label>
                            <div class="controls">
                                <input type="text" class="input-xlarge " name="product_name" value="{{$product_info->product_name}}" required="">
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label" for="selectError3">Product Category</label>
                            <div class="controls">
                                <?php
                                use Illuminate\Support\Facades\DB;
                                $all_published_cat = DB::table("tbl_category")
                                    ->where('publication_status', 1)
                                    ->get();

                                ?>
                                <select id="selectError3" name="category_id"  >
                                    @foreach($all_published_cat as $category)
                                        <option value="{{$category->category_id}}">{{$category->category_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label" for="selectError3">Manufacture Name</label>
                            <div class="controls">
                                <?php

                                $all_published_manufacture = DB::table("manufacture")
                                    ->where('publication_status', 1)
                                    ->get();
                                ?>
                                <select id="selectError3" name="manufacture_id" >
                                    @foreach($all_published_manufacture as $brand)
                                        <option value="{{$brand->manufacture_id}}">{{$brand->manufacture_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="control-group hidden-phone">
                            <label class="control-label" for="textarea2">Product Short Description</label>
                            <div class="controls">
                                <textarea class="cleditor" name="product_short_description" rows="3" required="">{{$product_info->product_short_description}}</textarea>
                            </div>
                        </div>

                        <div class="control-group hidden-phone">
                            <label class="control-label" for="textarea2">Product Long Description</label>
                            <div class="controls">
                                <textarea class="cleditor" name="product_long_description" rows="3" required="">{{$product_info->product_long_description}}</textarea>
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label" for="date01">Product Price</label>
                            <div class="controls">
                                <input type="text" class="input-xlarge " name="product_price" value="{{$product_info->product_price}}" required="">
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label" for="fileInput">Product Image</label>
                            <div class="controls">
                                <input class="input-file uniform_on" name="product_image" id="fileInput" type="file" required="">
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label" for="date01">Product Size</label>
                            <div class="controls">
                                <input type="text" class="input-xlarge " name="product_size" value="{{$product_info->product_size}}" required="">
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label" for="date01">Product Color</label>
                            <div class="controls">
                                <input type="text" class="input-xlarge " name="product_color" value="{{$product_info->product_color}}" required="">
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label" for="date01">Publication Status</label>
                            <div class="controls">
                                <input type="checkbox" name="publication_status" value="1">
                            </div>
                        </div>
                        <div class="form-actions">
                            <button type="submit" class="btn btn-primary">Update Product</button>
                            <button type="reset" class="btn">Cancel</button>
                        </div>
                    </fieldset>
                </form>

            </div>
        </div><!--/span-->

    </div><!--/row-->
@endsection