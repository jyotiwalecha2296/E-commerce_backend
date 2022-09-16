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
use App\Models\WatchPage;
use App\Models\SubscribedUser;
use Validator;
use Newsletter;

use Illuminate\Support\Facades\Auth; 
use Mail;
class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(){
      $success = 'fdsfdsf';
      return response()->json([
        'status' => true,
        'success' => $success
      ]);
    } 

    

    public function globalData(){      
      $data = Setting::first(['application_title','application_logo','application_favicon','copyright','facebook_url','instagram_url','twitter_url','youtube_url','pinterest_url','linkedin_url','contact_email','contact_phone','admin_email','meta_title','meta_keywords','meta_description','catalogue']);
      return response()->json(['status' => true,'data' => $data]);
    }

    
     

 public function testmail(){
  dd("test");
}

  

public function featured_products(){
 $product_count=Product::where('parent_id','0')->where('status','1')->count();
 if($product_count > 0){
  $featured_product_count=Product::where('parent_id','0')->where('featured_product_status','1')->where('status','1')->count();
  if($featured_product_count > 0){
   $product_data=Product::where('parent_id','0')->where('featured_product_status','1')->where('status','1')->orderBy('featured_product_position','ASC')->get(['id','name','slug','featured_image','night_view_image','collection_id']);               
 }else{
   $product_data=Product::where('parent_id','0')->where('status','1')->limit(5)->get(['id','name','slug','featured_image','collection_id']); 
 }
 if($product_data->count() > 0){
   foreach($product_data as $product_d){ 

    $other_options=Product::where('parent_id',$product_d->id)->where('id','!=',$product_d->id)->first();
    if($other_options != null){                           
     $price=$other_options->Price;
     $item_code=$other_options->item_code;
   }else{
    $main_product=Product::where('id',$product_d->id)->first();
    $price=$main_product->Price;
    $item_code=$main_product->item_code;
  }

  $product_d['price']=$price;
  $product_d['item_code']=$item_code;


  $collection_ids=explode(',',$product_d->collection_id); 
  $collection_array=array();                 
  if(count($collection_ids) >0){
    foreach($collection_ids as $key=>$value){
      $collection_array[]=Collection::where('id',$value)->first(['id','name']);
    }
  } 
  $product_d['collection']=$collection_array;


}
}
return response()->json(['success' => true,'data'=>$product_data], 200)->header('status', 200);
}else{
 return response()->json(['success' => false, 'message' => 'No Product Found'], 202)->header('status', 202);
}
}

public function home_slider(){  
  $data=Homeslider::where('status','1')->orderBy('position','ASC')->get(['id','pretext','title','sub_title','background_image','watch_image','link','video_link','status']);
  foreach($data as $detail){
  	 $title_array=array();
     $title_first=null;
     $title_second=null;
     $title_third=null;
     $title_array =explode(' ', $detail->title,3);
     foreach($title_array as $key=>$title_sp){
	      if($key==0){
	        $title_first=$title_sp;
	      }elseif($key==1){
	        $title_second=$title_sp;
	      }elseif($key==2){
	        $title_third=$title_sp;
	      }
     }
    $detail['title_first']=$title_first.' ' .$title_second;
    $detail['title_second']=$title_third;     
  }
  return response()->json(['status' => true,'data' => $data]);
}

public function newsletter_subscription(Request $request){
  $validator = Validator::make($request->all(), [                    
    'email' => 'required|email|',
    'terms' => 'required',

  ]);
  if ($validator->fails()) {
   return response()->json(['error' => $validator->errors()], 403);
 }

 $check_email=SubscribedUser::where('email',$request->email)->count();
 if($check_email > 0){
   return response()->json(["success" => false, "message" => 'You are already subscribed to our newsletter'], 202);
 }else{

  Newsletter::subscribe($request->email);

  $savedata = new SubscribedUser();        
  $savedata->email = $request->email;
  $savedata->terms = $request->terms;
  $savedata->status="0";
  $savedata->save();


  $settings= Setting::first();
  $adminto = $settings->admin_email;
  $copyright = $settings->copyright;
  $adminsubject = "Subscription";
  $usersubject = "Subscription";
  $website_link = config('app.url');


  $details = [ 'website_link'=>$website_link,
  'application_logo'=>$website_link.'/'.$settings->application_logo,                     
  'copyright'=>$request->copyright
];
        // \Mail::to($request->email)->send(new \App\Mail\InquiryMail($details));

return response()->json(["success" => true, "message" => 'Thank you for your subscription'], 200);
}

}

  public function watchePages()
  {
    $watch = WatchPage::first();
    if($watch)
    {
      $data = [];
        $collection_ids =unserialize($watch->collections);
        $collection_products =unserialize($watch->collection_products);
        $data['id']= $watch->id;
        $data['poster_image']= $watch->poster_image;
        $data['banner_video']= $watch->banner_video;
        $data['about_title']= $watch->about_title;
        $data['about_title_first']= implode(' ', array_slice(explode(' ', $watch->about_title), 0, 1));
        $data['about_title_last']= implode(' ', array_slice(explode(' ', $watch->about_title), 1, 2));
        $data['about_content']= $watch->about_content;
        $data['collection_widgets']= unserialize($watch->collection_widgets);
        foreach($collection_ids as $k=> $collection_id)
        {
           $collection = Collection::where('id',$collection_id)->first();
          $collectionData[$k]= $collection;
        }
        foreach($collection_products as $key => $collection_product)
        {
          $collectionProduct = Product::orwhereRaw('FIND_IN_SET('.$collection_product['collection_id'].',collection_id)')->where('parent_id','!=','0')->where('status','1')->get(['id','name','slug','featured_image','night_view_image','collection_id']); 
         
          $collection_productData[$key]['title']= $collection_product['title'];
          $collection_productData[$key]['title_first']= implode(' ', array_slice(explode(' ', $collection_product['title']), 0, 1));
          $collection_productData[$key]['title_last']= implode(' ', array_slice(explode(' ', $collection_product['title']), 1, 2));
          $collection_productData[$key]['collection_product']= $collectionProduct;
        }
        $data['collection']= $collectionData;
        $data['collection_products']= $collection_productData;
        $data['feat_col_first_title']= $watch->feat_col_first_title;
        $data['feat_col_first_subtitle']= $watch->feat_col_first_subtitle;
        $data['feat_col_first_btn_link']= $watch->feat_col_first_btn_link;
        $data['feat_col_first_btn_label']= $watch->feat_col_first_btn_label;
        $data['feat_col_first_image']= $watch->feat_col_first_image;
        $data['feat_col_sec_title']= $watch->feat_col_sec_title;
        $data['feat_col_sec_subtitle']= $watch->feat_col_sec_subtitle;
        $data['feat_col_sec_btn_link']= $watch->feat_col_sec_btn_link;
        $data['feat_col_sec_btn_label']=$watch->feat_col_sec_btn_label;
        $data['feat_col_sec_image']= $watch->feat_col_sec_image;
      return response()->json(["success" => true, "message" => 'Watches Page.' ,"data"=> $data], 200);
    }else
    {
       $response = ["message" =>'Data not found'];
           return response($response, 202);
    }
  }
}