<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Collection;
use App\Models\CollectionMetas;
use App\Models\Product;
class CollectionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Collection::orderBy('id','DESC')->get(); 
        return view('admin.collections.index')->withData($data);       
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $list = Collection::get();   
        $path = public_path('videos/');
        $files = \File::files($path); 
        $filesnamedata=array();
        if(count($files) > 0){
          foreach($files as $key => $file_details){
            $file = pathinfo($file_details);
             
            $filesnamedata[]=$file['basename'];           
          } 
        }    
        return view("admin.collections.create")->with('list',$list)->with('filesnamedata',$filesnamedata);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = \Validator::make($request->all(), [
                'name'=>'required',
                'status'=>'required'  ,
                'video'=>'required',
                'content'=>'required',
                'tagline'=>'required'             
        ]);
      
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
         
        if($request->hasFile('banner_image')){
          $filenameWithExt = $request->file('banner_image')->getClientOriginalName();
          $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
          $extension = $request->file('banner_image')->getClientOriginalExtension();
          $fileNameToStore=$filename.'.'.$extension;
          $path = $request->file('banner_image')->move('public/collections/banners/', $fileNameToStore);
          $uploadbannerImage= $path;
          }else{
            $uploadbannerImage= 'public/image_placeholder.png';
          } 

          if($request->hasFile('featured_image')){          
          $filenameWithExt = $request->file('featured_image')->getClientOriginalName();
          $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
          $extension = $request->file('featured_image')->getClientOriginalExtension();
          $fileNameToStore=$filename.'.'.$extension;
          $path = $request->file('featured_image')->move('public/collections/featured_image/', $fileNameToStore);
          $uploadImage= $path;
          }else{
            $uploadImage= 'public/image_placeholder.png';
          }

          if($request->hasFile('model_image')){          
          $filenameWithExt = $request->file('model_image')->getClientOriginalName();
          $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
          $extension = $request->file('model_image')->getClientOriginalExtension();
          $fileNameToStore=$filename.'.'.$extension;
          $path = $request->file('model_image')->move('public/collections/model_image/', $fileNameToStore);
            $uploadModelImage= $path;
          }else{
            $uploadModelImage= 'public/image_placeholder.png';
          }
        

        if($request->parent_id != ""){
            $parent_id=$request->parent_id;
            $parent=Collection::where('id',$request->parent_id)->value('name');            
        }else{
            $parent_id="0";
            $parent="None";
        }
        $savedata = new Collection();
        $savedata->name = $request->name; 
        $savedata->slug = str_slug($request->name);
        $savedata->description = htmlspecialchars($request->description); 
        $savedata->model_image=$uploadModelImage;
        $savedata->banner_image=$uploadbannerImage;
        $savedata->featured_image=$uploadImage;
        $savedata->parent_id = $parent_id;
        $savedata->parent = $parent;
        $savedata->status=$request->status;
        $savedata->collection_page_status=$request->collection_page_status;
        $savedata->video_link=$request->video;
        $savedata->back_video_link=$request->back_video_link;
        $savedata->content=$request->content;
        $savedata->tagline=$request->tagline;
        $savedata->save();

        
        $savemetadata = new CollectionMetas();
        $savemetadata->collection_id  = $savedata->id; 
       if($request->meta_title != null){
         $savemetadata->meta_title = $request->meta_title;   
        }else{
         $savemetadata->meta_title = $request->name;  
        } 
        $savemetadata->meta_keywords = $request->meta_keywords; 
        $savemetadata->meta_description=$request->meta_description;
        $savemetadata->save();

        return redirect()->to('collections')->with('success', 'Collection Added successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $list = Collection::get(); 
        $path = public_path('videos/');
        $files = \File::files($path); 
        $filesnamedata=array();
        if(count($files) > 0){
          foreach($files as $key => $file_details){
            $file = pathinfo($file_details);
            $filesnamedata[]=$file['basename'];           
          } 
        }
        $data = Collection::join('collection_metas', 'collections.id', '=', 'collection_metas.collection_id')
                            ->where('collections.id',$id)                             
                            ->first(['collections.*', 'collection_metas.*']);

        return view("admin.collections.edit")->with('data',$data)->with('list',$list)->with('filesnamedata',$filesnamedata);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
     
      $validator = \Validator::make($request->all(), [
        'name'=>'required',
        'status'=>'required',
        'banner_image' => 'image|mimes:jpeg,png,jpg|max:2048', 
        'featured_image' => 'image|mimes:jpeg,png,jpg|max:2048', 
        'video'=>'required',
        'content'=>'required',
        'tagline'=>'required'  
      ]);
      
          if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
          }
         
          if($request->hasFile('banner_image')){
           // Get filename with the extension
          $filenameWithExt = $request->file('banner_image')->getClientOriginalName();
          // Get just filename
          $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
        
         // Get just ext
          $extension = $request->file('banner_image')->getClientOriginalExtension();
          $fileNameToStore=$filename.'.'.$extension;
          // Upload Image
          $path = $request->file('banner_image')->move('public/collections/banners/', $fileNameToStore);
         // Filename to store
          $uploadbannerImage= $path;
          }else{
            $uploadbannerImage= $request->old_banner_image;
          } 

          if($request->hasFile('featured_image')){
        
           // Get filename with the extension
          $filenameWithExt1 = $request->file('featured_image')->getClientOriginalName();
          // Get just filename
          $filename1 = pathinfo($filenameWithExt1, PATHINFO_FILENAME);
        
         // Get just ext
          $extension1 = $request->file('featured_image')->getClientOriginalExtension();
          $fileNameToStore1=$filename1.'.'.$extension1;
          // Upload Image
          $path1 = $request->file('featured_image')->move('public/collections/featured_image/', $fileNameToStore1);
         // Filename to store
          $uploadImage= $path1;
          }else{
            
            $uploadImage= $request->old_featured_image;
          } 


          if($request->hasFile('model_image')){          
          $filenameWithExt = $request->file('model_image')->getClientOriginalName();
          $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
          $extension = $request->file('model_image')->getClientOriginalExtension();
          $fileNameToStore=$filename.'.'.$extension;
          $path = $request->file('model_image')->move('public/collections/model_image/', $fileNameToStore);
            $uploadModelImage= $path;
          }else{
            $uploadModelImage= $request->old_model_image;
          }

        if($request->parent_id != ""){
            $parent_id=$request->parent_id;
            $parent=Collection::where('id',$request->parent_id)->value('name');            
        }else{
            $parent_id="0";
            $parent="None";
        }

        $updatedata = Collection::find($id);        
        $updatedata->name = $request->name; 
        $updatedata->slug = str_slug($request->name);
        $updatedata->description = htmlspecialchars($request->description); 
        $updatedata->banner_image=$uploadbannerImage;
        $updatedata->featured_image=$uploadImage;
        $updatedata->model_image=$uploadModelImage;
        $updatedata->parent_id = $parent_id;
        $updatedata->parent = $parent;
        $updatedata->status=$request->status;
        $updatedata->collection_page_status=$request->collection_page_status;
        $updatedata->video_link=$request->video;
        $updatedata->back_video_link=$request->back_video_link;
        $updatedata->content=$request->content;
        $updatedata->tagline=$request->tagline;
        $updatedata->save();


        $savemetadata = CollectionMetas::where('collection_id',$id)->first();
        $savemetadata->collection_id  = $id; 
        if($request->meta_title != null){
         $savemetadata->meta_title = $request->meta_title;   
        }else{
         $savemetadata->meta_title = $request->name;  
        }          
        $savemetadata->meta_keywords = $request->meta_keywords; 
        $savemetadata->meta_description=$request->meta_description;
        $savemetadata->save();

        return redirect()->to('collections')->with('success', 'Data Updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id){
       
          $all_products_data=Product::orwhereRaw('FIND_IN_SET('.$id.',collection_id)')->orderBy('id','DESC')->get();
          if($all_products_data->count() > 0){
              foreach($all_products_data as $products_data){              
              $product_collection=$products_data->collection_id;
              $product_collection_arr=explode(",",$product_collection);
              $new_collection_arr=array();
              if(count($product_collection_arr)> 0){
                   foreach($product_collection_arr as  $collection_id){
                      if($collection_id != $id){
                          $new_collection_arr[]=$collection_id;
                      }
                   }
                   if(count($new_collection_arr) > 0){
                     $collection_id=implode(',',$new_collection_arr);
                   }else{
                      $collection_id=null;
                   }                    
                   $updatedata =  Product::find($products_data->id);
                   $updatedata->collection_id = $collection_id;        
                   $updatedata->save();                  
                }
            }
          }
          
            $collection_data = Collection::find($id);
           
            $banner_image = $collection_data->banner_image;
            if(file_exists($banner_image)){
                // unlink($banner_image);  
            } 

            $featured_image = $collection_data->featured_image;
            if(file_exists($featured_image)){
                // unlink($featured_image);  
            } 
            
           CollectionMetas::where('collection_id',$id)->delete();
           Collection::destroy($id);  
             
          return redirect()->route('collections.index')->with('success', 'Collection has been deleted successfully!.');         
    }
}
