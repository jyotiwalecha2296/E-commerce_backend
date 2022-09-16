<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\WatchPage;
use App\Models\Collection;
use App\Models\Video;
class WatchPageController extends Controller
{
    public function index(){
    	$data = WatchPage::first(); 
    	$allcollections = Collection::get();        
        $videos=Video::get();

        if($data->collection_widgets != null){
          $data['collection_widgets']=unserialize($data->collection_widgets);
        }else{
          $data['collection_widgets']=null;
        }


      

        if($data->collections != null){
          $data['collections']=unserialize($data->collections);
        }else{
          $data['collections']=null;
        }

        if($data->collection_products != null){
          $data['collection_products']=unserialize($data->collection_products);
        }else{
          $data['collection_products']=null;
        }
        return view('admin.watchPage.index')->with('data',$data)->with('videos',$videos)->with('allcollections',$allcollections);
    }

    public function update(Request $request){
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


        if($request->hasFile('poster_image')){
           $filenameWithExt = $request->file('poster_image')->getClientOriginalName();
           $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
           $extension = $request->file('poster_image')->getClientOriginalExtension();
           $fileNameToStore=$filename.'.'.$extension;
           $path = $request->file('poster_image')->move('public/homepage-sections/poster_image/', $fileNameToStore);
           $upload_poster_image= $path;
        }else{
           $upload_poster_image= $request->old_poster_image;
        }



            $collection_widget_temp_arr = array();
            $collection_widget_arr = array();
            $collection_widgets_data = $request->collection_widgets;
           
            foreach( $collection_widgets_data as $index => $collection_widgets ) {
              if(array_key_exists('image',$collection_widgets)){

                $filenameWithExt = $collection_widgets['image']->getClientOriginalName();
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                $extension = $collection_widgets['image']->getClientOriginalExtension();
                $fileNameToStore = $filename.'.'.$extension;
                $directory_name = str_slug($request->name);
                $path_dir = public_path('products/'.str_slug($request->name).'/collection_widgets');
                $dir_uri = 'public/products/'.str_slug($request->name).'/collection_widgets/'.$fileNameToStore;

                if(! file_exists($path_dir) ) {
                    mkdir($path_dir, 0777, true);
                }
                $path = $collection_widgets['image']->move($path_dir, $fileNameToStore);
                $uploadfImage = $dir_uri;

              }else{
                 if(array_key_exists('oldfimage',$collection_widgets)){
                   $uploadfImage=  $collection_widgets['oldfimage'];
                 }else{
                  $uploadfImage=null;
                 }
                 

              }

                $collection_widget_temp_arr['label'] = $collection_widgets['label'];
                $collection_widget_temp_arr['link'] = $collection_widgets['link'];
                $collection_widget_temp_arr['image'] = $uploadfImage;

                array_push($collection_widget_arr,$collection_widget_temp_arr);

            }

 
 

        $updatedata =WatchPage::find($request->id); 
        
        $updatedata->about_title = $request->about_title; 
        $updatedata->about_content = $request->about_content; 
        

        $updatedata->collection_widgets= serialize($collection_widget_arr);
        $updatedata->collections= serialize($request->collections);
        $updatedata->collection_products= serialize($request->collectionsproducts);

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
        


        $updatedata->poster_image = $upload_poster_image;
        $updatedata->banner_video = $request->banner_video;

        $updatedata->save();
        
        return  redirect()->to('watch-page')->with('success', 'Watch sections updated successfully.');
    }
}
