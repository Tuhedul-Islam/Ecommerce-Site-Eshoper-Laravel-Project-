<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class ProductController extends Controller
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
        return view('admin.add-product');
    }


    public function save_product(Request $request){
        //return $request->all();

        $data = array();
        $data['product_name'] = $request->product_name;
        $data['category_id'] = $request->category_id;
        $data['manufacture_id'] = $request->manufacture_id;
        $data['product_short_description'] = $request->product_short_description;
        $data['product_long_description'] = $request->product_long_description;
        $data['product_price'] = $request->product_price;
        $data['product_size'] = $request->product_size;
        $data['product_color'] = $request->product_color;
        $data['publication_status'] = $request->publication_status;
        $image = $request->file('product_image');

        if ($data['publication_status']==null){
            $data['publication_status'] = 0;
        }

        if($image){
            $image_name = str_random(20);
            $ext = strtolower($image->getClientOriginalName());
            $image_full_name = $image_name.'.'.$ext;
            $upload_path = 'allProductImg/';
            $image_url = $upload_path.$image_full_name;
            $success = $image->move($upload_path, $image_full_name);
            if ($success){
                $data['product_image'] = $image_url;
                DB::table('tbl_products')->insert($data);

                Session::put('msg', 'Product added successfully');
                return redirect('/add-product');
            }
        }
        /*$data['product_image'] = '';
        DB::table('tbl_products')->insert($data);*/

        Session::put('msg', 'Product not added. Product Image not Found');
        return redirect('/add-product');
    }


    public function all_product(){
        /*
       //Can also use [alternative] //in same way here we can use join
       $all_manufacture = DB::table('manufacture')->get();
       $manage_manufacture = view('admin.all-manufacture')
                               ->with('all_manufacture',$all_manufacture); //to retrieve use [all_cat]
       return view('admin_layout')
               ->with('admin.all-manufacture', $manage_manufacture);
       */

        $all_product = DB::table('tbl_products')->orderby('product_id','desc')
                        ->join('tbl_category', 'tbl_products.category_id', '=', 'tbl_category.category_id')
                        ->join('manufacture', 'tbl_products.manufacture_id', '=', 'manufacture.manufacture_id')
                        ->select('tbl_products.*', 'tbl_category.category_name', 'manufacture.manufacture_name')
                        ->get();

        /*echo '<pre>';
        print_r($all_product);
        echo '</pre>';
        */
        return view('admin.all-product', compact('all_product'));
    }



    // We may use different method for active or inactive the publication status
    public function active_inactive_product($product_id, $status){
        //echo $category_id;

        $status = $status ==1 ? 0:1;
        //echo $status;

        DB::table('tbl_products')
            ->where('product_id', $product_id)
            ->update(['publication_status' => $status]);
        //can use model [findORFail($category_id)]

        Session::put('msg', 'Product Publication Status successfully updated');
        return redirect('/all-product');

    }



    public function edit_product($product_id){
        //echo $product_id;
        $product_info = DB::table('tbl_products')
            ->where('product_id', $product_id)->first();

        return view('admin.edit-product', compact('product_info'));
    }



    public function update_product(Request $request , $product_id){
        //echo $product_id;

        //Data Catch........
        $data = array();
        $data['product_name'] = $request->product_name;
        $data['category_id'] = $request->category_id;
        $data['manufacture_id'] = $request->manufacture_id;
        $data['product_short_description'] = $request->product_short_description;
        $data['product_long_description'] = $request->product_long_description;
        $data['product_price'] = $request->product_price;
        $data['product_size'] = $request->product_size;
        $data['product_color'] = $request->product_color;
        $data['publication_status'] = $request->publication_status;
        $image = $request->file('product_image');

        if ($data['publication_status']==null){
            $data['publication_status'] = 0;
        }


        //Update to database & first remove then move Img from local folder
        if($image){
            $image_name = str_random(20);
            $ext = strtolower($image->getClientOriginalName());
            $image_full_name = $image_name.'.'.$ext;
            $upload_path = 'allProductImg/';
            $image_url = $upload_path.$image_full_name;



            // img delete from local folder
            $row1 =  DB::table('tbl_products')
                ->where('product_id', $product_id)
                ->first();
            $image_name_to_del = $row1->product_image;
            if (!empty($image_name_to_del)){
                if (file_exists($image_name_to_del)){
                    File::delete($image_name_to_del);
                }

            }




            $success = $image->move($upload_path, $image_full_name);
            if ($success){
                $data['product_image'] = $image_url;
                DB::table('tbl_products')
                    ->where('product_id', $product_id)
                    ->update($data);

                Session::put('msg', 'Product Updated successfully');
                return redirect('/all-product');
            }
        }
        /*$data['product_image'] = '';
        DB::table('tbl_products')->insert($data);*/

        Session::put('msg', 'Product not Updated. Product Image not Found');
        return redirect('/all-product');
    }



    public function delete_product($product_id){
        //echo $category_id;

        $row =  DB::table('tbl_products')
            ->where('product_id', $product_id)
            ->first();
        //echo $row->product_image;
        //return $row;

        $image_name = $row->product_image;
        /*if (file_exists($image_name)){
            echo "true";
        }
        else {
            echo  "F";
        }*/


        if (!empty($image_name)){
            if (file_exists($image_name)){
                File::delete($image_name);
                DB::table('tbl_products')
                    ->where('product_id', $product_id)->delete();

                Session::put('msg','Product Item deleted Successfully');
                return Redirect::to('/all-product');
            }
            else
            {
                Session::put('msg','Product Item not deleted !! (Image not found in the Local directory)');
                return Redirect::to('/all-product');
            }
        }else
        {
            Session::put('msg','Product Item not deleted !! (Image not found)');
            return Redirect::to('/all-product');
        }/**/


    }
}
