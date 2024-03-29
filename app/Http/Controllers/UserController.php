<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Products;

class UserController extends Controller
{
    public function index(){
           //categories
        $categories=DB::table('categories')
        ->select('CategoryName')
        ->get();

        //products
        $products=DB::table('products')
        ->select('product_cover','ProductName')
        ->get();


        return view('user.index')->with(['categories'=>$categories,'products'=>$products]);
    }
}
