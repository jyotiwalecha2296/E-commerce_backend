<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pages;

class PagesController extends Controller
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
        $all_pages = Pages::orderBy('id','DESC')->get(); 
        return view('admin.pages.index')->with(['all_pages' => $all_pages]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
         return view("admin.pages.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $pages = new Pages();
        $pages->title = $request->title; 
        $pages->slug = str_slug($request->title);
        $pages->content = htmlspecialchars($request->content); 
        $pages->meta_title=$request->meta_title;
        $pages->meta_keywords=$request->meta_keywords;
        $pages->meta_description =$request->meta_description;
        $pages->save();
        return redirect()->to('pages')->with('success', 'Page Added successfully.');
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
        $pagesdata=Pages::where('id',$id)->first();
        return view("admin.pages.edit")->with('pagesdata',$pagesdata);
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

        $pages = Pages::find($request->page_id);
        $pages->content = htmlspecialchars($request->content);
        $pages->meta_title=$request->meta_title;
        $pages->meta_keywords=$request->meta_keywords;
        $pages->meta_description =$request->meta_description; 
        $pages->save();
        return redirect()->to('pages')->with('success', 'Page Data Updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        
     $delete=Pages::where('id',$id)->delete();
     return redirect()->to('pages')->with('success', 'Page has been deleted Successfully!.');
    }
}
