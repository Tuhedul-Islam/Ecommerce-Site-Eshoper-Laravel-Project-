<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Session;

class SuperAdminController extends Controller
{

    public function __construct()
    {
        $admin_id = Session::get('admin_id');
        if ($admin_id){
            return view('admin.dashbord');
        }else{
            return  redirect('/admin')->send();
        }
    }/**/


    public function index(){
        //$this->AdminAuthCheck();
        return view('admin.dashbord');
    }



    public function logout(){
        //Session::put('admin_name', null);
        //Session::put('admin_id', null);
        Session::flush();

        return redirect('/admin');
    }


    /*public function AdminAuthCheck(){
        $admin_id = Session::get('admin_id');
        if ($admin_id){
            return;
        }else{
            return  redirect('/admin')->send();
        }
    }*/
}
