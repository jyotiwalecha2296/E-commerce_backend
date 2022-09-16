<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\UserCart;
use App\Models\Product;
use App\Models\Address;
use Auth;
class CartController extends Controller{


    //ADD ITEM TO  CART
	public function cart(Request $request){		 
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
              
               $check_pd_in_cart=UserCart::where('user_id',$user_id)->where('item_code',$request->item_code)->count();
               
               //already added
               if($check_pd_in_cart > 0){
               	$check_item_cart=UserCart::where('user_id',$user_id)->where('item_code',$request->item_code)->first();

               	$quantity=$check_item_cart->quantity+1;
                    $updatedata=UserCart::find($check_item_cart->id);
					$updatedata->item_code = $request->item_code; 
					$updatedata->quantity =$quantity; 
					$updatedata->user_id = $user_id; 					
					$updatedata->save();
                    return response()->json(["success" => true, "message" => 'Cart updated  successfully'], 200);
               }else{
	               	$savedata = new UserCart();
					$savedata->item_code = $request->item_code; 
					$savedata->user_id = $user_id; 	
					$savedata->quantity =1;				
					$savedata->save();
					return response()->json(["success" => true, "message" => 'Item added to your cart successfully'], 200);
               }

		}else{
			return response()->json(['success' => false, 'message' => 'Authentication Failed'], 401)->header('status', 401);
		}
	}

    //View cart
	public function viewCart(Request $request){		 
        // authentication check
	    if(Auth::check()){		      
             
               $user_id=Auth::user()->id;
              
               $check_cartlist=UserCart::where('user_id',$user_id)->count();
               
               //contains product
               if($check_cartlist > 0){
               	    $cartlist_products=UserCart::where('user_id',$user_id)->get();
               	    $productdata=array();
                    $total_price=array();
               	    foreach($cartlist_products as $product){

                     $data= Product::where('item_code',$product->item_code)->where('status','1')->first();
               	     $total_price[]=$data->Price*$product->quantity;             	      
               	     $productdata[]=array("id"=>$data->id,
               	     	                  "name"=>$data->name,
               	     	                  "item_code"=>$data->item_code,
               	     	                  "slug"=>$data->slug,
               	     	                  "Price"=>$data->Price,
               	     	                  "color"=>$data->color,
               	     	                  "type"=>$data->type,
               	     	                  "stock"=>$data->stock,
               	     	                  "featured_image"=>$data->featured_image,
               	     	                  "quantity"=>$product->quantity,
               	                         );
               	    }
               	$Adress = Address::Where('user_id',$user_id)->where('is_default',1)->with('getShipping')->first();
               	$address['address']['id']= $Adress->id;
               	$address['address']['user_id']= $Adress->user_id;
               	$address['address']['address']= $Adress->address;
               	$address['address']['city']= $Adress->city;
               	$address['address']['pincode']= $Adress->pincode;
               	$address['address']['country']= $Adress->country;
               	$address['address']['country_code']= $Adress->country_code;
               	$address['address']['is_default']= $Adress->is_default;
               	$address['address']['shipping_charges']= $Adress->getShipping['shipping_charges'];
                    $cart_total=array_sum($total_price);               	     
                    return response()->json(["success" => true ,
                    	                     "user_id"=>Auth::user()->id,
                    	                     "name"=>Auth::user()->name,
                    	                     "email"=>Auth::user()->email,
                    	                     "contact_no"=>Auth::user()->contact_no,                  	
                    	                     "cart_total"=>$cart_total,
                    	                     "products_data" => $productdata,
                    	                	  "Address" => $address], 200);
               }else{
	               	 
					return response()->json(["success" => false, "message" => 'Your cart is empty'], 202);
               }

		}else{
			return response()->json(['success' => false, 'message' => 'Authentication Failed'], 401)->header('status', 401);
		}
	}

   //update cart
	public function updateCart(Request $request){		 
        // authentication check
	    if(Auth::check()){

		     //validator check
			  $validator = Validator::make($request->all(), [
		        'item_code' => 'required',
		        'quantity' => 'required'        
		      ]);
		      if ($validator->fails()) {
		       return response()->json(['error' => $validator->errors()], 403);
		      }
             
               $user_id=Auth::user()->id;              
               $check_pd_in_cart=UserCart::where('user_id',$user_id)->where('item_code',$request->item_code)->count();
               
               //already added
               if($check_pd_in_cart > 0){
                    if($request->quantity > 0){
                    	$check_item_cart=UserCart::where('user_id',$user_id)->where('item_code',$request->item_code)->first();
	                    $updatedata=UserCart::find($check_item_cart->id);
						$updatedata->item_code = $request->item_code; 
						$updatedata->quantity =$request->quantity; 
						$updatedata->user_id = $user_id; 					
						$updatedata->save();
	                    return response()->json(["success" => true, "message" => 'Cart updated  successfully'], 200);

                    }else{

                    	$delete_item=UserCart::where('user_id',$user_id)->where('item_code',$request->item_code)->delete();
                    	return response()->json(["success" => false, "message" => 'Item removed from cart successfully'], 202);
                    }
               	    
               }else{	            
					return response()->json(["success" => false, "message" => 'Item not found in your cart'], 202);
               }

		}else{
			return response()->json(['success' => false, 'message' => 'Authentication Failed'], 401)->header('status', 401);
		}
	}
    
    //delete item from cart
	public function deleteCart(Request $request){		 
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
               $check_pd_in_cart=UserCart::where('user_id',$user_id)->where('item_code',$request->item_code)->count();
                if($check_pd_in_cart > 0){           
                   	$delete_item=UserCart::where('user_id',$user_id)->where('item_code',$request->item_code)->delete();
                    return response()->json(["success" => false, "message" => 'Item removed from cart successfully'], 202);                   
                }else{	            
					return response()->json(["success" => false, "message" => 'Item not found in your cart'], 202);
                }

		}else{
			return response()->json(['success' => false, 'message' => 'Authentication Failed'], 401)->header('status', 401);
		}
	}
}