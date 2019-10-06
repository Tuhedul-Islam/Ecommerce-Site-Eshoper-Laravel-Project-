<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class CategoryController extends Controller
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

        return view('admin.add-category');
    }



    public function all_category(){
        /*
        //Can also use [alternative]
        $all_category = DB::table('tbl_category')->get();
        $manage_category = view('admin.all-category')
                                ->with('all_cat',$all_category); //to retrieve use [all_cat]
        return view('admin_layout')
                ->with('admin.all-category', $manage_category);
        */

        $all_category = DB::table('tbl_category')->orderby('category_id','desc')->get();
        return view('admin.all-category', compact('all_category'));
    }




    public function save_category(Request $request){
        //$data = $request->all();
        //return $data;

        $data = array();
        $data['category_name'] = $request->category_name;
        $data['category_description'] = $request->category_description;
        $data['publication_status'] = $request->publication_status;
        //return $data;

        if ($data['publication_status']==null){
            $data['publication_status'] = 0;
        }

        DB::table('tbl_category')->insert($data);
        //DB::insert("insert into tbl_category ('category_name','category_description', 'publication_status') values (?,?)",[]);
        //or use eloquent ORM with model
        Session::put('message','Category item Successfully added to database');

        return redirect('/add-category');
    }



    // We may use different method for active or inactive the publication status
    public function active_inactive_category($category_id, $status){
        //echo $category_id;

        $status = $status ==1 ? 0:1;
        //echo $status;

        DB::table('tbl_category')
            ->where('category_id', $category_id)
            ->update(['publication_status' => $status]);
        //can use model [findORFail($category_id)]

        Session::put('msg', 'Category Publication Status successfully updated');
        return Redirect::to('/all-category');

    }


    public function edit_category($category_id){
        //echo $category_id;
        $category_info = DB::table('tbl_category')
            ->where('category_id', $category_id)->first();

        return view('admin.edit-category', compact('category_info'));
    }


    public function update_category(Request $request , $category_id){
        //echo $category_id;

        //alternative
        $value = array();
        $value['category_name'] = $request->category_name;
        $value['category_description'] = $request->category_description;


        //$value = $request->all();

        DB::table('tbl_category')
            ->where('category_id', $category_id)
            ->update($value);
        Session::put('msg', 'Category updated successfully');

        return redirect('/all-category');
    }



    public function delete_category($category_id){
        //echo $category_id;

        DB::table('tbl_category')
            ->where('category_id', $category_id)
            ->delete();

        Session::put('msg','Category Item deleted Successfully');
        return Redirect::to('/all-category');
    }
}
