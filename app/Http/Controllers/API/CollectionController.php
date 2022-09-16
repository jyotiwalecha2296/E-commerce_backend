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
use Auth;
use Mail;
class CollectionController extends Controller
{
    
 public function collections(){  
      $data=Collection::orderBy('created_at','DESC')->where('collection_page_status','1')->get(['id','name','slug','tagline','description','video_link','featured_image','banner_image','model_image','parent_id','parent','status']);
      
   foreach($data as $col_data){
     $collect_name=array();
     $collection_name_first=null;
     $collection_name_second=null;
     $collection_name_third=null;
     $collect_name =explode(' ', $col_data->name,3);
     foreach($collect_name as $key=>$collect_name_sp){
       if($key==0){
        $collection_name_first=$collect_name_sp;
      }elseif($key==1){
        $collection_name_second=$collect_name_sp;
      }elseif($key==2){
        $collection_name_third=$collect_name_sp;
      }

    }

    $col_data['collection_name_first']=$collection_name_first.' ' .$collection_name_second;
    $col_data['collection_name_second'] =$collection_name_third;
  }

      return response()->json(['status' => true,'data' => $data]);
 }
     

public function all_collections_products(){
   $data=Collection::whereIn('id',[12,8])->where('status','1')->latest()->get();
   $productdata=array();
   $final=array();
   foreach($data as $col_data){
      $productdata = Product::orderBy('created_at','DESC')->orwhereRaw('FIND_IN_SET('.$col_data->id.',collection_id)')->where('parent_id','!=','0')->where('status','1')->get(['id','name','slug','Price','color','item_code','type','stock','featured_image','night_view_image']); 
  

    $final[] = array("collection_id" => $col_data->id,
                     "collection_name" =>$col_data->name,
                      "collection_name_first" =>implode(' ', array_slice(explode(' ', $col_data->name), 0, 1)),
                      "collection_name_last" =>implode(' ', array_slice(explode(' ', $col_data->name), 1, 8)),
                     "collection_slug" =>$col_data->slug,
                     "collection_featured_image" => $col_data->featured_image,
                     "collection_banner_image" => $col_data->banner_image,
                     "collection_model_image" => $col_data->model_image,
                     "collection_description"=>htmlspecialchars_decode($col_data->description),
                     "collection_tagline"=>$col_data->tagline,
                     "collection_content"=>$col_data->content,
                     "collection_video"=>$col_data->video_link,
                     "product_data" =>$productdata);
    $productdata=array();
  }
  return response()->json(['success' => true,'data'=>$final], 200)->header('status', 200);
}

public function collectionproducts(Request $request){
   $validator = Validator::make($request->all(), [
    'collection_slug' => 'required'                    
  ]);
   if ($validator->fails()) {
     return response()->json(['error' => $validator->errors()], 403);
   }

     $col_data=Collection::where('slug',$request->collection_slug)->where('status','1')->first();

      
     $collect_name=array();
     $collection_name_first=null;
     $collection_name_second=null;
     $collection_name_third=null;
     $collect_name =explode(' ', $col_data->name,3);
     foreach($collect_name as $key=>$collect_name_sp){
       if($key==0){
        $collection_name_first=$collect_name_sp;
      }elseif($key==1){
        $collection_name_second=$collect_name_sp;
      }elseif($key==2){
        $collection_name_third=$collect_name_sp;
      }

    }

      $productdata=array();
      if($col_data != null){

        $productdata  = Product::orwhereRaw('FIND_IN_SET('.$col_data->id.',collection_id)')->where('parent_id','!=','0')->where('status','1')->get(['id','name','item_code','slug','Price','color','type','stock','product_line_type','featured_image','night_view_image','created_at','updated_at']);

            foreach($productdata as $product_detail){
              $product_detail['wishlist_status']=0;
            }
            $productdatacount=  Product::orwhereRaw('FIND_IN_SET('.$col_data->id.',collection_id)')->where('status','1')->count();  
            $collection_content_name=array();
            $collection_content_first=null;
            $collection_content_second=null;
            $collection_content_third=null;
            $collection_content_a =explode(' ', $col_data->content,3);
            foreach($collection_content_a as $key=>$collection_content_sp){
             if($key==0){
              $collection_content_first=$collection_content_sp;
              }elseif($key==1){
                $collection_content_second=$collection_content_sp;
              }elseif($key==2){
                $collection_content_third=$collection_content_sp;
              }
            }


          $gallery_images=array();  
            if($col_data->gallery_image != null){
              $gallery_array=json_decode($col_data->gallery_image, true);
              if(count($gallery_array) > 0){
               foreach($gallery_array as $key=>$mgvalue){
                $gallery_images[]=array("original"=>$mgvalue,"thumbnail"=>$mgvalue);
              }
            }
          }   
          $final= array("collection_id" => $col_data->id,
           "collection_name" =>$col_data->name,
           "collection_name_first" =>$collection_name_first.' ' .$collection_name_second,
           "collection_name_second" =>$collection_name_third,
           "collection_slug" =>$col_data->slug,
           "collection_featured_image" => $col_data->featured_image,
           "collection_banner_image" => $col_data->banner_image,
           "collection_model_image" => $col_data->model_image,
           "collection_description"=>htmlspecialchars_decode($col_data->description),
           "collection_tagline"=>$col_data->tagline,
           "collection_content"=>$col_data->content,
           "collection_content_first" =>$collection_content_first.' ' .$collection_content_second,
           "collection_content_second" =>$collection_content_third,
           "collection_video"=>$col_data->video_link,
           "collection_back_video"=>$col_data->back_video_link,
           "gallery"=>$gallery_images,
           "products_count"=>$productdatacount,
           "product_data" =>$productdata);        
        return response()->json(['success' => true,'data'=>$final], 200)->header('status', 200);
      }else{
        return response()->json(['success' => false, 'message' => 'Collection does not exist'], 202)->header('status', 202);
      }
}

public function collectionProductsAuth(Request $request){

  if(Auth::check()){
       $validator = Validator::make($request->all(), [
        'collection_slug' => 'required'                    
      ]);
       if ($validator->fails()) {
         return response()->json(['error' => $validator->errors()], 403);
       }

               $col_data=Collection::where('slug',$request->collection_slug)->where('status','1')->first();
         
               $collect_name=array();
               $collection_name_first=null;
               $collection_name_second=null;
               $collection_name_third=null;
               $collect_name =explode(' ', $col_data->name,3);
               foreach($collect_name as $key=>$collect_name_sp){
                  if($key==0){
                    $collection_name_first=$collect_name_sp;
                  }elseif($key==1){
                    $collection_name_second=$collect_name_sp;
                  }elseif($key==2){
                    $collection_name_third=$collect_name_sp;
                  }

               }

              $productdata=array();
              if($col_data != null){

                $productdata  = Product::orwhereRaw('FIND_IN_SET('.$col_data->id.',collection_id)')->where('parent_id','!=','0')->where('status','1')->get(['id','name','item_code','slug','Price','color','type','stock','product_line_type','featured_image','night_view_image','created_at','updated_at']);
                    
                    $user_id=Auth::user()->id;
                    foreach($productdata as $product_detail){
                      $wishlist_status=Wishlist::where('user_id',$user_id)->where('item_code',$product_detail->item_code)->count();
                       $product_detail['wishlist_status']=$wishlist_status;
                    }

                    $productdatacount=  Product::orwhereRaw('FIND_IN_SET('.$col_data->id.',collection_id)')->where('status','1')->count();  
                    $collection_content_name=array();
                    $collection_content_first=null;
                    $collection_content_second=null;
                    $collection_content_third=null;
                    $collection_content_a =explode(' ', $col_data->content,3);
                    foreach($collection_content_a as $key=>$collection_content_sp){
                     if($key==0){
                      $collection_content_first=$collection_content_sp;
                      }elseif($key==1){
                        $collection_content_second=$collection_content_sp;
                      }elseif($key==2){
                        $collection_content_third=$collection_content_sp;
                      }
                    }

                  $gallery_images=array();  
                    if($col_data->gallery_image != null){
                      $gallery_array=json_decode($col_data->gallery_image, true);
                      if(count($gallery_array) > 0){
                       foreach($gallery_array as $key=>$mgvalue){
                        $gallery_images[]=array("original"=>$mgvalue,"thumbnail"=>$mgvalue);
                      }
                    }
                  } 

                  $final= array("collection_id" => $col_data->id,
                   "collection_name" =>$col_data->name,
                   "collection_name_first" =>$collection_name_first.' ' .$collection_name_second,
                   "collection_name_second" =>$collection_name_third,
                   "collection_slug" =>$col_data->slug,
                   "collection_featured_image" => $col_data->featured_image,
                   "collection_banner_image" => $col_data->banner_image,
                   "collection_model_image" => $col_data->model_image,
                   "collection_description"=>htmlspecialchars_decode($col_data->description),
                   "collection_tagline"=>$col_data->tagline,
                   "collection_content"=>$col_data->content,
                   "collection_content_first" =>$collection_content_first.' ' .$collection_content_second,
                   "collection_content_second" =>$collection_content_third,
                   "collection_video"=>$col_data->video_link,
                   "collection_back_video"=>$col_data->back_video_link,
                   "gallery"=>$gallery_images,
                   "products_count"=>$productdatacount,
                   "product_data" =>$productdata);        
                return response()->json(['success' => true,'data'=>$final], 200)->header('status', 200);
              }else{
                return response()->json(['success' => false, 'message' => 'Collection does not exist'], 202)->header('status', 202);
              }


      }else{
      return response()->json(['success' => false, 'message' => 'Authentication Failed'], 401)->header('status', 401);
      }
    }
 

 
}