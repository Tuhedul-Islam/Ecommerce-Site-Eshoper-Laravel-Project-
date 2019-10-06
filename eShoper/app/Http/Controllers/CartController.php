<?php

namespace App\Http\Controllers;


use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{

    public function add_to_cart(Request $request){
        $product_id = $request->product_id;
        $quantity = $request->qty;

        $product_info = DB::table('tbl_products')
                        ->where('product_id', $product_id)
                        ->where('publication_status', 1)
                        ->first();

        /*echo "<pre>";
        print_r($product_info);
        echo "</pre>";*/

        $data['qty'] = $quantity;
        $data['id'] = $product_info->product_id;
        $data['name'] = $product_info->product_name;
        $data['price'] = $product_info->product_price;
        $data['options']['image'] = $product_info->product_image;

        Cart::add($data);

        return redirect('/show-cart');

    }



    public function show_cart(){
        $all_published_category = DB::table('tbl_category')
                                    ->where('publication_status', 1)
                                    ->get();

        return view('pages.add-to-cart', compact('all_published_category'));
    }



    public function delete_cart_item($rowId){
        Cart::update($rowId, 0);
        return redirect('/show-cart');
    }



    public function update_cart_item(Request $request){
         $qty = $request->qty;
         $rowId = $request->rowId;

        Cart::update($rowId, $qty);
        return redirect('/show-cart');
    }
}
