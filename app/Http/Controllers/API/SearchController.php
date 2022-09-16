<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;

class SearchController extends Controller
{

    //to search the product by name or color

    public function searchProduct(Request $request)
    {
        $products =[];
        $data =[];
        $watches =[];
        $strap =[];
        if(isset($request->search))
        {
            $products = Product::where('parent_id','!=',0)->where('name', 'LIKE', '%'. $request->search. '%')->orwhere('color', '%'. $request->search. '%')->with('getCollection')->limit(8)->latest()->get();

            $watches = Product::where('parent_id','!=',0)->where('name', 'LIKE', '%'. $request->search. '%')->whereIn('product_line_type',['s-line','t-line'])->orwhere('color', 'LIKE', '%'. $request->search. '%')->whereIn('product_line_type',['s-line','t-line'])->count();

            $strap = Product::where('parent_id','!=',0)->where('name', 'LIKE', '%'. $request->search. '%')->where('product_line_type','strap')->orwhere('color', 'LIKE', '%'. $request->search. '%')->where('product_line_type','strap')->count();
        }else
        {
            $products = Product::with('getCollection')->get();
            $watches = Product::whereIn('product_line_type',['s-line','t-line'])->count();
            $strap = Product::whereIn('product_line_type',['strap'])->count();
        }
        if($products)
        {   
            foreach($products as $k=>$product)
            {
                $data[$k]['id'] = $product->id;
                $data[$k]['name'] = $product->name;
                if($product->getCollection)
                {
                    $data[$k]['slug'] = $product->getCollection['slug'];
                }
                $data[$k]['type'] = $product->type;
                $data[$k]['product_line_type'] = $product->product_line_type;
                $data[$k]['collection_id'] = $product->collection_id;
                $data[$k]['parent_id'] = $product->parent_id;
                $data[$k]['is_steel'] = $product->is_steel;
                $data[$k]['is_rubber'] = $product->is_rubber;
                $data[$k]['Price'] = $product->Price;
                $data[$k]['stock'] = $product->stock;
                $data[$k]['item_code'] = $product->item_code;
                $data[$k]['featured_product_status'] = $product->featured_product_status;
                $data[$k]['featured_product_position'] = $product->featured_product_position;
                $data[$k]['color'] = $product->color;
                $data[$k]['description'] = $product->description;
                $data[$k]['strap_image'] = $product->strap_image;
                $data[$k]['gallery_image'] = $product->gallery_image;
                $data[$k]['product_type'] = $product->product_type;
                $data[$k]['featured_image'] = $product->featured_image;
                $data[$k]['night_view_image'] = $product->night_view_image;
                $data[$k]['status'] = $product->status;
            }
        }
        return response()->json(["success" => true, "message" => 'Product List.' ,"data"=> $data ,"watches"=>$watches,"strap"=>$strap], 200);
    }

    // Search product by name or color and product type
    
    public function searchProductType(Request $request)
    {
        $products =[];
        if(isset($request->search) && isset($request->type))
        {
            $products = Product::where('name', 'LIKE', '%'. $request->search. '%')->where('product_line_type',$request->type)->orwhere('color', '%'. $request->search. '%')->where('product_line_type',$request->type)->get();
        }else
        {
            $products = Product::get();
            $watches = Product::whereIn('product_line_type',['s-line','t-line'])->count();
            $strap = Product::whereIn('product_line_type',['strap'])->count();
        }
        return response()->json(["success" => true, "message" => 'Product List.' ,"data"=> $products], 200);
    }
}
