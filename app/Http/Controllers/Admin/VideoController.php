<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Video;

class VideoController extends Controller
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
        $data = Video::orderBy('id','DESC')->paginate(6);
        return view('admin.videos.index')->with('data',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
         return view("admin.videos.create");
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
                'video'=>'required'                           
        ]);
      
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        if($request->hasFile('video')){          
          $filenameWithExt = $request->file('video')->getClientOriginalName();
          $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
          $extension = $request->file('video')->getClientOriginalExtension();
          $fileNameToStore=$filename.'.'.$extension;
          $path = $request->file('video')->move('public/videos/', $fileNameToStore);
          $uploadvideo= $path;

          }else{
            $uploadvideo= null;
             $filename=null;
          }
        
        if($request->title != null){
            $title=$request->title;
        }else{
           $title=$filename; 
        }

        $savedata = new Video();
        $savedata->name = $title; 
        $savedata->path = $uploadvideo;          
        $savedata->save();
        return redirect()->to('videos')->with('success', 'Video Uploaded successfully.');
    }

    
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id){        
     $delete=Video::where('id',$id)->delete();
     return redirect()->to('videos')->with('success', 'Video has been deleted Successfully!.');
    }


    
     public function search(Request $request){
         
     
    $search = $request->search;
            $data = Video::where('name', 'LIKE', '%' . $search . '%')->paginate(20);
           
               
               $pagination = $data->appends(array('search' =>$request->search));
               
                if ($data->count() > 0){
               
                    return view('admin.videos.search')->with('data', $data)->with('search', $search);
            }else{
              return view('admin.videos.search')->with('msg', 'No Results found. Try to search again !')->with('data', $data)->with('search', $search);    
            }
            
     }
     
     
     
 
}
