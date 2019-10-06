<?php

namespace App\Http\Controllers;

use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;


class CheckoutController extends Controller
{
    public function check_login(){
        return view('pages.customer-login');
    }



    public function customer_registration(Request $request){
        $data = array();
        $data['customer_name'] = $request->customer_name;
        $data['customer_email'] = $request->customer_email;
        $data['customer_password'] = $request->customer_password;
        $data['mobile_number'] = $request->mobile_number;

        $customer_id = DB::table('tbl_customer')
                        ->insertGetId($data);

        Session::put('customer_id', $customer_id);
        Session::put('customer_name', $request->customer_name);

        return redirect('/checkout');
    }



    public function checkout(){
        $customer_id = Session::get('customer_id');
        if (!empty($customer_id)){
            return view('pages.checkout');
        }else{
            return redirect('/customer-login');
        }

    }



    public function save_shipping_details(Request $request){
        //$data = $request->all();

        $data = array();
        $data['shipping_email'] = $request->shipping_email;
        $data['shipping_first_name'] = $request->shipping_first_name;
        $data['shipping_last_name'] = $request->shipping_last_name;
        $data['shipping_address'] = $request->shipping_address;
        $data['shipping_mobile_number'] = $request->shipping_mobile_number;
        $data['shipping_city'] = $request->shipping_city;
        //print_r($data) ;

        $shipping_id = DB::table('tbl_shipping')
                        ->insertGetId($data);
        Session::put('shipping_id', $shipping_id);

        return redirect('/payment');
    }


    public function customer_logout(){
        Session::flush();
        return redirect('/');
    }


    public function registered_customer_login(Request $request){
        $customer_email = $request->customer_email;
        $customer_password = $request->customer_password;

        $result = DB::table('tbl_customer')
                    ->where('customer_email', $customer_email)
                    ->where('customer_password', $customer_password)
                    ->first();

        if ($result){
            Session::put('customer_id', $result->customer_id);
            return redirect('/show-cart');
        }else{
            return redirect('/customer-login');
        }
    }



    public function payment(){
        $customer_id = Session::get('customer_id');
        if (!empty($customer_id)){
            return view('pages.payment');
        }else{
            return redirect('/customer-login');
        }

    }


    public function order_place(Request $request){
        $payment_gateway = $request->payment_method;

        $payment_data = array();
        $payment_data['payment_method'] = $payment_gateway;
        $payment_data['payment_status'] = 'pending';
        $payment_id = DB::table('tbl_payment')
                        ->insertGetId($payment_data);

        $order_data = array();
        $order_data['customer_id'] = Session::get('customer_id');
        $order_data['shipping_id'] = Session::get('shipping_id');
        $order_data['payment_id']  = $payment_id;
        $order_data['order_total'] = Cart::total(); //from cart
        $order_data['order_status']= 'pending';
        $order_id = DB::table('tbl_order')
                    ->insertGetId($order_data);

        $contents = Cart::content();
        /*echo '<pre>';
        print_r($contents);
        echo '</pre>';*/

        $order_details_data = array();
        foreach ($contents as $content){
            $order_details_data['order_id'] = $order_id;
            $order_details_data['product_id'] = $content->id;
            $order_details_data['product_name'] = $content->name;
            $order_details_data['product_price'] = $content->price;
            $order_details_data['product_sales_quantity'] = $content->qty;

            DB::table('tbl_order_details')
                ->insert($order_details_data);
        }

        if ($payment_gateway=='handcash'){
            Cart::destroy();
            return view('pages.handcash');
        }elseif ($payment_gateway=='paypal'){
            echo "Order Successfully done by paypal Payment Gateway";
        }elseif ($payment_gateway=='bkash'){
            echo "Order Successfully done by bkash Payment Gateway";
        }elseif ($payment_gateway=='mastercard'){
            echo "Order Successfully done by mastercard Payment Gateway";
        }else{
            echo "Payment Gateway Not Selected";
        }

    }
}
