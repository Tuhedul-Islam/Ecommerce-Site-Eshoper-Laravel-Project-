<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class ManufactureController extends Controller
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
        //echo "okk man";

        return view('admin.add-manufacture');
    }


    public function save_manufacture(Request $request){
        //$data = $request->all();
        //return $data;

        $data = array();
        $data['manufacture_name'] = $request->manufacture_name;
        $data['manufacture_description'] = $request->manufacture_description;
        $data['publication_status'] = $request->publication_status;
        //return $data;

        if ($data['publication_status']==null){
            $data['publication_status'] = 0;
        }

        DB::table('manufacture')->insert($data);
        //DB::insert("insert into tbl_category ('category_name','category_description', 'publication_status') values (?,?)",[]);
        //or use eloquent ORM with model
        Session::put('message','Manufacture item Successfully added to database');

        return redirect('/add-manufacture');
    }


    public function all_manufacture(){
        /*
        //Can also use [alternative]
        $all_manufacture = DB::table('manufacture')->get();
        $manage_manufacture = view('admin.all-manufacture')
                                ->with('all_manufacture',$all_manufacture); //to retrieve use [all_cat]
        return view('admin_layout')
                ->with('admin.all-manufacture', $manage_manufacture);
        */

        $all_manufacture = DB::table('manufacture')->orderby('manufacture_id','desc')->get();
        return view('admin.all-manufacture', compact('all_manufacture'));
    }



    // We may use different method for active or inactive the publication status
    public function active_inactive_manufacture($manufacture_id, $status){
        //echo $category_id;

        $status = $status ==1 ? 0:1;
        //echo $status;

        DB::table('manufacture')
            ->where('manufacture_id', $manufacture_id)
            ->update(['publication_status' => $status]);
        //can use model [findORFail($category_id)]

        Session::put('msg', 'Category Publication Status successfully updated');
        return Redirect::to('/all-manufacture');

    }



    public function edit_manufacture($manufacture_id){
        //echo $category_id;
        $manufacture_info = DB::table('manufacture')
            ->where('manufacture_id', $manufacture_id)->first();

        return view('admin.edit-manufacture', compact('manufacture_info'));
    }



    public function update_manufacture(Request $request , $manufacture_id){
        //echo $category_id;

        //alternative
        //$value = $request->all();

        $value = array();
        $value['manufacture_name'] = $request->manufacture_name;
        $value['manufacture_description'] = $request->manufacture_description;

        DB::table('manufacture')
            ->where('manufacture_id', $manufacture_id)
            ->update($value);
        Session::put('msg', 'Manufacture updated successfully');

        return redirect('/all-manufacture');
    }



    public function delete_manufacture($manufacture_id){
        //echo $category_id;

        DB::table('manufacture')
            ->where('manufacture_id', $manufacture_id)
            ->delete();

        Session::put('msg','Manufacture Item deleted Successfully');
        return Redirect::to('/all-manufacture');
    }
}
