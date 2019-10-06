<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class ManageOrderController extends Controller
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



    public function manage_order(){
        $all_order_info = DB::table('tbl_order')
                        ->join('tbl_customer', 'tbl_order.customer_id', '=', 'tbl_customer.customer_id')
                        ->select('tbl_order.*', 'tbl_customer.customer_name')
                        ->get();

        /*echo '<pre>';
        print_r($all_order_info);
        echo '</pre>';
        */
        return view('admin.manage-order', compact('all_order_info'));
    }



    public function view_order_details($order_id){
        $all_info = DB::table('tbl_order')
            ->join('tbl_customer', 'tbl_order.customer_id', '=', 'tbl_customer.customer_id')
            ->join('tbl_order_details', 'tbl_order.order_id', '=', 'tbl_order_details.order_id')
            ->join('tbl_shipping', 'tbl_order.shipping_id', '=', 'tbl_shipping.shipping_id')
            ->join('tbl_payment', 'tbl_order.payment_id', '=', 'tbl_payment.payment_id')
            ->select('tbl_order.*', 'tbl_customer.*', 'tbl_shipping.*', 'tbl_order_details.*', 'tbl_payment.payment_method')
            ->where('tbl_order.order_id',$order_id)
            ->get();

        /*echo '<pre>';
        print_r($all_info);
        echo '</pre>';*/

        return view('admin.view-order-details', compact('all_info'));
    }



    public function delete_order($order_id){
        //echo $order_id;

        $order_details = DB::table('tbl_order_details')
            ->where('order_id', $order_id)
            ->delete();

        $payment = DB::table('tbl_order')
            ->join('tbl_payment', 'tbl_order.payment_id', '=', 'tbl_payment.payment_id')
            ->where('tbl_order.order_id', $order_id)
            ->select('tbl_payment.*')
            ->delete();

        $order = DB::table('tbl_order')
            ->where('tbl_order.order_id', $order_id)
            ->delete();

        /*echo "<pre>";
        print_r($order_details);
        echo "</pre>";
        echo '<br>';

        echo "<pre>";
        print_r($payment);
        echo "</pre>";
        echo '<br>';

        echo "<pre>";
        print_r($order);
        echo "</pre>";
        echo '<br>';*/
        Session::put('msg', 'Order and Order_details deleted successfully');
        return redirect('/manage-order');
    }



    public function active_inactive_order($order_id){
        $order = DB::table('tbl_order')
            ->where('order_id', $order_id)
            ->first();

        if ($order->order_status == 'pending'){
            /**/DB::table('tbl_order')
                ->where('order_id', $order_id)
                ->update(['order_status' => 'success']);
        }else{
            /**/DB::table('tbl_order')
                ->where('order_id', $order_id)
                ->update(['order_status' => 'pending']);
        }

        Session::put('msg', 'Order Status successfully updated');
        return Redirect::to('/manage-order');
    }
}





