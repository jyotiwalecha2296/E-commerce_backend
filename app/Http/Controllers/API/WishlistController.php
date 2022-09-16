<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\Wishlist;
use App\Models\Product;
use Auth;
class WishlistController extends Controller{


    //ADD AND REMOVE WISHLIST
	public function wishlist(Request $request){		 
        // authentication check
	    if(Auth::check()){

		     //validator check
			  $validator = Validator::make($request->all(), [
		        'item_code' => 'required'        
		      ]);
		      if ($validator->fails()) {
		       return response()->json(['error' => $validator->errors()], 403);
		      }
             
               $user_id=Auth::user()->id;
              
               $check_pd_in_wish=Wishlist::where('user_id',$user_id)->where('item_code',$request->item_code)->count();
               
               //already added
               if($check_pd_in_wish > 0){
                    $remove=Wishlist::where('user_id',$user_id)->where('item_code',$request->item_code)->delete();
                    return response()->json(["success" => true, "message" => 'Item removed from your wishlist successfully'], 200);
               }else{
	               	$savedata = new Wishlist();
					$savedata->item_code = $request->item_code; 
					$savedata->user_id = $user_id; 					
					$savedata->save();
					return response()->json(["success" => true, "message" => 'Item added to your wishlist successfully'], 200);
               }

		}else{
			return response()->json(['success' => false, 'message' => 'Authentication Failed'], 401)->header('status', 401);
		}
	}

    //View Wishlist
	public function viewWishlist(Request $request){		 
        // authentication check
	    if(Auth::check()){		      
             
               $user_id=Auth::user()->id;
              
               $check_wishlist=Wishlist::where('user_id',$user_id)->count();
               
               //contains product
               if($check_wishlist > 0){
               	    $wishlist_products=Wishlist::where('user_id',$user_id)->get();
               	    $productdata=array();

               	    foreach($wishlist_products as $product){

                     $productdata[]  = Product::where('item_code',$product->item_code)->where('status','1')->first(['id','name','item_code','slug','Price','color','type','stock','featured_image']);
               	    }
               	     
                    return response()->json(["success" => true, "data" => $productdata], 200);
               }else{
	               	 
					return response()->json(["success" => false, "message" => 'Empty wishlist'], 202);
               }

		}else{
			return response()->json(['success' => false, 'message' => 'Authentication Failed'], 401)->header('status', 401);
		}
	}

    //sync wishlist
	public function syncWishlist(Request $request){		

        // authentication check
	    if(Auth::check()){
              //validator check
			  $validator = Validator::make($request->all(), [
		        'item_code' => 'required'        
		      ]);
		      if ($validator->fails()) {
		       return response()->json(['error' => $validator->errors()], 403);
		      }
             
               $user_id=Auth::user()->id;
              
               $check_pd_in_wish=Wishlist::where('user_id',$user_id)->where('item_code',$request->item_code)->count();
               
               //already added
               if($check_pd_in_wish > 0){
                    $remove=Wishlist::where('user_id',$user_id)->where('item_code',$request->item_code)->delete();
                    return response()->json(["success" => true, "message" => 'Item removed from your wishlist successfully'], 200);
               }else{
	               	$savedata = new Wishlist();
					$savedata->item_code = $request->item_code; 
					$savedata->user_id = $user_id; 					
					$savedata->save();
					return response()->json(["success" => true, "message" => 'Item added to your wishlist successfully'], 200);
               }

		}else{
			return response()->json(['success' => false, 'message' => 'Authentication Failed'], 401)->header('status', 401);
		}
	}
}