<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\Order;
use App\Models\Wishlist;
use App\Models\Address;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth; 
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;

class ProfileController extends Controller
{

    // update profile api

    public function updateProfile(Request $request)
    {
        $validator = Validator::make($request->all(), [ 
            'status' => 'required|in:Mrs,Ms,Mr',
            'first_name' => 'required|alpha',
            'last_name' => 'required|alpha',
            'email' => ['required',Rule::unique('users')->ignore(Auth::id())],
            'country_code' => 'required',
            'contact_no' => 'required|digits:10',
            'birth_date' => 'required|numeric|min:1|max:31',
            'birth_month' => 'required|numeric|min:1|max:12',
            'birth_year' => 'required|digits:4|numeric',
            'image' => 'mimes:jpeg,jpg,png',
        ]);
        if ($validator->fails()) 
        { 
            return response()->json(['errors'=>$validator->errors()], 403);            
        } 
        if(Auth::check())
        {
            if($request->hasFile('image'))
        {
          $filenameWithExt = $request->file('image')->getClientOriginalName();
          $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
          $extension = $request->file('image')->getClientOriginalExtension();
          $fileNameToStore=$filename.'.'.$extension;
          $path = $request->file('image')->move('public/user_profile/', $fileNameToStore);
          $uploadImage= $path;
        }else
        {
            $uploadImage= 'public/images/user-avtar.png';
        }
            $users = User::find(Auth::id());
            $date = $request->birth_year .'-'.$request->birth_month.'-'.$request->birth_date;
            $abc = strtotime($date);
            $birth_day = date('Y-m-d', $abc);

            if($users)
            {     
                $users->first_name = $request->first_name;
                $users->last_name = $request->last_name;
                $users->name = $request->first_name.' '.$request->last_name;
                $users->email = $request->email;
                $users->country_code = $request->country_code;
                $users->contact_no = $request->contact_no;
                $users->birth_date = $birth_day;
                $users->status = $request->status;
                $users->image = $uploadImage;    
                $users->save(); 
            }else
            {
                $response = ["message" =>'User does not exist'];
                return response($response, 202);
            }
            $users = User::where('id',Auth::id())->first();
            $data =[];
            $data['id'] = $users->id;
            $data['name'] = $users->name;
            $data['first_name'] = $users->first_name;
            $data['last_name'] = $users->last_name;
            $data['email'] = $users->email;
            $data['country_code'] = $users->country_code;
            $data['contact_no'] = $users->contact_no;
            $data['status'] = $users->status;
            $data['terms'] = $users->terms;
            $data['user_status'] = $users->user_status;
            $data['birth_date'] = $users->birth_date;
            $data['image'] = $users->image;
            $data['type'] = $users->type;
            return response()->json(["success" => true, "message" => 'Profile Updated Successfully.' ,"data"=> $data], 200);
        }else
        {
            return response()->json(['success' => false, 'message' => 'Authentication Failed'], 401)->header('status', 401);
        } 
    }


    // delete profile Api

    public function deleteProfile(Request $request)
    {
        if(Auth::check())
        {
            $user = user::find(Auth::id());
            if($user)
            {
                $userAddresses = Address::where('user_id',$user->id)->delete();
                $userOrders = Order::where('user_id',$user->id)->delete();
                if(File::exists($user->image)) 
                {
                    File::delete($user->image);
                }
                $user->delete();
            }
            return response()->json(["success" => true, "message" => 'Profile deleted Successfully.'], 200);
        }else
        {
            return response()->json(['success' => false, 'message' => 'Authentication Failed'], 401)->header('status', 401);
        }         
    }

    // view profile Api

    public function viewProfile(Request $request)
    { 
        if(Auth::check())
        {   
            $user = user::find(Auth::id());
            if($user)
            {            
                return response()->json(["success" => true, "data" => $user], 200);
            }
        }else
        {
            return response()->json(['success' => false, 'message' => 'Authentication Failed'], 401)->header('status', 401);
        }      
    }

    // search user by name

    public function searchUser(Request $request)
    {
        $users =[];
        if(isset($request->name))
        {
            $users = User::where('name', 'LIKE', '%'. $request->name. '%')->where('type',0)->get();
        }else
        {
            $users = User::where('type',0)->get();
        }
        return response()->json(["success" => true, "message" => 'Users List.' ,"data"=> $users], 200);
    }

    // change password of login user

    public function changePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'old_password' => 'required|min:6|regex:/[a-z]/|regex:/[A-Z]/|regex:/[0-9]/|regex:/[@$!%*#?&]/',
            'password' => 'required|min:6|regex:/[a-z]/|regex:/[A-Z]/|regex:/[0-9]/|regex:/[@$!%*#?&]/',
            'confirm_password' => 'required|same:password',
        ]);
        if ($validator->fails()) 
        { 
             return response()->json(['errors'=>$validator->errors()], 403);            
        }
        if(Auth::check())
        {
            $user = User::where('id',Auth::id())->first();
            if (Hash::check($request->old_password, $user->password)) 
            {
                $user = User::where('id',Auth::id())->update([
                    'password'=> Hash::make($request->password),
                ]);
            }else
            {
                return response()->json(['success' => false, 'message' => 'Password mismatch'], 403)->header('status', 403);
            }
        }
        return response()->json(["success" => true, "message" => 'Password Changed Successfully.'], 200);
    }

    // get the count of my order,count of my wishlist

    public function myAccount(Request $request)
    {
        if(Auth::check())
        {
            $my_order = Order::where('user_id',Auth::id())->count();   
            $my_wishlist = Wishlist::where('user_id',Auth::id())->count();   
            $data = [];
            $data['My Order'] = $my_order;
            $data['My Wishlist'] = $my_wishlist;
            return response()->json(["success" => true, "message" => 'My Account.' ,"data"=> $data], 200);

        }else
        {
            return response()->json(['success' => false, 'message' => 'Authentication Failed.'], 401)->header('status', 401);
        }
    }

    // logout Api
    
    public function logout(Request $request)
    {
        if(Auth::check())
        {
            auth()->user()->token()->revoke();
            return response()->json(["success" => true, "message" => 'Successfully logged out.'], 200);
        }else
        {
            return response()->json(['success' => false, 'message' => 'Authentication Failed.'], 401)->header('status', 401);
        }
    }
}
