<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class SliderController extends Controller
{
    public function __construct()
    {
        $admin_id = Session::get('admin_id');
        if ($admin_id){
            return view('admin.dashbord');
        }else{
            return  redirect('/admin')->send();
        }
    }



    public function index(){
        //echo  "yep";
        return view('admin.add-slider');
    }



    public function save_slider(Request $request){
        $data = array();
        $data['publication_status'] = $request->publication_status;
        $image = $request->file('slider_image');

        if ($data['publication_status']==null){
            $data['publication_status'] = 0;
        }

        if($image){
            $image_name = str_random(20);
            $ext = strtolower($image->getClientOriginalName());
            $image_full_name = $image_name.'.'.$ext;
            $upload_path = 'sliderImg/';
            $image_url = $upload_path.$image_full_name;
            $success = $image->move($upload_path, $image_full_name);
            if ($success){
                $data['slider_image'] = $image_url;
                DB::table('tbl_slider')->insert($data);

                Session::put('msg', 'Slider Image added successfully');
                return redirect('/add-slider');
            }
        }
        /*$data['slider_image'] = '';
        DB::table('tbl_slider')->insert($data);*/

        Session::put('msg', 'Slider not added. Slider Image not Found');
        return redirect('/add-slider');
    }


    public function all_slider(){
        /*
        //Can also use [alternative]
        $all_category = DB::table('tbl_category')->get();
        $manage_category = view('admin.all-category')
                                ->with('all_cat',$all_category); //to retrieve use [all_cat]
        return view('admin_layout')
                ->with('admin.all-category', $manage_category);
        */

        $all_slider = DB::table('tbl_slider')->orderby('slider_id','desc')->get();
        return view('admin.all-slider', compact('all_slider'));
    }



    // We may use different method for active or inactive the publication status
    public function active_inactive_slider($slider_id, $status){
        //echo $category_id;

        $status = $status ==1 ? 0:1;
        //echo $status;

        DB::table('tbl_slider')
            ->where('slider_id', $slider_id)
            ->update(['publication_status' => $status]);
        //can use model [findORFail($category_id)]

        Session::put('msg', 'Slider Publication Status successfully updated');
        return Redirect::to('/all-slider');

    }




    public function delete_slider($slider_id){
        //echo $category_id;

        $row =  DB::table('tbl_slider')
            ->where('slider_id', $slider_id)
            ->first();
        //echo $row->product_image;
        //return $row;

        $image_name = $row->slider_image;
        /*if (file_exists($image_name)){
            echo "true";
        }
        else {
            echo  "F";
        }*/


        if (!empty($image_name)){
            if (file_exists($image_name)){
                File::delete($image_name);
                DB::table('tbl_slider')
                    ->where('slider_id', $slider_id)->delete();

                Session::put('msg','Slider Item deleted Successfully');
                return Redirect::to('/all-slider');
            }
            else
            {
                Session::put('msg','Slider Item not deleted !! (Image not found in the Local directory)');
                return Redirect::to('/all-slider');
            }
        }else
        {
            Session::put('msg','Slider Item not deleted !! (Image not found)');
            return Redirect::to('/all-slider');
        }/**/


    }


}
