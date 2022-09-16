<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Auth;
class ProfileController extends Controller
{
     public function index(){
    	$data = User::where('type','1')->first();
    	return view('admin.profile')->with('data',$data);
    }


    public function updateProfile(Request $request)
    {
       $id=Auth::user()->id;
       

        if($request->password == null){
               $validator = \Validator::make($request->all(), [
                'name'=>'required|max:120',
                'email'=>'required|email|unique:users,email,'.$id 
               ]);
      
               if ($validator->fails()) {
                    return redirect()->back()->withErrors($validator)->withInput();
                 }else{                     
                  $user = User::find($id);
                  $user->name = $request->name;
                  $user->email = $request->email;                          
                  $user->save();                                                                                                 
                  return redirect()->back()->with('success','Profile updated successfully.');                                                                
                  }
        
        
          }else{
              $validator = \Validator::make($request->all(), [
                'name'=>'required|max:120',
                'email'=>'required|email|unique:users,email,'.$id,
                'password'=>'required|min:6|confirmed',
                 
               ]);
        
               if ($validator->fails()) {
                    return redirect()->back()->withErrors($validator)->withInput();
                 }else{
                  $user = User::find($id);
                  $user->name = $request->name;
                  $user->email = $request->email;                 
                  $user->password = bcrypt($request->password);                  
                  $user->save();                    
                                                                                
                 return redirect()->back()->with('success','Profile updated successfully.');                                                                
               }
          }
    }

}
