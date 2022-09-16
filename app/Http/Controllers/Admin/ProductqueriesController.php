<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProductQuery;
use App\Models\Product;
class ProductqueriesController extends Controller
{
    public function index(){       
        $data = ProductQuery::orderBy('id','DESC')->get();
        return view('admin.product_queries.index')->with('data',$data);
    }

    public function show($id){
    	$data = ProductQuery::where('id',$id)->first();    	 
        return view('admin.product_queries.show')->with('data',$data);
    }

    public function destroy($id){
    	 ProductQuery::destroy($id);       
        return redirect()->route('product-queries.index')->with('success', 'Query has been deleted successfully!.');
    } 




    
}
