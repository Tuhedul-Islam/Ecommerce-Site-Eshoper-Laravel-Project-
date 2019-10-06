<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function admin_login_page(){
        return view('admin_login');
    }



    public function index(){

        $all_product = DB::table('tbl_products')->orderby('product_id','desc')
                        ->join('tbl_category', 'tbl_products.category_id', '=', 'tbl_category.category_id')
                        ->join('manufacture', 'tbl_products.manufacture_id', '=', 'manufacture.manufacture_id')
                        ->select('tbl_products.*', 'tbl_category.category_name', 'manufacture.manufacture_name')
                        ->where('tbl_products.publication_status', 1)
                        ->get();

        $paginate = DB::table('tbl_products')->paginate(2);

        return view('pages.home_content', compact('all_product', 'paginate'));
    }



    public function show_product_by_category($category_id){
        $product_by_category = DB::table('tbl_products')->orderby('product_id','desc')
                                ->join('tbl_category', 'tbl_products.category_id', '=', 'tbl_category.category_id')
                                ->join('manufacture', 'tbl_products.manufacture_id', '=', 'manufacture.manufacture_id')
                                ->select('tbl_products.*', 'tbl_category.category_name' , 'manufacture.manufacture_name')
                                ->where('tbl_category.category_id', $category_id)
                                ->where('tbl_products.publication_status', 1)
                                ->get();

        $paginate = DB::table('tbl_products')->paginate(2);

        return view('pages.product-by-category', compact('product_by_category', 'paginate'));
    }



    public function show_product_by_manufacture($manufacture_id){
        $product_by_manufacture = DB::table('tbl_products')->orderby('product_id','desc')
                                ->join('tbl_category', 'tbl_products.category_id', '=', 'tbl_category.category_id')
                                ->join('manufacture', 'tbl_products.manufacture_id', '=', 'manufacture.manufacture_id')
                                ->select('tbl_products.*', 'tbl_category.category_name' , 'manufacture.manufacture_name')
                                ->where('manufacture.manufacture_id', $manufacture_id)
                                ->where('tbl_products.publication_status', 1)
                                ->get();

        $paginate = DB::table('tbl_products')->paginate(2);

        return view('pages.product-by-manufacture', compact('product_by_manufacture', 'paginate'));
    }



    public function product_details_by_id($product_id){
        $single_product_details = DB::table('tbl_products')->orderby('product_id','desc')
            ->join('tbl_category', 'tbl_products.category_id', '=', 'tbl_category.category_id')
            ->join('manufacture', 'tbl_products.manufacture_id', '=', 'manufacture.manufacture_id')
            ->select('tbl_products.*', 'tbl_category.category_name' , 'manufacture.manufacture_name')
            ->where('tbl_products.product_id', $product_id)
            ->where('tbl_products.publication_status', 1)
            ->first();

        $paginate = DB::table('tbl_products')->paginate(2);

        return view('pages.single-product-details', compact('single_product_details', 'paginate'));
    }



    public function contact(){
        return view('pages.contact');
    }
}
