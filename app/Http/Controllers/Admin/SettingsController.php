<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;
class SettingsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Setting::first();
       return view('admin.settings.index')->with(['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        //
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
        {
        $validator = \Validator::make($request->all(), [
                'application_title'=>'required'              

        ]);
        if ($validator->fails()) {

            return redirect()->back()->withErrors($validator)->withInput();

        }else{

        if($request->hasFile('application_logo')){          
          $filenameWithExt = $request->file('application_logo')->getClientOriginalName();
          $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
          $extension = $request->file('application_logo')->getClientOriginalExtension();
          $fileNameToStore=$filename.'.'.$extension;
          $path = $request->file('application_logo')->move('public/', $fileNameToStore);
          $uploadImage= $path;
        }else{
          $uploadImage =$request->old_application_logo;
        }

        if($request->hasFile('application_blue_logo')){          
          $filenameWithExt = $request->file('application_blue_logo')->getClientOriginalName();
          $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
          $extension = $request->file('application_blue_logo')->getClientOriginalExtension();
          $fileNameToStore=$filename.'.'.$extension;
          $path = $request->file('application_blue_logo')->move('public/', $fileNameToStore);
          $uploadblueImage= $path;
        }else{
          $uploadblueImage =$request->old_application_blue_logo;
        }

        //WEBSITE FAVICON       
        if($request->hasFile('application_favicon')){          
          $filenameWithExt = $request->file('application_favicon')->getClientOriginalName();
          $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
          $extension = $request->file('application_favicon')->getClientOriginalExtension();
          $fileNameToStore=$filename.'.'.$extension;          
          $path = $request->file('application_favicon')->move('public/', $fileNameToStore);         
          $uploadImagefav= $path;
        }else{
          $uploadImagefav =$request->old_application_favicon;
        }

        //FOOTER LOGO       
        if($request->hasFile('footer_logo')){          
          $filenameWithExt = $request->file('footer_logo')->getClientOriginalName();
          $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
          $extension = $request->file('footer_logo')->getClientOriginalExtension();
          $fileNameToStore=$filename.'.'.$extension;          
          $path = $request->file('footer_logo')->move('public/footer_logo', $fileNameToStore);         
          $uploadfooterlogo= $path;
        }else{
          $uploadfooterlogo =$request->old_footer_logo;
        }

        //CATALOGUE
        if($request->hasFile('catalogue')){          
          $filenameWithExt = $request->file('catalogue')->getClientOriginalName();
          $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
          $extension = $request->file('catalogue')->getClientOriginalExtension();
          $fileNameToStore=$filename.'.'.$extension;          
          $path = $request->file('catalogue')->move('public/catalogue', $fileNameToStore);         
          $uploadcatalogue = $path;
        }else{
          $uploadcatalogue = $request->old_catalogue;
        }
      
          $settings = Setting::find($id);
          $settings->application_title = $request->application_title;
          $settings->application_logo = $uploadImage;
          $settings->application_favicon = $uploadImagefav;  
          $settings->footer_logo = $uploadfooterlogo;  
          $settings->catalogue = $uploadcatalogue;  
          $settings->admin_email = $request->admin_email;
          $settings->copyright = $request->copyright;         
          $settings->contact_email = $request->contact_email;
          $settings->contact_phone = $request->contact_phone;
          $settings->youtube_url = $request->youtube_url;
          $settings->facebook_url = $request->facebook_url;
          $settings->instagram_url = $request->instagram_url;
          $settings->twitter_url = $request->twitter_url;
          $settings->linkedin_url  = $request->linkedin_url;
          $settings->pinterest_url = $request->pinterest_url;
          $settings->meta_title=$request->meta_title;
          $settings->meta_keywords=$request->meta_keywords;
          $settings->meta_description =$request->meta_description;
          $settings->application_blue_logo=$uploadblueImage;
          $settings->save();   

          return redirect()->back()->with('success', ' Settings has been updated succesfully');
            
        }
    }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
