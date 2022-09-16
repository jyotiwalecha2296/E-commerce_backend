<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pages;
use App\Models\Setting; 
use App\Models\Collection; 
use App\Models\Inquiries;
use App\Models\Product;
use App\Models\ProductMeta;
use App\Models\ProductQuery;
use App\Models\Homeslider;
use App\Models\SubscribedUser;
use App\Models\Wishlist;
use Validator;
use Newsletter;

use Illuminate\Support\Facades\Auth; 
use Mail;

class ProductController extends Controller
{

  // to get the latest 8 product
    public function recommendedProduct()
    {
        $products =[];
        $products= Product::Limit(8)->latest()->get();
     
        return response()->json(["success" => true, "message" => 'Product List.' ,"data"=> $products], 200);
    }

   // to get the detail of particular product

public function product_detail(Request $request){
  $validator = Validator::make($request->all(), [
    'item_code' => 'required'                    
  ]);
  if ($validator->fails()) {
   return response()->json(['error' => $validator->errors()], 403);
  }
   $product_existence=Product::where('item_code',$request->item_code)->first();
       if($product_existence == null){
         return response()->json(['success' => false, 'message' => 'Product does not exist'], 202)->header('status', 202);
       } 
       $request_product_id=Product::where('item_code',$request->item_code)->value('id');
       $check_product_prarent=Product::where('id',$request_product_id)->value('parent_id');
       if($check_product_prarent == "0"){        
         $check_product=Product::where('id',$request_product_id)->first();
       }else{        	 
         $check_product=Product::where('id',$check_product_prarent)->first();         
       }        
        if($check_product != null){
                         if($check_product->status == "1"){
                              $productdata=  Product::join('product_metas', 'products.id', '=', 'product_metas.product_id')->where('products.id',$check_product->id)->first(['products.*', 'product_metas.*']); 
                              $collection_ids=explode(',',$productdata->collection_id); 

                                  $collection_array=array();                 
                                  if(count($collection_ids) >0){
                                    foreach($collection_ids as $key=>$value){
                                      $collection_array[]=Collection::where('id',$value)->first(['id','name']);
                                    }
                                  }

                                  $gallery_array=array();     
                                  $gallery_images=json_decode($productdata->gallery_images, true);
                                  if(count($gallery_images) > 0){
                                    $gallery_array[]=array("original"=>env('APP_URL').$productdata->featured_image,"thumbnail"=>env('APP_URL').$productdata->featured_image);
                                    foreach($gallery_images as $key=>$gvalue){
                                      $gallery_array[]=array("original"=>$gvalue,"thumbnail"=>$gvalue);
                                    }
                                  }
                                  $parent_product=Product::where('id',$check_product->id)->first();
                                  if($parent_product != null){
                                    $main_product_name=$parent_product->name;
                                  }else{
                                    $main_product_name=null;
                                  }

                                  $main_price=null;
                                  $main_type=null;
                                  $main_color=null;
                                  $other_options=array();

                                  $other_options=Product::where('parent_id',$check_product->id)->where('id','!=',$check_product->id)->get();

                                    if($other_options->count() > 0){
                                            $other_options_array=array();
                                            foreach($other_options as $key=>$other_option_detail){          
                                                $option_gallery_array=array(); 
                                                $option_gallery_array_all=json_decode($other_option_detail->gallery_image, true);
                                                if(count($option_gallery_array_all) > 0){
                                                  $option_gallery_array[]=array("original"=>env('APP_URL').$other_option_detail->featured_image,"thumbnail"=>env('APP_URL').$other_option_detail->featured_image);
                                                  foreach($option_gallery_array_all as $key=>$ogvalue){
                                                   $option_gallery_array[]=array("original"=>$ogvalue,"thumbnail"=>$ogvalue);
                                                 }
                                                } 
                                             
                                               if($check_product_prarent !="0"){
                                                 if($other_option_detail->id==$request_product_id){
                                                    $active_variant_status=1;
                                                    $main_price=$other_option_detail->Price;
                                                    $main_type=$other_option_detail->type;
                                                    $main_color=$other_option_detail->color;
                                                  }else{
                                                    $active_variant_status=0;
                                                  }

                                                }else{                     
                                                   if($key==0){
                                                      $active_variant_status=1;
                                                      $main_price=$other_option_detail->Price;
                                                      $main_type=$other_option_detail->type;
                                                      $main_color=$other_option_detail->color;
                                                    }else{
                                                    $active_variant_status=0;
                                                    }
                                                }
                                        
                                                $option_name=array();
                                                $option_name_first=null;
                                                $option_name_second=null;
                                                $option_name_third=null;
                                                $option_name_a =explode(' ', $other_option_detail->name,3);
                                                foreach($option_name_a as $key=>$option_name_sp){
                                                 if($key==0){
                                                  $option_name_first=$option_name_sp;
                                                }elseif($key==1){
                                                  $option_name_second=$option_name_sp;
                                                }elseif($key==2){
                                                  $option_name_third=$option_name_sp;
                                                }
                                                }

                                                $other_options_array[]=array('id'=>$other_option_detail->id,
                                                  'item_code'=>$other_option_detail->item_code,
                                                  'name'=>$other_option_detail->name,
                                                  "name_first" =>$option_name_first.' ' .$option_name_second,
                                                  "name_second" =>$option_name_third,
                                                  "wishlist_status"=>0,
                                                  'active_status'=>$active_variant_status,
                                                  'slug'=>$other_option_detail->slug,
                                                  'description'=>htmlspecialchars_decode($other_option_detail->description),
                                                  'Price'=>$other_option_detail->Price,
                                                  'type'=>$other_option_detail->type,
                                                  'color'=>$other_option_detail->color,
                                                  'stock'=>$other_option_detail->stock,                                                  
                                                  'strap_image'=>$other_option_detail->strap_image,
                                                  'featured_image'=>$other_option_detail->featured_image,
                                                  'night_view_image'=>$other_option_detail->night_view_image,
                                                  'item_code'=>$other_option_detail->item_code,
                                                  'gallery_images'=>$option_gallery_array);                                                  
                                              }
                                      }else{
                                        $other_options_array=array();
                                      }
                                      $story_title=array();
                                      $story_title_first=null;
                                      $story_title_second=null;
                                      $story_title_third=null;
                                      $story_title_a =explode(' ', $productdata->story_title,3);
                                      foreach($story_title_a as $key=>$story_title_sp){
                                       if($key==0){
                                        $story_title_first=$story_title_sp;
                                        }elseif($key==1){
                                          $story_title_second=$story_title_sp;
                                        }elseif($key==2){
                                          $story_title_third=$story_title_sp;
                                        }
                                      }
                                      $main_name=array();
                                      $main_name_first=null;
                                      $main_name_second=null;
                                      $main_name_third=null;
                                      $main_name_a =explode(' ', $productdata->name,3);
                                      foreach($main_name_a as $key=>$main_name_sp){
                                       if($key==0){
                                        $main_name_first=$main_name_sp;
                                       }elseif($key==1){
                                        $main_name_second=$main_name_sp;
                                       }elseif($key==2){
                                        $main_name_third=$main_name_sp;
                                        }
                                      }
                                      if($productdata->tech_data != null){
                                        $specifications_data=unserialize($productdata->tech_data);
                                        $specifications=array();
                                        foreach($specifications_data as $key=>$svalue){
                                          $specifications[]=array("label"=>$svalue['label'],"value"=>$svalue['value']);
                                        }
                                      }else{
                                        $specifications=array();
                                      }
                                      if($productdata->key_features != null){
                                        $key_features_data=unserialize($productdata->key_features);


                                        $key_features=array();
                                        foreach($key_features_data as $keyf=>$fvalue){
                                          $key_features[]=array("label"=>$fvalue['label'],"value"=>$fvalue['value'],"image"=>env('APP_URL').$fvalue['image']);
                                        }
                                      }else{
                                        $key_features=array();
                                      }

                                      $merchandising_array=array();  
                                      if($productdata->merchandising_images != null){
                                          $merchandising_images=json_decode($productdata->merchandising_images, true);
                                          if(count($merchandising_images) > 0){
                                             foreach($merchandising_images as $key=>$mgvalue){
                                              $merchandising_array[]=array("original"=>$mgvalue,"thumbnail"=>$mgvalue);
                                            }
                                          }
                                      }   
                                      

                                      $data= array("id" =>$productdata->product_id,
                                                  "name" =>$productdata->name,
                                                  "name_first" =>$main_name_first.' ' .$main_name_second,
                                                  "name_second" =>$main_name_third,
                                                  "wishlist_status"=>0,
                                                  "main_product_name" =>$main_product_name,
                                                  "slug" =>$productdata->slug,
                                                  "description" => htmlspecialchars_decode($productdata->description),
                                                  "featured_image" => $productdata->featured_image,
                                                  'night_view_image'=>$productdata->night_view_image,
                                                  "Price"=>$productdata->Price,
                                                  "stock"=>$productdata->stock,
                                                  "item_code"=>$productdata->item_code,
                                                  "type"=>$productdata->type,
                                                  "color"=>$productdata->color,
                                                  "is_steel"=>$productdata->is_steel,
                                                  "is_rubber"=>$productdata->is_rubber,                       
                                                  "story_title"=>$productdata->story_title,
                                                  "story_title_first" =>$story_title_first.' ' .$story_title_second,
                                                  "story_title_second" =>$story_title_third,
                                                  "story_description"=>htmlspecialchars_decode($productdata->story_description),
                                                  "story_image"=>$productdata->story_image,
                                                  "meta_title" =>$productdata->meta_title,
                                                  "meta_keywords" =>$productdata->meta_keywords,
                                                  "meta_description" =>$productdata->meta_description,
                                                  "collections"=>$collection_array,
                                                  "other_options"=> $other_options_array,                           
                                                  "specifications"=>$specifications, 
                                                  "key_features"=>$key_features, 
                                                  "merchandising_images"=>$merchandising_array,
                                                  "gallery_images" =>$gallery_array                                                       
                                                );   
                                      return response()->json(['success' => true,'data'=>$data], 200)->header('status', 200); 
                    }else{
                      return response()->json(['success' => false, 'message' => 'Product is not available'], 202)->header('status', 202);
                    }
        }else{
          return response()->json(['success' => false, 'message' => 'Product does not exist'], 202)->header('status', 202);
        }
}

public function productDetailAuth(Request $request){

  if(Auth::check()){
 $user_id=Auth::user()->id;
  $validator = Validator::make($request->all(), [
    'item_code' => 'required'                    
  ]);
  if ($validator->fails()) {
   return response()->json(['error' => $validator->errors()], 403);
  }
   $product_existence=Product::where('item_code',$request->item_code)->first();
       if($product_existence == null){
         return response()->json(['success' => false, 'message' => 'Product does not exist'], 202)->header('status', 202);
       } 
       $request_product_id=Product::where('item_code',$request->item_code)->value('id');
       $check_product_prarent=Product::where('id',$request_product_id)->value('parent_id');
       if($check_product_prarent == "0"){        
         $check_product=Product::where('id',$request_product_id)->first();
       }else{          
         $check_product=Product::where('id',$check_product_prarent)->first();         
       }        
        if($check_product != null){
                         if($check_product->status == "1"){
                              $productdata=  Product::join('product_metas', 'products.id', '=', 'product_metas.product_id')->where('products.id',$check_product->id)->first(['products.*', 'product_metas.*']); 
                              $collection_ids=explode(',',$productdata->collection_id); 

                                  $collection_array=array();                 
                                  if(count($collection_ids) >0){
                                    foreach($collection_ids as $key=>$value){
                                      $collection_array[]=Collection::where('id',$value)->first(['id','name']);
                                    }
                                  }

                                  $gallery_array=array();     
                                  $gallery_images=json_decode($productdata->gallery_images, true);
                                  if(count($gallery_images) > 0){
                                    $gallery_array[]=array("original"=>env('APP_URL').$productdata->featured_image,"thumbnail"=>env('APP_URL').$productdata->featured_image);
                                    foreach($gallery_images as $key=>$gvalue){
                                      $gallery_array[]=array("original"=>$gvalue,"thumbnail"=>$gvalue);
                                    }
                                  }
                                  $parent_product=Product::where('id',$check_product->id)->first();
                                  if($parent_product != null){
                                    $main_product_name=$parent_product->name;
                                  }else{
                                    $main_product_name=null;
                                  }

                                  $main_price=null;
                                  $main_type=null;
                                  $main_color=null;
                                  $other_options=array();

                                  $other_options=Product::where('parent_id',$check_product->id)->where('id','!=',$check_product->id)->get();

                                    if($other_options->count() > 0){
                                            $other_options_array=array();
                                            foreach($other_options as $key=>$other_option_detail){          
                                                $option_gallery_array=array(); 
                                                $option_gallery_array_all=json_decode($other_option_detail->gallery_image, true);
                                                if(count($option_gallery_array_all) > 0){
                                                  $option_gallery_array[]=array("original"=>env('APP_URL').$other_option_detail->featured_image,"thumbnail"=>env('APP_URL').$other_option_detail->featured_image);
                                                  foreach($option_gallery_array_all as $key=>$ogvalue){
                                                   $option_gallery_array[]=array("original"=>$ogvalue,"thumbnail"=>$ogvalue);
                                                 }
                                                } 
                                             
                                               if($check_product_prarent !="0"){
                                                 if($other_option_detail->id==$request_product_id){
                                                    $active_variant_status=1;
                                                    $main_price=$other_option_detail->Price;
                                                    $main_type=$other_option_detail->type;
                                                    $main_color=$other_option_detail->color;
                                                  }else{
                                                    $active_variant_status=0;
                                                  }

                                                }else{                     
                                                   if($key==0){
                                                      $active_variant_status=1;
                                                      $main_price=$other_option_detail->Price;
                                                      $main_type=$other_option_detail->type;
                                                      $main_color=$other_option_detail->color;
                                                    }else{
                                                    $active_variant_status=0;
                                                    }
                                                }
                                        
                                                $option_name=array();
                                                $option_name_first=null;
                                                $option_name_second=null;
                                                $option_name_third=null;
                                                $option_name_a =explode(' ', $other_option_detail->name,3);
                                                foreach($option_name_a as $key=>$option_name_sp){
                                                 if($key==0){
                                                  $option_name_first=$option_name_sp;
                                                }elseif($key==1){
                                                  $option_name_second=$option_name_sp;
                                                }elseif($key==2){
                                                  $option_name_third=$option_name_sp;
                                                }
                                                }

                                                $option_wishlist_status=Wishlist::where('user_id',$user_id)->where('item_code',$other_option_detail->item_code)->count();

                                                $other_options_array[]=array('id'=>$other_option_detail->id,
                                                  'item_code'=>$other_option_detail->item_code,
                                                  "wishlist_status"=>$option_wishlist_status,
                                                  'name'=>$other_option_detail->name,
                                                  "name_first" =>$option_name_first.' ' .$option_name_second,
                                                  "name_second" =>$option_name_third,
                                                  'active_status'=>$active_variant_status,
                                                  'slug'=>$other_option_detail->slug,
                                                  'description'=>htmlspecialchars_decode($other_option_detail->description),
                                                  'Price'=>$other_option_detail->Price,
                                                  'type'=>$other_option_detail->type,
                                                  'color'=>$other_option_detail->color,
                                                  'stock'=>$other_option_detail->stock,                                                  
                                                  'strap_image'=>$other_option_detail->strap_image,
                                                  'featured_image'=>$other_option_detail->featured_image,
                                                  'night_view_image'=>$other_option_detail->night_view_image,
                                                  'item_code'=>$other_option_detail->item_code,
                                                  'gallery_images'=>$option_gallery_array);                                                  
                                              }
                                      }else{
                                        $other_options_array=array();
                                      }
                                      $story_title=array();
                                      $story_title_first=null;
                                      $story_title_second=null;
                                      $story_title_third=null;
                                      $story_title_a =explode(' ', $productdata->story_title,3);
                                      foreach($story_title_a as $key=>$story_title_sp){
                                       if($key==0){
                                        $story_title_first=$story_title_sp;
                                        }elseif($key==1){
                                          $story_title_second=$story_title_sp;
                                        }elseif($key==2){
                                          $story_title_third=$story_title_sp;
                                        }
                                      }
                                      $main_name=array();
                                      $main_name_first=null;
                                      $main_name_second=null;
                                      $main_name_third=null;
                                      $main_name_a =explode(' ', $productdata->name,3);
                                      foreach($main_name_a as $key=>$main_name_sp){
                                       if($key==0){
                                        $main_name_first=$main_name_sp;
                                       }elseif($key==1){
                                        $main_name_second=$main_name_sp;
                                       }elseif($key==2){
                                        $main_name_third=$main_name_sp;
                                        }
                                      }
                                      if($productdata->tech_data != null){
                                        $specifications_data=unserialize($productdata->tech_data);
                                        $specifications=array();
                                        foreach($specifications_data as $key=>$svalue){
                                          $specifications[]=array("label"=>$svalue['label'],"value"=>$svalue['value']);
                                        }
                                      }else{
                                        $specifications=array();
                                      }
                                      if($productdata->key_features != null){
                                        $key_features_data=unserialize($productdata->key_features);


                                        $key_features=array();
                                        foreach($key_features_data as $keyf=>$fvalue){
                                          $key_features[]=array("label"=>$fvalue['label'],"value"=>$fvalue['value'],"image"=>env('APP_URL').$fvalue['image']);
                                        }
                                      }else{
                                        $key_features=array();
                                      }

                                      $merchandising_array=array();  
                                      if($productdata->merchandising_images != null){
                                          $merchandising_images=json_decode($productdata->merchandising_images, true);
                                          if(count($merchandising_images) > 0){
                                             foreach($merchandising_images as $key=>$mgvalue){
                                              $merchandising_array[]=array("original"=>$mgvalue,"thumbnail"=>$mgvalue);
                                            }
                                          }
                                      }   
                                      $wishlist_status=Wishlist::where('user_id',$user_id)->where('item_code',$productdata->item_code)->count();

                                      $data= array("id" =>$productdata->product_id,
                                        "name" =>$productdata->name,
                                        "wishlist_status"=>$wishlist_status,
                                        "name_first" =>$main_name_first.' ' .$main_name_second,
                                        "name_second" =>$main_name_third,
                                        "main_product_name" =>$main_product_name,
                                        "slug" =>$productdata->slug,
                                        "description" => htmlspecialchars_decode($productdata->description),
                                        "featured_image" => $productdata->featured_image,
                                        'night_view_image'=>$productdata->night_view_image,
                                        "Price"=>$productdata->Price,
                                        "stock"=>$productdata->stock,
                                        "item_code"=>$productdata->item_code,
                                        "type"=>$productdata->type,
                                        "color"=>$productdata->color,
                                        "is_steel"=>$productdata->is_steel,
                                        "is_rubber"=>$productdata->is_rubber,                       
                                        "story_title"=>$productdata->story_title,
                                        "story_title_first" =>$story_title_first.' ' .$story_title_second,
                                        "story_title_second" =>$story_title_third,
                                        "story_description"=>htmlspecialchars_decode($productdata->story_description),
                                        "story_image"=>$productdata->story_image,
                                        "meta_title" =>$productdata->meta_title,
                                        "meta_keywords" =>$productdata->meta_keywords,
                                        "meta_description" =>$productdata->meta_description,
                                        "collections"=>$collection_array,
                                        "other_options"=> $other_options_array,                           
                                        "specifications"=>$specifications, 
                                        "key_features"=>$key_features, 
                                        "merchandising_images"=>$merchandising_array,
                                        "gallery_images" =>$gallery_array                                                       
                                      );   
                                      return response()->json(['success' => true,'data'=>$data], 200)->header('status', 200); 
                    }else{
                      return response()->json(['success' => false, 'message' => 'Product is not available'], 202)->header('status', 202);
                    }
        }else{
          return response()->json(['success' => false, 'message' => 'Product does not exist'], 202)->header('status', 202);
        }
      }else{
      return response()->json(['success' => false, 'message' => 'Authentication Failed'], 401)->header('status', 401);
    }
}


public function related_products(Request $request){
     $validator = Validator::make($request->all(), [
      'product_id' => 'required'                    
     ]);
     if ($validator->fails()) {
       return response()->json(['error' => $validator->errors()], 403);
     }

      $check_product=Product::where('id',$request->product_id)->first();
      if($check_product != null){
                if($check_product->status == "1"){
                             if($check_product->collection_id != null){

                                        $categories=explode(',',$check_product->collection_id); 
                                        $collection_array=array();   
                                        $product_ids=array();              
                                        if(count($categories) >0){
                                            foreach($categories as $key=>$value){
                                              $productdata=array();
                                              $productdata=  Product::orwhereRaw('FIND_IN_SET('.$value.',collection_id)')->where('parent_id','!=',$request->product_id)->where('id','!=',$request->product_id)->where('status','1')->get(); 
                                                if($productdata->count() > 0){
                                                  foreach($productdata as $product_data){
                                                    $product_ids[]=$product_data->id;
                                                  }
                                                }
                                              }



                                            if(count($product_ids) > 0){
                                              $unique_products=array_unique($product_ids);
                                              $finalproductdata=  Product::whereIn('id', $unique_products)
                                                                           ->where('parent_id','!=','0')
                                                                           ->where('status','1')
                                                                           ->limit(6)
                                                                           ->get(['id','name','slug','type','product_line_type','Price','item_code','featured_image','night_view_image']);
                                              foreach($finalproductdata as $product_detail){
                                                $product_detail['wishlist_status']=0;
                                              }   
                                              return response()->json(['success' => true,'data'=>$finalproductdata], 200)->header('status', 200);
                                            }
                                        return response()->json(['success' => false, 'message' => 'No Related Product found'], 202)->header('status', 202); 
                                      }

                          }else{
                            return response()->json(['success' => false, 'message' => 'No Related Product found'], 202)->header('status', 202);
                          }

              }else{
                return response()->json(['success' => false, 'message' => 'Product is not available'], 202)->header('status', 202);
              }
      }else{
        return response()->json(['success' => false, 'message' => 'Product does not exist'], 202)->header('status', 202);
      }
}


public function relatedProductsAuth(Request $request){
   if(Auth::check()){
    $user_id=Auth::user()->id;
                   $validator = Validator::make($request->all(), [
                    'product_id' => 'required'                    
                   ]);
                   if ($validator->fails()) {
                     return response()->json(['error' => $validator->errors()], 403);
                   }

                    $check_product=Product::where('id',$request->product_id)->first();
                    if($check_product != null){
                              if($check_product->status == "1"){
                                           if($check_product->collection_id != null){

                                                      $categories=explode(',',$check_product->collection_id); 
                                                      $collection_array=array();   
                                                      $product_ids=array();              
                                                      if(count($categories) >0){
                                                          foreach($categories as $key=>$value){
                                                            $productdata=array();
                                                            $productdata=  Product::orwhereRaw('FIND_IN_SET('.$value.',collection_id)')->where('parent_id','!=',$request->product_id)->where('id','!=',$request->product_id)->where('status','1')->get(); 
                                                              if($productdata->count() > 0){
                                                                foreach($productdata as $product_data){
                                                                  $product_ids[]=$product_data->id;
                                                                }
                                                              }
                                                            }



                                                          if(count($product_ids) > 0){
                                                            $unique_products=array_unique($product_ids);
                                                            $finalproductdata=  Product::whereIn('id', $unique_products)
                                                                                         ->where('parent_id','!=','0')
                                                                                         ->where('status','1')
                                                                                         ->limit(6)
                                                                                         ->get(['id','name','slug','type','product_line_type','Price','item_code','featured_image','night_view_image']);
                                                            foreach($finalproductdata as $product_detail){
                                                              $product_detail['wishlist_status']=Wishlist::where('user_id',$user_id)->where('item_code',$product_detail->item_code)->count();
                                                            }   
                                                            return response()->json(['success' => true,'data'=>$finalproductdata], 200)->header('status', 200);
                                                          }
                                                      return response()->json(['success' => false, 'message' => 'No Related Product found'], 202)->header('status', 202); 
                                                    }

                                        }else{
                                          return response()->json(['success' => false, 'message' => 'No Related Product found'], 202)->header('status', 202);
                                        }

                            }else{
                              return response()->json(['success' => false, 'message' => 'Product is not available'], 202)->header('status', 202);
                            }
                    }else{
                      return response()->json(['success' => false, 'message' => 'Product does not exist'], 202)->header('status', 202);
                    }
    }else{
      return response()->json(['success' => false, 'message' => 'Authentication Failed'], 401)->header('status', 401);
    }
}


public function product_queries(Request $request){
  $validator = Validator::make($request->all(), [
    'first_name' => 'required',
    'last_name' => 'required',
    'email' => 'required|email|',
    'phone' => 'required',
    'address' => 'required',
    'concern' => 'required',
    'revoke_status' => 'required',
    'product_id' => 'required'
  ]);
  if ($validator->fails()) {
   return response()->json(['error' => $validator->errors()], 403);
 }

 $product=Product::where('id',$request->product_id)->first();
 if($product != null){
  $product_name=$product->name;
  $product_price=$product->Price;
  $product_item_code=$product->item_code;
  $product_image=$product->featured_image;
}else{
  $product_name=null;
  $product_price=null;
  $product_item_code=null;
  $product_image=null;
}

$savedata = new ProductQuery();
$savedata->first_name = $request->first_name; 
$savedata->last_name = $request->last_name; 
$savedata->email = $request->email;
$savedata->phone = $request->phone;
$savedata->address = $request->address;
$savedata->concern = $request->concern;
$savedata->revoke_status = $request->revoke_status;
$savedata->product_id = $request->product_id; 
$savedata->product_name = $product_name; 
$savedata->product_item_code = $product_item_code;
$savedata->product_image = $product_image; 
$savedata->product_price=$product_price;     
$savedata->status="0";
$savedata->save();


$settings= Setting::first();
$adminto = $settings->admin_email;
$copyright = $settings->copyright;
$adminsubject = "New Inquiry Received";
$usersubject = "Inquiry Sent";
$website_link = config('app.url');

$details = ['website_link'=>$website_link,
'application_logo'=>$website_link.'/'.$settings->application_logo,
'name'=>$request->name,
'copyright'=>$request->copyright
];
    // \Mail::to($request->email)->send(new \App\Mail\InquiryMail($details));

return response()->json(["success" => true, "message" => 'Product query sent successfully'], 200);
}

}
