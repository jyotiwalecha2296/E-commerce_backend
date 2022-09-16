<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Homeslider;
use Illuminate\Http\Request;
use App\Models\Collection;

class HomesliderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Homeslider::orderBy('id','DESC')->get(); 
        return view('admin.home_slider.index')->with('data',$data);
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
           
   
        return view('admin.home_slider.create')->with('list',$list)->with('filesnamedata',$filesnamedata);
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
            'title'=>'required',
            'pretext'=>'required',
            'sub_title'=>'required',
            'link'=>'required',
            'position'=>'required',              
            'watch_image' => 'required',
            'video'=> 'required',
            'bg_image'=>'required',
            'status'=>'required',              
        ]);
        
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        if($request->hasFile('watch_image')){           
           $filenameWithExt = $request->file('watch_image')->getClientOriginalName();
           $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
           $extension = $request->file('watch_image')->getClientOriginalExtension();
           $fileNameToStore=$filename.'.'.$extension;
           $path = $request->file('watch_image')->move('public/home-slider/', $fileNameToStore);
           $uploadImage= $path;
           }else{
             $uploadImage= 'public/image_placeholder.png';
           } 

        if($request->hasFile('bg_image')){
           $filenameWithExt = $request->file('bg_image')->getClientOriginalName();
           $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
           $extension = $request->file('bg_image')->getClientOriginalExtension();
           $fileNameToStore=$filename.'.'.$extension;
           $path = $request->file('bg_image')->move('public/home-slider/', $fileNameToStore);
           $uploadbgImage= $path;
           }else{
             $uploadbgImage= 'public/image_placeholder.png';
           } 
      

        $savedata = new Homeslider();
        $savedata->pretext = $request->pretext;
        $savedata->title = $request->title; 
        $savedata->sub_title = $request->sub_title; 
        $savedata->watch_image = $uploadImage;
        $savedata->background_image = $uploadbgImage;
        $savedata->link = $request->link;
        $savedata->position = $request->position;              
        $savedata->video_link = $request->video;     
        $savedata->status = $request->status;
        $savedata->save();

        return redirect()->to('home-slider')->with('success', 'Slider Added successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Homeslider  $homeslider
     * @return \Illuminate\Http\Response
     */
    public function show(Request $id)
    {

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Homeslider  $homeslider
     * @return \Illuminate\Http\Response
     */
    }
    public function edit($id)
    {
        $list = Collection::get();       
        $data=Homeslider::where('id',$id)->first();
        $path = public_path('videos/');
        $files = \File::files($path); 
        $filesnamedata=array();
        if(count($files) > 0){
          foreach($files as $key => $file_details){
            $file = pathinfo($file_details);
            $filesnamedata[]=$file['basename'];           
          } 
        }       
        return view("admin.home_slider.edit")->with('data',$data)->with('list',$list)->with('filesnamedata',$filesnamedata);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Homeslider  $homeslider
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
     

        $validator = \Validator::make($request->all(), [
            'title'=>'required',
            'pretext'=>'required',
            'sub_title'=>'required',
            'link'=>'required',
            'position'=>'required',         
            'status'=>'required', 
      ]);
      
          if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
          }
         
           if($request->hasFile('watch_image')){
           $filenameWithExt = $request->file('watch_image')->getClientOriginalName();
           $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
           $extension = $request->file('watch_image')->getClientOriginalExtension();
           $fileNameToStore=$filename.'.'.$extension;
           $path = $request->file('watch_image')->move('public/home-slider/', $fileNameToStore);
           $uploadImage= $path;
           }else{
             $uploadImage= $request->old_watch_image;
           } 

        if($request->hasFile('bg_image')){
           $filenameWithExt = $request->file('bg_image')->getClientOriginalName();
           $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
           $extension = $request->file('bg_image')->getClientOriginalExtension();
           $fileNameToStore=$filename.'.'.$extension;
           $path = $request->file('bg_image')->move('public/home-slider/', $fileNameToStore);
             $uploadbgImage= $path;
           }else{
             $uploadbgImage= $request->old_background_image;
           } 
           
        $savedata =  Homeslider::find($id);
        $savedata->pretext = $request->pretext;
        $savedata->title = $request->title; 
        $savedata->sub_title = $request->sub_title; 
        $savedata->watch_image = $uploadImage;
        $savedata->background_image = $uploadbgImage;
        $savedata->link = $request->link;
        $savedata->position = $request->position;              
        $savedata->video_link = $request->video;      
        $savedata->status = $request->status;
        $savedata->save();


        return redirect()->to('home-slider')->with('success', 'Data Updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Homeslider  $homeslider
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       
        $slider_data = Homeslider::find($id);
       
        $watch_file = $slider_data->watch_image;
        if (file_exists($watch_file)) {
            unlink($watch_file);  
        } 

        $background_image = $slider_data->background_image;
        if (file_exists($background_image)) {
            unlink($background_image);  
        } 

        Homeslider::destroy($id);       
        return redirect()->route('home-slider.index')->with('success', 'Slide has been deleted successfully!.');
    }
}
