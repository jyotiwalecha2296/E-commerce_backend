<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Support\Facades\Response;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Collection;
use App\Models\ProductMeta;


class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    //Listing all products
    public function index(){
        $data = Product::where('parent_id','0')->orderBy('id','DESC')->get(); 

        foreach($data as $x => $main_product){            
            $main_product['options']=Product::where('parent_id',$main_product->id)->get();
            $collection_ids=explode(',',$main_product->collection_id); 
                
                $collection_array=array();                 
                if(count($collection_ids) >0){
                  foreach($collection_ids as $key=>$value){
                    $collection_array[]=Collection::where('id',$value)->first(['name']);
                  }
                }

                $main_product['collections']=$collection_array;
        }  

        $featured_product_count=Product::where('parent_id','0')->where('featured_product_status','1')->count();
        return view('admin.products.index')->with('data',$data)->with('featured_product_count',$featured_product_count);
    }
    
    //Add New Product page
    public function create(){
       $collection_list = Collection::get();
       $path = public_path('videos/');
        $files = \File::files($path); 
        $filesnamedata=array();
        if(count($files) > 0){
          foreach($files as $key => $file_details){
            $file = pathinfo($file_details);
             
            $filesnamedata[]=$file['basename'];           
          } 
        }    
       return view("admin.products.create")->with('collection_list',$collection_list)->with('filesnamedata',$filesnamedata);
    }

    public function saveproduct(Request $request){
        $validator = \Validator::make($request->all(), [
                'name'=>'required',
                'description'=>'required',
                'product_line'=>'required',
                'color'=>'required',                 
                'status'=>'required',
                'images'=>'required',
                "collection"=> "required|array|min:1",
                'featured_image'=>'required'               
        ]);
      
          if ($validator->fails()) {
                    return redirect()->back()->withErrors($validator)->withInput();
          }

        //main gallery images
         if($request->hasFile('images')){
              $names = [];
              foreach($request->file('images') as $image){
                  $destinationPath = 'public/products/gallery_images/';
                  $filename = $image->getClientOriginalName();
                  $image->move($destinationPath, $filename);
                  array_push($names, env('APP_URL').'public/products/gallery_images/'.$filename);          
              }
              $names = json_encode($names);
          }
        
          //maim featured image
          if($request->hasFile('featured_image')){
          $filenameWithExt = $request->file('featured_image')->getClientOriginalName();
          $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
          $extension = $request->file('featured_image')->getClientOriginalExtension();
          $fileNameToStore=$filename.'.'.$extension;
          $path = $request->file('featured_image')->move('public/products/featured_image/', $fileNameToStore);
          $uploadImage= $path;
          }else{
            $uploadImage= 'public/watch_placeholder.png';
          }


          //maim featured image
          if($request->hasFile('night_view_image')){
          $filenameWithExt = $request->file('night_view_image')->getClientOriginalName();
          $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
          $extension = $request->file('night_view_image')->getClientOriginalExtension();
          $fileNameToStore=$filename.'.'.$extension;
          $path = $request->file('night_view_image')->move('public/products/night_view_image/', $fileNameToStore);
          $uploadNightViewImage= $path;
          }else{
          $uploadNightViewImage= 'public/watch_placeholder.png';
          }
               
        if($request->product_type =="simple"){
           $is_steel="0"; 
           $is_rubber="0";

        }elseif($request->product_type =="only_steel_variant"){
           $is_steel="1"; 
           $is_rubber="0";

        }elseif($request->product_type =="only_rubber_variant"){
           $is_steel="0"; 
           $is_rubber="1";

        }elseif($request->product_type =="both_variations"){
           $is_steel="1"; 
           $is_rubber="1";
        }
        
        $savedata = new Product();
        $savedata->name = $request->name; 
        $savedata->slug = $request->slug;
        $savedata->description = htmlspecialchars($request->description);
        $savedata->featured_image=$uploadImage;
        $savedata->night_view_image=$uploadNightViewImage;
        $savedata->type = 'main';
        $savedata->color = $request->color;      
        $savedata->collection_id = implode(',',$request->collection);
        $savedata->status=$request->status;
        $savedata->product_type=$request->product_type;
        $savedata->product_line_type = $request->product_line;
        $savedata->is_steel=$is_steel;
        $savedata->is_rubber=$is_rubber;
        $savedata->strap_image=null;       
        if($request->product_type =="simple"){
        $savedata->item_code=$request->simple_item_code;
        $savedata->Price=$request->simple_price;
        $savedata->stock=$request->simple_stock;
        }
        $savedata->save();
        

        if($request->hasFile('story_image')){
          $filenameWithExt = $request->file('story_image')->getClientOriginalName();
          $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
          $extension = $request->file('story_image')->getClientOriginalExtension();
          $fileNameToStore=$filename.'.'.$extension;
          $path = $request->file('story_image')->move('public/products/story_image/', $fileNameToStore);
          $upload_story_image= $path;
          }else{
            $upload_story_image= 'public/watch_placeholder.png';
          }
          $key_feature_temp_arr = array();
          $key_feature_arr = array();
          $key_features_data = $request->key_features;          
          foreach( $key_features_data as $index => $key_features ) {

            if(!empty($key_features['image'])){
                $filenameWithExt = $key_features['image']->getClientOriginalName();
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                $extension = $key_features['image']->getClientOriginalExtension();
                $fileNameToStore = $filename.'.'.$extension;
                $directory_name = str_slug($request->name);
                $path_dir = public_path('products/'.str_slug($request->name).'/key_features');
                $dir_uri = 'public/products/'.str_slug($request->name).'/key_features/'.$fileNameToStore;

                if ( ! file_exists($path_dir) ) {
                    mkdir($path_dir, 0777, true);
                }
                $path = $key_features['image']->move($path_dir, $fileNameToStore);
                $uploadImage = $dir_uri;
            }else{
                $uploadImage= null;
            }
              if(($key_features['label'] !=null) && ($key_features['value'] !=null) && ($key_features['image'] !=null)){
                $key_feature_temp_arr['label'] = $key_features['label'];
                $key_feature_temp_arr['value'] = $key_features['value'];
                $key_feature_temp_arr['image'] = $uploadImage;
                array_push($key_feature_arr,$key_feature_temp_arr);
              }
              

          }
          if(count($key_feature_arr) > 0){
               $final_key_feature=serialize($key_feature_arr);
          }else{
               $final_key_feature=null;
          }
        
            $merchandising_names = array();
            $merchandising_images='merchandising_images';             
            if($request->hasFile('merchandising_images')){
              $merchandising_names = [];
              foreach($request->file('merchandising_images') as $image){
                 
                  $destinationPath = 'public/products/merchandising_images/';
                  $filename = $image->getClientOriginalName();
                  $image->move($destinationPath, $filename);
                  array_push($merchandising_names, env('APP_URL').'public/products/merchandising_images/'.$filename);          
              }
              $merchandising_names = json_encode($merchandising_names);
            }else{
              $merchandising_names=null;  
            }


 
        //META DATA SAVE
        $savemetadata = new ProductMeta();
        $savemetadata->product_id  = $savedata->id; 
        $savemetadata->story_title=$request->story_title;
        $savemetadata->story_description=htmlspecialchars($request->story_description);
        $savemetadata->story_image=$upload_story_image;     
        if($request->meta_title != null){
         $savemetadata->meta_title = $request->meta_title;   
        }else{
         $savemetadata->meta_title = $request->name;  
        }    
        $savemetadata->merchandising_images=$merchandising_names;     
        $savemetadata->meta_keywords = $request->meta_keywords; 
        $savemetadata->meta_description=$request->meta_description;
        $savemetadata->tech_data= serialize($request->specification);
        $savemetadata->key_features= $final_key_feature;
        $savemetadata->gallery_images = $names;
        $savemetadata->save();

 
        $product_id = $savedata->id;


      if(($request->product_type =="only_steel_variant") || ($request->product_type =="both_variations")){

            if($request->product_type =="only_steel_variant"){
              $featured_file_name='only_steel_variant_image';
              $strap_file_name='only_steel_variant_strap_image';
              $night_file_name='only_steel_variant_night_image';              
              $steel_gallery_images='only_steel_gallery_images';
              $steel_price=$request->only_steel_variant_price;
              $steel_stock=$request->only_steel_variant_stock;
              $steel_item_code=$request->only_steel_variant_item_code;
              $steel_description=$request->only_steel_variant_description;
      
            }else{
              $steel_gallery_images='both_variations_steel_gallery_images';
              $featured_file_name='both_variations_steel_image';
              $strap_file_name='both_variations_steel_strap_image';
              $night_file_name='both_variations_steel_night_image';
              $steel_price=$request->both_variations_steel_price;
              $steel_stock=$request->both_variations_steel_stock;
              $steel_item_code=$request->both_variations_steel_item_code;
              $steel_description=$request->both_variations_steel_description;
            }
            
            $steel_gallery_names = array();
             
            if($request->hasFile($steel_gallery_images)){
              $steel_gallery_names = [];
              foreach($request->file($steel_gallery_images) as $image){
                 
                  $destinationPath = 'public/products/steel_gallery_images/';
                  $filename = $image->getClientOriginalName();
                  $image->move($destinationPath, $filename);
                  array_push($steel_gallery_names, env('APP_URL').'public/products/steel_gallery_images/'.$filename);          
              }
              $steel_gallery_names = json_encode($steel_gallery_names);
            }


            //steel featured image
            if($request->hasFile($featured_file_name)){
                $filenameWithExt = $request->file($featured_file_name)->getClientOriginalName();
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                $extension = $request->file($featured_file_name)->getClientOriginalExtension();
                $fileNameToStore=$filename.'.'.$extension;
                $path = $request->file($featured_file_name)->move('public/products/featured_image/', $fileNameToStore);
                $uploadImage_steel= $path;
            }

            //steel strap image
            if($request->hasFile($strap_file_name)){
                $filenameWithExt = $request->file($strap_file_name)->getClientOriginalName();
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                $extension = $request->file($strap_file_name)->getClientOriginalExtension();
                $fileNameToStore=$filename.'.'.$extension;
                $path = $request->file($strap_file_name)->move('public/products/featured_image/', $fileNameToStore);
                $upload_strap_image= $path;
            }
            
            //night view image
            if($request->hasFile($night_file_name)){
                $filenameWithExt = $request->file($night_file_name)->getClientOriginalName();
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                $extension = $request->file($night_file_name)->getClientOriginalExtension();
                $fileNameToStore=$filename.'.'.$extension;
                $path = $request->file($night_file_name)->move('public/products/night_view_image/', $fileNameToStore);
                $upload_night_steel_image= $path;
            }else{
                $upload_night_steel_image='public/watch_placeholder.png';
            }
 
            $savedata = new Product();
            $savedata->name = $request->name; 
            $savedata->slug = $request->slug;
            $savedata->price = $steel_price;
            $savedata->stock = $steel_stock;
            $savedata->item_code = $steel_item_code;
            $savedata->description = htmlspecialchars($steel_description);
            $savedata->type = 'Steel Bracelet';
            $savedata->color = $request->color;
            $savedata->parent_id =  $product_id;
            $savedata->strap_image=$upload_strap_image;
            $savedata->gallery_image=$steel_gallery_names;   
            $savedata->featured_image=$uploadImage_steel;   
            $savedata->night_view_image=$upload_night_steel_image;      
            $savedata->collection_id = implode(',',$request->collection);
            $savedata->status=$request->status;
            $savedata->product_line_type = $request->product_line;
            $savedata->save();
      }

      if(($request->product_type =="only_rubber_variant") || ($request->product_type =="both_variations")){   
        
           if($request->product_type =="only_rubber_variant"){

              $rubber_featured_file_name='only_rubber_variant_image';
              $rubber_strap_file_name='only_rubber_variant_strap_image';
              $rubber_night_file_name='only_rubber_variant_night_image';
              $rubber_gallery_images='only_rubber_gallery_images';
              $rubber_price=$request->only_rubber_variant_price;
              $rubber_stock=$request->only_rubber_variant_stock;
              $rubber_item_code=$request->only_rubber_variant_item_code;
              $rubber_description=$request->only_rubber_variant_description;

            }else{

              $rubber_featured_file_name='both_variations_rubber_image';
              $rubber_strap_file_name='both_variations_rubber_strap_image';
              $rubber_night_file_name='both_variations_rubber_night_image';
              $rubber_gallery_images='both_variations_rubber_gallery_images';
              $rubber_price=$request->both_variations_rubber_price;
              $rubber_stock=$request->both_variations_rubber_stock;
              $rubber_item_code=$request->both_variations_rubber_item_code;
              $rubber_description=$request->both_variations_rubber_description;

            }

            $rubber_gallery_names = array();
            if($request->hasFile($rubber_gallery_images)){
              $rubber_gallery_names = [];
              foreach($request->file($rubber_gallery_images) as $image){
                  $destinationPath = 'public/products/rubber_gallery_images/';
                  $filename = $image->getClientOriginalName();
                  $image->move($destinationPath, $filename);
                  array_push($rubber_gallery_names, env('APP_URL').'public/products/rubber_gallery_images/'.$filename);          
              }
              $rubber_gallery_names = json_encode($rubber_gallery_names);
            }

            //steel featured image
            if($request->hasFile($rubber_featured_file_name)){
                $filenameWithExt = $request->file($rubber_featured_file_name)->getClientOriginalName();
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                $extension = $request->file($rubber_featured_file_name)->getClientOriginalExtension();
                $fileNameToStore=$filename.'.'.$extension;
                $path = $request->file($rubber_featured_file_name)->move('public/products/featured_image/', $fileNameToStore);
                $uploadImagerubber= $path;
            }

            //steel strap image
            if($request->hasFile($rubber_strap_file_name)){
                $filenameWithExt = $request->file($rubber_strap_file_name)->getClientOriginalName();
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                $extension = $request->file($rubber_strap_file_name)->getClientOriginalExtension();
                $fileNameToStore=$filename.'.'.$extension;
                $path = $request->file($rubber_strap_file_name)->move('public/products/featured_image/', $fileNameToStore);
                $upload_rubber_strap_image= $path;
            }

            //steel strap image
            if($request->hasFile($rubber_night_file_name)){
                $filenameWithExt = $request->file($rubber_night_file_name)->getClientOriginalName();
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                $extension = $request->file($rubber_night_file_name)->getClientOriginalExtension();
                $fileNameToStore=$filename.'.'.$extension;
                $path = $request->file($rubber_night_file_name)->move('public/products/night_view_image/', $fileNameToStore);
                $upload_rubber_night_image= $path;
            }else{
                $upload_rubber_night_image='public/watch_placeholder.png';
            }

            $savedata = new Product();
            $savedata->name = $request->name; 
            $savedata->slug = $request->slug;
            $savedata->price = $rubber_price;
            $savedata->stock = $rubber_stock;
            $savedata->item_code = $rubber_item_code;
            $savedata->description = htmlspecialchars($rubber_description);
            $savedata->type = 'Rubber Strap';
            $savedata->color = $request->color;
            $savedata->night_view_image=$upload_rubber_night_image;
            $savedata->parent_id =  $product_id;
            $savedata->strap_image=$upload_rubber_strap_image;
            $savedata->gallery_image=$rubber_gallery_names;    
            $savedata->featured_image=$uploadImagerubber;      
            $savedata->collection_id = implode(',',$request->collection);
            $savedata->status=$request->status;
            $savedata->product_line_type = $request->product_line;
            $savedata->save();       
           
      }  

      return redirect()->to('products')->with('success', 'Product Added successfully.');
    }

    public function edit($id){
      $collection_list = Collection::get(); 
      $data = Product::join('product_metas', 'products.id', '=', 'product_metas.product_id')->where('products.id',$id)->first(['products.*', 'product_metas.*']);  
      
      $steel_product_id=null;
      $steel_price=null;
      $steel_item_code=null;
      $steel_stock=null;
      $steel_image=null;
      $steel_night_view_image=null;
      $steel_strap_image=null;
      $steel_gallery_image=null;
      $steel_description=null;

      $rubber_product_id=null;
      $rubber_price=null;
      $rubber_item_code=null;
      $rubber_stock=null;
      $rubber_image=null;
      $rubber_night_view_image=null;
      $rubber_strap_image=null;
      $rubber_gallery_image=null;
      $rubber_description=null;

      $options=Product::where('parent_id',$id)->get();
      if($data->is_steel=="1"){
          foreach($options as $optiondata){
            if($optiondata->type=="Steel Bracelet"){
              $steel_product_id=$optiondata->id;
              $steel_price=$optiondata->Price;
              $steel_item_code=$optiondata->item_code;
              $steel_stock=$optiondata->stock;
              $steel_image=$optiondata->featured_image;
              $steel_night_view_image=$optiondata->night_view_image;
              $steel_strap_image=$optiondata->strap_image;
              $steel_gallery_image=$optiondata->gallery_image;
              $steel_description=$optiondata->description;          
            }
          }
      }

      if($data->is_rubber=="1"){
          foreach($options as $optiondata){
            if($optiondata->type=="Rubber Strap"){
              $rubber_product_id=$optiondata->id;
              $rubber_price=$optiondata->Price;
              $rubber_item_code=$optiondata->item_code;
              $rubber_stock=$optiondata->stock;
              $rubber_image=$optiondata->featured_image;
              $rubber_night_view_image=$optiondata->night_view_image;
              $rubber_strap_image=$optiondata->strap_image;
              $rubber_gallery_image=$optiondata->gallery_image;
              $rubber_description=$optiondata->description;        
            }
          }
      }

       $data['steel_product_id']=$steel_product_id;
       $data['steel_price']=$steel_price;
       $data['steel_item_code']=$steel_item_code;
       $data['steel_stock']=$steel_stock;
       $data['steel_image']=$steel_image;
       $data['steel_night_view_image']=$steel_night_view_image;
       $data['steel_strap_image']=$steel_strap_image;
       $data['steel_gallery_image']=$steel_gallery_image;
       $data['steel_description']=$steel_description;
       
       $data['rubber_product_id']=$rubber_product_id;
       $data['rubber_price']=$rubber_price;
       $data['rubber_item_code']=$rubber_item_code;
       $data['rubber_stock']=$rubber_stock;
       $data['rubber_image']=$rubber_image;
       $data['rubber_night_view_image']=$rubber_night_view_image;
       $data['rubber_strap_image']=$rubber_strap_image;
       $data['rubber_gallery_image']=$rubber_gallery_image;
       $data['rubber_description']=$rubber_description;
 
      if($data->tech_data != null){
        $data['specification_data']=unserialize($data->tech_data);
      }else{
        $data['specification_data']=null;
      }

      if($data->key_features != null){
        $data['key_features']=unserialize($data->key_features);
      }else{
        $data['key_features']=null;
      }
      
      $path = public_path('videos/');
      $files = \File::files($path); 
        $filesnamedata=array();
        if(count($files) > 0){
          foreach($files as $key => $file_details){
            $file = pathinfo($file_details);
            $filesnamedata[]=$file['basename'];           
          } 
        }
             
      return view("admin.products.edit")->with('collection_list',$collection_list)->with('data',$data)->with('filesnamedata',$filesnamedata);
      
    }


    public function show($id){                
       $collection_list = Collection::get(); 
      $data = Product::join('product_metas', 'products.id', '=', 'product_metas.product_id')->where('products.id',$id)->first(['products.*', 'product_metas.*']);  
      
      $steel_product_id=null;
      $steel_price=null;
      $steel_item_code=null;
      $steel_stock=null;
      $steel_image=null;
      $steel_night_view_image=null;
      $steel_strap_image=null;
      $steel_gallery_image=null;
      $steel_description=null;

      $rubber_product_id=null;
      $rubber_price=null;
      $rubber_item_code=null;
      $rubber_stock=null;
      $rubber_image=null;
      $rubber_night_view_image=null;
      $rubber_strap_image=null;
      $rubber_gallery_image=null;
      $rubber_description=null;

      $options=Product::where('parent_id',$id)->get();
      if($data->is_steel=="1"){
          foreach($options as $optiondata){
            if($optiondata->type=="Steel Bracelet"){
              $steel_product_id=$optiondata->id;
              $steel_price=$optiondata->Price;
              $steel_item_code=$optiondata->item_code;
              $steel_stock=$optiondata->stock;
              $steel_image=$optiondata->featured_image;
              $steel_night_view_image=$optiondata->night_view_image;
              $steel_strap_image=$optiondata->strap_image;
              $steel_gallery_image=$optiondata->gallery_image;
              $steel_description=$optiondata->description;          
            }
          }
      }

      if($data->is_rubber=="1"){
          foreach($options as $optiondata){
            if($optiondata->type=="Rubber Strap"){
              $rubber_product_id=$optiondata->id;
              $rubber_price=$optiondata->Price;
              $rubber_item_code=$optiondata->item_code;
              $rubber_stock=$optiondata->stock;
              $rubber_image=$optiondata->featured_image;
              $rubber_night_view_image=$optiondata->night_view_image;
              $rubber_strap_image=$optiondata->strap_image;
              $rubber_gallery_image=$optiondata->gallery_image;
              $rubber_description=$optiondata->description;        
            }
          }
      }

       $data['steel_product_id']=$steel_product_id;
       $data['steel_price']=$steel_price;
       $data['steel_item_code']=$steel_item_code;
       $data['steel_stock']=$steel_stock;
       $data['steel_image']=$steel_image;
       $data['steel_night_view_image']=$steel_night_view_image;
       $data['steel_strap_image']=$steel_strap_image;
       $data['steel_gallery_image']=$steel_gallery_image;
       $data['steel_description']=$steel_description;
       
       $data['rubber_product_id']=$rubber_product_id;
       $data['rubber_price']=$rubber_price;
       $data['rubber_item_code']=$rubber_item_code;
       $data['rubber_stock']=$rubber_stock;
       $data['rubber_image']=$rubber_image;
       $data['rubber_night_view_image']=$rubber_night_view_image;
       $data['rubber_strap_image']=$rubber_strap_image;
       $data['rubber_gallery_image']=$rubber_gallery_image;
       $data['rubber_description']=$rubber_description;
 
      if($data->tech_data != null){
        $data['specification_data']=unserialize($data->tech_data);
      }else{
        $data['specification_data']=null;
      }

      if($data->key_features != null){
        $data['key_features']=unserialize($data->key_features);
      }else{
        $data['key_features']=null;
      }
      
      $path = public_path('videos/');
      $files = \File::files($path); 
        $filesnamedata=array();
        if(count($files) > 0){
          foreach($files as $key => $file_details){
            $file = pathinfo($file_details);
            $filesnamedata[]=$file['basename'];           
          } 
        }
         $newcolor=strtolower($data->color);

       $gallery_array=array();     
       $gallery_images=json_decode($data->gallery_images, true);
       if(count($gallery_images) > 0){

        foreach($gallery_images as $key=>$gvalue){
          $gallery_array[]=$gvalue;
        }
      } 

      return view("admin.products.show")->with('collection_list',$collection_list)
                                        ->with('data',$data)
                                        ->with('filesnamedata',$filesnamedata)
                                        ->with('newcolor',$newcolor)
                                        ->with('gallery_array',$gallery_array);
    }




    public function update(Request $request){
     
        $validator = \Validator::make($request->all(), [
            'name'=>'required',
            'description'=>'required',
            'status'=>'required',
            'product_collection'=>'required|array', 
            'color'=>'required'                                   
        ]);
      
          if ($validator->fails()) {
              return redirect()->back()->withErrors($validator)->withInput();
          }
         

        if($request->hasFile('featured_image')){
          $filenameWithExt = $request->file('featured_image')->getClientOriginalName();
          $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
          $extension = $request->file('featured_image')->getClientOriginalExtension();
          $fileNameToStore=$filename.'.'.$extension;
          $path = $request->file('featured_image')->move('public/products/featured_image/', $fileNameToStore);
          $uploadImage= $path;
        }else{
            $uploadImage= $request->old_featured_image;
        } 

        if($request->hasFile('night_view_image')){
          $filenameWithExt = $request->file('night_view_image')->getClientOriginalName();
          $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
          $extension = $request->file('night_view_image')->getClientOriginalExtension();
          $fileNameToStore=$filename.'.'.$extension;
          $path = $request->file('night_view_image')->move('public/products/night_view_image/', $fileNameToStore);
          $uploadnightImage= $path;
        }else{
            $uploadnightImage= $request->old_night_view_image;
        } 
         

          $names = array();
          $finaloldgallery=array();
          $oldgalleryar=$request->oldgallery;

          if($oldgalleryar != null){  
             foreach($oldgalleryar as $oldgallimg){ 
                if(filter_var($oldgallimg, FILTER_VALIDATE_URL)) {
                  $finaloldgallery[]=$oldgallimg;
                  array_push($names,$oldgallimg); 
               }
             }
          }
 


          if($request->hasFile('images')){
            foreach($request->file('images') as $image)
              {
                  $destinationPath = 'public/products/gallery_images/';
                  $filename = $image->getClientOriginalName();
                  $image->move($destinationPath, $filename);
                  array_push($names,env('APP_URL').'public/products/gallery_images/'.$filename);     
              }         
          } 
          $product_data =  Product::where('id',$request->product_id)->first();
          $names = json_encode($names);   

          $savedata =  Product::find($request->product_id);
          $savedata->name = $request->name; 
          $savedata->slug = str_slug($request->name);
          $savedata->description = htmlspecialchars($request->description); 
          $savedata->featured_image=$uploadImage;     
          $savedata->night_view_image=$uploadnightImage; 
          $savedata->collection_id = implode(',',$request->product_collection);        
          $savedata->status=$request->status;
          if(($product_data->is_steel=="0")&&($product_data->is_rubber=="0")){
          $savedata->Price=$request->simple_price;
          $savedata->stock=$request->simple_stock;
          $savedata->item_code=$request->simple_item_code;
          }
          $savedata->save();
          
          $slug=Product::where('id',$request->product_id)->value('slug');
          
          
          if($product_data->is_steel=="1"){
         
           $steel_gallery_names=array();
           $finalsteeloldgallery=array();
           $oldsteelgalleryar=$request->old_steel_gallery_images;
            if($oldsteelgalleryar != null){  
               foreach($oldsteelgalleryar as $oldsteelgallimg){ 
                  if(filter_var($oldsteelgallimg, FILTER_VALIDATE_URL)) {
                    $finalsteeloldgallery[]=$oldsteelgallimg;
                    array_push($steel_gallery_names,$oldsteelgallimg); 
                 }
               }
            }
            if($request->hasFile('steel_gallery_images')){
            foreach($request->file('steel_gallery_images') as $image)
              {
                  $destinationPath = 'public/products/steel_gallery_images/';
                  $filename = $image->getClientOriginalName();
                  $image->move($destinationPath, $filename);
                  array_push($steel_gallery_names,env('APP_URL').'public/products/steel_gallery_images/'.$filename);     
              }         
            } 
            $steel_gallery_names = json_encode($steel_gallery_names);  

            if($request->hasFile('steel_image')){           
                $filenameWithExt = $request->file('steel_image')->getClientOriginalName();            
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                $extension = $request->file('steel_image')->getClientOriginalExtension();
                $fileNameToStore=$filename.'.'.$extension;
                $path = $request->file('steel_image')->move('public/products/featured_image/', $fileNameToStore);            
                $uploadImage_steel= $path;
            }else{
                $uploadImage_steel=$request->old_steel_image; 
            }

            if($request->hasFile('steel_night_view_image')){           
                $filenameWithExt = $request->file('steel_night_view_image')->getClientOriginalName();            
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                $extension = $request->file('steel_night_view_image')->getClientOriginalExtension();
                $fileNameToStore=$filename.'.'.$extension;
                $path = $request->file('steel_night_view_image')->move('public/products/steel_night_view_image/', $fileNameToStore);            
                $uploadNightImageSteel= $path;
            }else{
                $uploadNightImageSteel=$request->old_steel_night_view_image; 
            }

            if($request->hasFile('steel_strap_image')){           
                $filenameWithExt = $request->file('steel_strap_image')->getClientOriginalName();            
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                $extension = $request->file('steel_strap_image')->getClientOriginalExtension();
                $fileNameToStore=$filename.'.'.$extension;
                $path = $request->file('steel_strap_image')->move('public/products/featured_image/', $fileNameToStore);            
                $upload_steel_strap_image= $path;
            }else{
                $upload_steel_strap_image=$request->old_steel_strap_image; 
            }          

            $steeldata =  Product::find($request->steel_product_id);
            $steeldata->name = $request->name; 
            $steeldata->slug = $slug;
            $steeldata->color = $request->color;
            $steeldata->collection_id = implode(',',$request->product_collection); 
            $steeldata->status=$request->status;
            $steeldata->Price = $request->steel_price; 
            $steeldata->item_code = $request->steel_item_code;
            $steeldata->stock = $request->steel_stock; 
            $steeldata->featured_image= $uploadImage_steel; 
            $steeldata->night_view_image=$uploadNightImageSteel; 
            $steeldata->strap_image= $upload_steel_strap_image;   
            $steeldata->collection_id = implode(',',$request->product_collection);  
            $steeldata->description = htmlspecialchars($request->steel_description);    
            $steeldata->gallery_image=$steel_gallery_names;  
            $steeldata->save();

          }

          if($product_data->is_rubber=="1"){
            

           $rubber_gallery_names=array();
           $finalrubberoldgallery=array();
           $oldrubbergalleryar=$request->old_rubber_gallery_images;
            if($oldrubbergalleryar != null){  
               foreach($oldrubbergalleryar as $oldrubbergallimg){ 
                  if(filter_var($oldrubbergallimg, FILTER_VALIDATE_URL)) {
                    $finalrubberoldgallery[]=$oldrubbergallimg;
                    array_push($rubber_gallery_names,$oldrubbergallimg); 
                 }
               }
            }
            if($request->hasFile('rubber_gallery_images')){
            foreach($request->file('rubber_gallery_images') as $image)
              {
                  $destinationPath = 'public/products/rubber_gallery_images/';
                  $filename = $image->getClientOriginalName();
                  $image->move($destinationPath, $filename);
                  array_push($rubber_gallery_names,env('APP_URL').'public/products/rubber_gallery_images/'.$filename);     
              }         
            } 
            $rubber_gallery_names = json_encode($rubber_gallery_names); 


            if($request->hasFile('rubber_image')){
                $filenameWithExt = $request->file('rubber_image')->getClientOriginalName();
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                $extension = $request->file('rubber_image')->getClientOriginalExtension();
                $fileNameToStore=$filename.'.'.$extension;
                $path = $request->file('rubber_image')->move('public/products/featured_image/', $fileNameToStore);
                $uploadImage_rubber= $path;
            }else{
                $uploadImage_rubber=$request->old_rubber_image; 
            } 


            if($request->hasFile('rubber_night_view_image')){
                $filenameWithExt = $request->file('rubber_night_view_image')->getClientOriginalName();
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                $extension = $request->file('rubber_night_view_image')->getClientOriginalExtension();
                $fileNameToStore=$filename.'.'.$extension;
                $path = $request->file('rubber_night_view_image')->move('public/products/rubber_night_view_image/', $fileNameToStore);
                $uploadNightViewImagerubber= $path;
            }else{
                $uploadNightViewImagerubber=$request->old_rubber_night_view_image; 
            }  

            if($request->hasFile('rubber_strap_image')){
                $filenameWithExt = $request->file('rubber_strap_image')->getClientOriginalName();
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                $extension = $request->file('rubber_strap_image')->getClientOriginalExtension();
                $fileNameToStore=$filename.'.'.$extension;
                $path = $request->file('rubber_strap_image')->move('public/products/featured_image/', $fileNameToStore);
                $upload_rubber_strap_image= $path;
            }else{
                $upload_rubber_strap_image=$request->old_rubber_strap_image; 
            }   

            $rubberdata = Product::find($request->rubber_product_id);
            $rubberdata->name = $request->name; 
            $rubberdata->slug = $slug;
            $rubberdata->color = $request->color;
            $rubberdata->status=$request->status;  
            $rubberdata->Price = $request->rubber_price; 
            $rubberdata->item_code = $request->rubber_item_code;
            $rubberdata->strap_image= $upload_rubber_strap_image; 
            $rubberdata->night_view_image= $uploadNightViewImagerubber; 
            $rubberdata->collection_id = implode(',',$request->product_collection);
            $rubberdata->stock = $request->rubber_stock; 
            $rubberdata->featured_image= $uploadImage_rubber;      
            $rubberdata->description = htmlspecialchars($request->rubber_description); 
            $rubberdata->gallery_image=$rubber_gallery_names;       
            $rubberdata->save();

          }
           
          if($request->hasFile('story_image')){
                $filenameWithExt = $request->file('story_image')->getClientOriginalName();
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                $extension = $request->file('story_image')->getClientOriginalExtension();
                $fileNameToStore=$filename.'.'.$extension;
                $path = $request->file('story_image')->move('public/products/story_image/', $fileNameToStore);
                $upload_story_image= $path;
            }else{
                $upload_story_image=$request->old_story_image; 
            }
    
            $key_feature_temp_arr = array();
            $key_feature_arr = array();
            $key_features_data = $request->key_features;
           
            foreach( $key_features_data as $index => $key_features ) {
              if(array_key_exists('image',$key_features)){

                $filenameWithExt = $key_features['image']->getClientOriginalName();
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                $extension = $key_features['image']->getClientOriginalExtension();
                $fileNameToStore = $filename.'.'.$extension;
                $directory_name = str_slug($request->name);
                $path_dir = public_path('products/'.str_slug($request->name).'/key_features');
                $dir_uri = 'public/products/'.str_slug($request->name).'/key_features/'.$fileNameToStore;

                if(! file_exists($path_dir) ) {
                    mkdir($path_dir, 0777, true);
                }
                $path = $key_features['image']->move($path_dir, $fileNameToStore);
                $uploadfImage = $dir_uri;

              }else{
                 if(array_key_exists('oldfimage',$key_features)){
                   $uploadfImage=  $key_features['oldfimage'];
                 }else{
                  $uploadfImage=null;
                 }
                 

              }

                $key_feature_temp_arr['label'] = $key_features['label'];
                $key_feature_temp_arr['value'] = $key_features['value'];
                $key_feature_temp_arr['image'] = $uploadfImage;

                array_push($key_feature_arr,$key_feature_temp_arr);

            }
          
          $merchandising_names = array();
          $merchandisingoldgallery=array();
          $oldmerchandisingar=$request->oldmerchandisinggallery;

          if($oldmerchandisingar != null){  
             foreach($oldmerchandisingar as $oldmerchgallimg){ 
                if(filter_var($oldmerchgallimg, FILTER_VALIDATE_URL)) {
                  $merchandisingoldgallery[]=$oldmerchgallimg;
                  array_push($merchandising_names,$oldmerchgallimg); 
               }
             }
          }
         
          if($request->hasFile('merchandising_images')){
            foreach($request->file('merchandising_images') as $image)
              {
                  $destinationPath = 'public/products/merchandising_images/';
                  $filename = $image->getClientOriginalName();
                  $image->move($destinationPath, $filename);
                  array_push($merchandising_names,env('APP_URL').'public/products/merchandising_images/'.$filename);     
              }         
          }


          $savemetadata = ProductMeta::where('product_id',$request->product_id)->first();
          if($request->meta_title != null){
           $savemetadata->meta_title = $request->meta_title;   
          }else{
           $savemetadata->meta_title = $request->name;  
          } 
          $savemetadata->story_title=$request->story_title;
          $savemetadata->story_description=htmlspecialchars($request->story_description);
          $savemetadata->story_image=$upload_story_image;     
          $savemetadata->merchandising_images = $merchandising_names;      
          $savemetadata->meta_keywords = $request->meta_keywords; 
          $savemetadata->meta_description=$request->meta_description;
          $savemetadata->gallery_images = $names;
          $savemetadata->tech_data= serialize($request->specification);
          $savemetadata->key_features= serialize($key_feature_arr);
          $savemetadata->save();

        return redirect()->to('products')->with('success', 'Product Updated successfully.');
    }
    public function checkSlug(Request $request)
    {

        if (Product::where('slug', '=', $request['product_slug'])->exists()) {

           return response()->json(["status" => true]);

        }else{

            return response()->json(["status" => false]);
        }
        
    }


    public function addfeatured(Request $request){
        Product::where('id',$request->featured_product_id)->update(['featured_product_status'=> '1','featured_product_position'=>$request->featured_position]);
        return redirect()->to('/products');
    }

    public function removefeatured($id){
        Product::where('id',$id)->update(['featured_product_status'=> '0','featured_product_position'=> null]);
        return redirect()->to('/products');
    }

    public function updatefeaturedposition(Request $request){

        Product::where('id',$request->featured_product_id)->update(['featured_product_position'=>$request->featured_product_position]);
        return Response::json(['status' => true], 200);
    }

    public function deleteproduct($id){
        Product::where('parent_id',$id)->delete();
        ProductMeta::where('product_id',$id)->delete();
        Product::where('id',$id)->delete();
        return redirect()->to('/products');
    }

    public function productFilter($q){

        if($q == 'featured'){
            $data = Product::where('featured_product_status','1')->orderBy('featured_product_position', 'desc')->get();

            foreach($data as $x => $main_product){            
                $main_product['options'] = Product::where('parent_id',$main_product->id)->get();
                $collection_ids=explode(',',$main_product->collection_id); 
                    
                    $collection_array=array();                 
                    if(count($collection_ids) >0){
                      foreach($collection_ids as $key=>$value){
                        $collection_array[]=Collection::where('id',$value)->first(['name']);
                      }
                    }

                    $main_product['collections']=$collection_array;
            }  

            $featured_product_count =Product::where('parent_id','0')->where('featured_product_status','1')->count();
            return view('admin.products.index')->with('data',$data)->with('featured_product_count',$featured_product_count);
        }elseif($q == 't-line'){

            $data = Product::where('product_line_type','t-line')->Where('type','main')->orderBy('id', 'desc')->get();

            foreach($data as $x => $main_product){            
                $main_product['options'] = Product::where('parent_id',$main_product->id)->get();
                $collection_ids=explode(',',$main_product->collection_id); 
                    
                    $collection_array=array();                 
                    if(count($collection_ids) >0){
                      foreach($collection_ids as $key=>$value){
                        $collection_array[]=Collection::where('id',$value)->first(['name']);
                      }
                    }

                    $main_product['collections']=$collection_array;
            }  

            $featured_product_count =Product::where('parent_id','0')->where('featured_product_status','1')->count();
            return view('admin.products.index')->with('data',$data)->with('featured_product_count',$featured_product_count);

        }else{
            $data = Product::where('product_line_type','s-line')->Where('type','main')->orderBy('id', 'desc')->get();

            foreach($data as $x => $main_product){            
                $main_product['options'] = Product::where('parent_id',$main_product->id)->get();
                $collection_ids=explode(',',$main_product->collection_id); 
                    
                    $collection_array=array();                 
                    if(count($collection_ids) >0){
                      foreach($collection_ids as $key=>$value){
                        $collection_array[]=Collection::where('id',$value)->first(['name']);
                      }
                    }

                    $main_product['collections']=$collection_array;
            }  

            $featured_product_count =Product::where('parent_id','0')->where('featured_product_status','1')->count();
            return view('admin.products.index')->with('data',$data)->with('featured_product_count',$featured_product_count);
        }

          


    }
}
