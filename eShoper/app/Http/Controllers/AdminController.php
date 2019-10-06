<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

session_start();

class AdminController extends Controller
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




    /*public function show_dashbord(){
        return view('admin.dashbord');
    }*/

    public function dashbord(Request $request){
        $admin_email = $request->admin_email;
        $admin_password = md5($request->admin_password);

        $result = DB::table('tbl_admin')
                    ->where('admin_email', $admin_email)
                    ->where('admin_password', $admin_password)
                    ->first();

       /* echo '<pre>';
        print_r($result);
        echo '</pre>';
        return count($result);
       */

        if (count($result)>0){
            Session::put('admin_name', $result->admin_name); // or session() global message can be used.
            Session::put('admin_id', $result->admin_id);
            return redirect("/dashbord");
            //return Redirect::to('/dashbord');//also use
        }else{
            Session::put('message', 'Email or Password Invalid');
            return redirect('/admin');
        }

    }


    public function admin_profile(){
        $admin_info = DB::table('tbl_admin')
            ->first();
        //print_r($admin_info);
        //echo md5($admin_info->admin_password);

        return view('admin.admin-profile', compact('admin_info'));
    }


    public function update_admin_profile(Request $request, $admin_id){
        $row = array();

        $row['admin_email']= $request->admin_email;
        $row['admin_password']= md5($request->admin_password);
        $row['admin_name']= $request->admin_name;
        $row['admin_phone']= $request->admin_phone;

        DB::table('tbl_admin')
                ->where('admin_id', $admin_id)
                ->update($row);

        Session::put('msg', 'Admin Info Updated Successfully');
        return redirect('/admin-profile');
    }
}
