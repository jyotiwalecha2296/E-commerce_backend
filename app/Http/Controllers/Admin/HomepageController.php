<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Homepage;
use App\Models\Video;
class HomepageController extends Controller
{
    public function index(){
    	$data = Homepage::first();
      $videos=Video::get();

      return view('admin.homePageSections.index')->with('data',$data)->with('videos',$videos);
    }

    public function update(Request $request){
 

    	if($request->hasFile('about_logo')){
           $filenameWithExt = $request->file('about_logo')->getClientOriginalName();
           $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
           $extension = $request->file('about_logo')->getClientOriginalExtension();
           $fileNameToStore=$filename.'.'.$extension;
           $path = $request->file('about_logo')->move('public/homepage-sections/about/', $fileNameToStore);
           $uploadAboutLogo= $path;
        }else{
           $uploadAboutLogo= $request->old_about_logo;
        } 

        if($request->hasFile('trigalight_background_image')){
           $filenameWithExt = $request->file('trigalight_background_image')->getClientOriginalName();
           $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
           $extension = $request->file('trigalight_background_image')->getClientOriginalExtension();
           $fileNameToStore=$filename.'.'.$extension;
           $path = $request->file('trigalight_background_image')->move('public/homepage-sections/trigalight_background_image/', $fileNameToStore);
           $upload_trigalight_background_image= $path;
        }else{
           $upload_trigalight_background_image= $request->old_trigalight_background_image;
        } 

        if($request->hasFile('trigalight_first_image')){
           $filenameWithExt = $request->file('trigalight_first_image')->getClientOriginalName();
           $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
           $extension = $request->file('trigalight_first_image')->getClientOriginalExtension();
           $fileNameToStore=$filename.'.'.$extension;
           $path = $request->file('trigalight_first_image')->move('public/homepage-sections/trigalight_first_image/', $fileNameToStore);
           $upload_trigalight_first_image= $path;
        }else{
           $upload_trigalight_first_image= $request->old_trigalight_first_image;
        } 

        if($request->hasFile('trigalight_second_image')){
           $filenameWithExt = $request->file('trigalight_second_image')->getClientOriginalName();
           $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
           $extension = $request->file('trigalight_second_image')->getClientOriginalExtension();
           $fileNameToStore=$filename.'.'.$extension;
           $path = $request->file('trigalight_second_image')->move('public/homepage-sections/trigalight_second_image/', $fileNameToStore);
           $upload_trigalight_second_image= $path;
        }else{
           $upload_trigalight_second_image= $request->old_trigalight_second_image;
        } 

        if($request->hasFile('trigalight_title_image')){
           $filenameWithExt = $request->file('trigalight_title_image')->getClientOriginalName();
           $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
           $extension = $request->file('trigalight_title_image')->getClientOriginalExtension();
           $fileNameToStore=$filename.'.'.$extension;
           $path = $request->file('trigalight_title_image')->move('public/homepage-sections/trigalight_title_image/', $fileNameToStore);
           $upload_trigalight_title_image= $path;
        }else{
           $upload_trigalight_title_image= $request->old_trigalight_title_image;
        } 
        

        if($request->hasFile('catalogue_logo')){
           $filenameWithExt = $request->file('catalogue_logo')->getClientOriginalName();
           $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
           $extension = $request->file('catalogue_logo')->getClientOriginalExtension();
           $fileNameToStore=$filename.'.'.$extension;
           $path = $request->file('catalogue_logo')->move('public/homepage-sections/catalogue_logo/', $fileNameToStore);
           $upload_catalogue_logo= $path;
        }else{
           $upload_catalogue_logo= $request->old_catalogue_logo;
        } 

        if($request->hasFile('feat_col_first_image')){
           $filenameWithExt = $request->file('feat_col_first_image')->getClientOriginalName();
           $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
           $extension = $request->file('feat_col_first_image')->getClientOriginalExtension();
           $fileNameToStore=$filename.'.'.$extension;
           $path = $request->file('feat_col_first_image')->move('public/homepage-sections/feat_col_first_image/', $fileNameToStore);
           $upload_feat_col_first_image= $path;
        }else{
           $upload_feat_col_first_image= $request->old_feat_col_first_image;
        } 

        if($request->hasFile('feat_col_sec_image')){
           $filenameWithExt = $request->file('feat_col_sec_image')->getClientOriginalName();
           $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
           $extension = $request->file('feat_col_sec_image')->getClientOriginalExtension();
           $fileNameToStore=$filename.'.'.$extension;
           $path = $request->file('feat_col_sec_image')->move('public/homepage-sections/feat_col_sec_image/', $fileNameToStore);
           $upload_feat_col_sec_image= $path;
        }else{
           $upload_feat_col_sec_image= $request->old_feat_col_sec_image;
        } 
 
        if($request->hasFile('parallax_first_img')){
           $filenameWithExt = $request->file('parallax_first_img')->getClientOriginalName();
           $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
           $extension = $request->file('parallax_first_img')->getClientOriginalExtension();
           $fileNameToStore=$filename.'.'.$extension;
           $path = $request->file('parallax_first_img')->move('public/homepage-sections/parallax_first_img/', $fileNameToStore);
           $upload_parallax_first_img= $path;
        }else{
           $upload_parallax_first_img= $request->old_parallax_first_img;
        } 

        if($request->hasFile('parallax_sec_img')){
           $filenameWithExt = $request->file('parallax_sec_img')->getClientOriginalName();
           $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
           $extension = $request->file('parallax_sec_img')->getClientOriginalExtension();
           $fileNameToStore=$filename.'.'.$extension;
           $path = $request->file('parallax_sec_img')->move('public/homepage-sections/parallax_sec_img/', $fileNameToStore);
           $upload_parallax_sec_img = $path;
        }else{
           $upload_parallax_sec_img = $request->old_parallax_sec_img;
        } 

        if($request->hasFile('parallax_third_img')){
           $filenameWithExt = $request->file('parallax_third_img')->getClientOriginalName();
           $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
           $extension = $request->file('parallax_third_img')->getClientOriginalExtension();
           $fileNameToStore=$filename.'.'.$extension;
           $path = $request->file('parallax_third_img')->move('public/homepage-sections/parallax_third_img/', $fileNameToStore);
           $upload_parallax_third_img = $path;
        }else{
           $upload_parallax_third_img = $request->old_parallax_third_img;
        }

        if($request->hasFile('parallax_back_image')){
           $filenameWithExt = $request->file('parallax_back_image')->getClientOriginalName();
           $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
           $extension = $request->file('parallax_back_image')->getClientOriginalExtension();
           $fileNameToStore=$filename.'.'.$extension;
           $path = $request->file('parallax_back_image')->move('public/homepage-sections/parallax_back_image/', $fileNameToStore);
           $upload_parallax_back_image = $path;
        }else{
           $upload_parallax_back_image = $request->old_parallax_back_image;
        } 

        if($request->hasFile('strap_sec_image')){
           $filenameWithExt = $request->file('strap_sec_image')->getClientOriginalName();
           $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
           $extension = $request->file('strap_sec_image')->getClientOriginalExtension();
           $fileNameToStore=$filename.'.'.$extension;
           $path = $request->file('strap_sec_image')->move('public/homepage-sections/strap_sec_image/', $fileNameToStore);
           $upload_strap_sec_image = $path;
        }else{
           $upload_strap_sec_image= $request->old_strap_sec_image;
        } 


    	$updatedata =Homepage::find($request->id); 

        $updatedata->about_title = $request->about_title; 
        $updatedata->about_subtile = $request->about_subtile; 
        $updatedata->about_button_text = $request->about_button_text; 
        $updatedata->about_button_link = $request->about_button_link; 
        $updatedata->about_logo = $uploadAboutLogo;

        $updatedata->trigalight_title = $request->trigalight_title;
        $updatedata->trigalight_subtitle = $request->trigalight_subtitle;
        $updatedata->trigalight_content = htmlspecialchars($request->trigalight_content);
        $updatedata->trigalight_background_image = $upload_trigalight_background_image;
        $updatedata->trigalight_first_image = $upload_trigalight_first_image;
        $updatedata->trigalight_second_image = $upload_trigalight_second_image;
        $updatedata->trigalight_title_image = $upload_trigalight_title_image;
        
        $updatedata->home_video = $request->home_video;
        
        $updatedata->feat_col_first_title = $request->feat_col_first_title;
        $updatedata->feat_col_first_subtitle = $request->feat_col_first_subtitle;
        $updatedata->feat_col_first_btn_link = $request->feat_col_first_btn_link;
        $updatedata->feat_col_first_btn_label = $request->feat_col_first_btn_label;
        $updatedata->feat_col_first_image = $upload_feat_col_first_image;

        $updatedata->feat_col_sec_title = $request->feat_col_sec_title;
        $updatedata->feat_col_sec_subtitle = $request->feat_col_sec_subtitle;
        $updatedata->feat_col_sec_btn_link = $request->feat_col_sec_btn_link;
        $updatedata->feat_col_sec_btn_label = $request->feat_col_sec_btn_label;
        $updatedata->feat_col_sec_image = $upload_feat_col_sec_image;

         
        
        $updatedata->catalogue_content= htmlspecialchars($request->catalogue_content);         
        $updatedata->catalogue_subtitle = $request->catalogue_subtitle;
        $updatedata->catalogue_btn_label = $request->catalogue_btn_label;
        $updatedata->catalogue_logo = $upload_catalogue_logo;

        $updatedata->parallax_content= htmlspecialchars($request->parallax_content);         
        $updatedata->parallax_first_img = $upload_parallax_first_img;
        $updatedata->parallax_sec_img = $upload_parallax_sec_img;
        $updatedata->parallax_third_img = $upload_parallax_third_img;
        $updatedata->parallax_back_image = $upload_parallax_back_image;

        $updatedata->strap_sec_content= htmlspecialchars($request->strap_sec_content);         
        $updatedata->strap_sec_title = $request->strap_sec_title;
        $updatedata->strap_sec_btn_label = $request->strap_sec_btn_label;
        $updatedata->strap_sec_btn_link = $request->strap_sec_btn_link;
        $updatedata->strap_sec_image = $upload_strap_sec_image;

        $updatedata->save();
        return  redirect()->to('homepage-settings')->with('success', 'Homepage sections updated successfully.');
    }


   

}
