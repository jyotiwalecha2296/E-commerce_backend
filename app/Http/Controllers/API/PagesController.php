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
use Validator;
use Newsletter;

use Illuminate\Support\Facades\Auth; 
use Mail;
class PagesController extends Controller
{
 

    public function privacyPolicy(){
      $slug = 'privacy-policy';
      $page_data = Pages::firstWhere('slug', $slug);
      if($page_data!= null){
          $data=array('title'=>$page_data->title,
                  'slug'=>$page_data->slug,
                  'content'=>htmlspecialchars_decode($page_data->content),
                  'meta_title'=>$page_data->meta_title,
                  'meta_keywords'=>$page_data->meta_keywords,
                  'meta_description'=>$page_data->meta_description);
          
          return response()->json(['success' => true,'data'=>$data], 200)->header('status', 200); 
      }else{
        return response()->json(['success' => false, 'message' => 'Page does not exist'], 202)->header('status', 202);
      }
      
    }

    public function termsAndConditions(){
      $slug = 'terms-and-conditions';
       $page_data = Pages::firstWhere('slug', $slug);
      if($page_data!= null){
          $data=array('title'=>$page_data->title,
                  'slug'=>$page_data->slug,
                  'content'=>htmlspecialchars_decode($page_data->content),
                  'meta_title'=>$page_data->meta_title,
                  'meta_keywords'=>$page_data->meta_keywords,
                  'meta_description'=>$page_data->meta_description);
          
          return response()->json(['success' => true,'data'=>$data], 200)->header('status', 200); 
      }else{
        return response()->json(['success' => false, 'message' => 'Page does not exist'], 202)->header('status', 202);
      }
    }

    public function cookies(){
      $slug = 'cookies';
      $page_data = Pages::firstWhere('slug', $slug);
       $page_data = Pages::firstWhere('slug', $slug);
      if($page_data!= null){
          $data=array('title'=>$page_data->title,
                  'slug'=>$page_data->slug,
                  'content'=>htmlspecialchars_decode($page_data->content),
                  'meta_title'=>$page_data->meta_title,
                  'meta_keywords'=>$page_data->meta_keywords,
                  'meta_description'=>$page_data->meta_description);
          
          return response()->json(['success' => true,'data'=>$data], 200)->header('status', 200); 
      }else{
        return response()->json(['success' => false, 'message' => 'Page does not exist'], 202)->header('status', 202);
      }
    }

     

    public function contactus(Request $request){
      $validator = Validator::make($request->all(), [
        'name' => 'required',
        'email' => 'required|email|',
        'subject' => 'required',
        'message'=>'required'
      ]);
      if ($validator->fails()) {
       return response()->json(['error' => $validator->errors()], 403);
     }
     $savedata = new Inquiries();
     $savedata->name = $request->name; 
     $savedata->email = $request->email;
     $savedata->subject = $request->subject; 
     $savedata->message=$request->message;
     $savedata->status="0";
     $savedata->save();

     $settings= Setting::first();
     $adminto = $settings->admin_email;
     $copyright = $settings->copyright;
     $adminsubject = "New Inquiry Received";
     $usersubject = "Inquiry Sent";
     $website_link = config('app.url');


     $details = [ 'website_link'=>$website_link,
     'application_logo'=>$website_link.'/'.$settings->application_logo,
     'name'=>$request->name,
     'copyright'=>$request->copyright
   ];
        // \Mail::to($request->email)->send(new \App\Mail\InquiryMail($details));

   return response()->json(["success" => true, "message" => 'Inquiry sent successfully'], 200);
 }


  
}