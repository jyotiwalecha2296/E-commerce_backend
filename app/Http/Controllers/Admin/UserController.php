<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\CountryCode;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\UserCart;
use App\Models\Wishlist;
use App\Models\Address;
class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
       $data=User::where('type','2')->orderBy('id','DESC')->get();
        return view("admin.users.index")->with('data',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){

        $country_codes=CountryCode::all();  
        return view("admin.users.create")->with('country_codes',$country_codes);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){
       
        $validator = \Validator::make($request->all(), [
                    'first_name'=>'required|alpha',
                    'last_name'=>'required|alpha',
                    'email'=>'required|email|unique:users',
                    'country_code'=>'required',
                    'phone'=>'required',
                    'password'=>'required|min:6|regex:/[a-z]/|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{6,}$/',
                    'birth_date'=>'required|date_format:Y-m-d|before:today',
                    'status'=>'required',
                    'user_status'=>'required',
        ]);
        
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        if($request->hasFile('profile_image')){
          $filenameWithExt = $request->file('profile_image')->getClientOriginalName();
          $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
          $extension = $request->file('profile_image')->getClientOriginalExtension();
          $fileNameToStore=$filename.'.'.$extension;
          $path = $request->file('profile_image')->move('public/users/profile/', $fileNameToStore);
          $uploadImage= $path;
        }else{
          $uploadImage = 'public/images/user-avtar.png';
        } 

        $user = new User();
        $user->name = ucfirst($request->first_name) .' '.ucfirst($request->last_name);
        $user->first_name = ucfirst($request->first_name);
        $user->last_name = ucfirst($request->last_name);
        $user->email = $request->email;
        $user->country_code = $request->country_code; 
        $user->contact_no = $request->phone;  
        $user->birth_date = $request->birth_date;  
        $user->status = $request->status;  
        $user->user_status = $request->user_status;
        $user->password = bcrypt($request->password);
        $user->image = $uploadImage;
        $user->type = "2";
        $user->terms = 1;
        $user->gdrp = 1;
        $user->save();       

        return redirect()->to('users')->with('success', 'User created successfully.');
    
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id){
        $data=User::where('id',$id)->first();
        $orders=Order::where('user_id',$id)->get();
        $addresses=Address::where('user_id',$id)->get();
        $wishlists=Wishlist::join('products', 'products.item_code', '=', 'wishlists.item_code')->get(); 
        $carts=UserCart::join('products', 'products.item_code', '=', 'user_carts.item_code')->get();        
        return view("admin.users.show")->with('data', $data)
                                       ->with('orders', $orders)
                                       ->with('addresses', $addresses)
                                       ->with('wishlists', $wishlists)
                                       ->with('carts', $carts);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id){
         $country_codes=CountryCode::all();  
         $data=User::where('id',$id)->first();
         return view("admin.users.edit")->with('data', $data)->with('country_codes',$country_codes);
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
        if($request->hasFile('profile_image')){
              $filenameWithExt = $request->file('profile_image')->getClientOriginalName();
              $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
              $extension = $request->file('profile_image')->getClientOriginalExtension();
              $fileNameToStore=$filename.'.'.$extension;
              $path = $request->file('profile_image')->move('public/users/profile/', $fileNameToStore);
              $uploadImage= $path;
            }else{
              $uploadImage = $request->old_profile_image;
            } 
        
         if($request->new_password != null){
            $validator = \Validator::make($request->all(), [
                    'first_name'=>'required|alpha',
                    'last_name'=>'required|alpha',
                    'email'=>'required|email|unique:users,email,' . $id,
                    'country_code'=>'required',
                    'phone'=>'required',                     
                    'birth_date'=>'required|date_format:Y-m-d|before:today',
                    'status'=>'required',
                    'new_password'=>'required|min:8|max:12|different:old_password|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{6,}$/',
                    'old_password'=>'required',
                    'new_confirm_password'=>'same:new_password',
                    'user_status'=>'required'
            ]);
            if($validator->fails()) {
                 return redirect()->back()->withErrors($validator)->withInput();
            }

            

            $user =User::findOrFail($id);
            $user->name = ucfirst($request->first_name) .' '.ucfirst($request->last_name);
            $user->first_name = ucfirst($request->first_name);
            $user->last_name = ucfirst($request->last_name);
            $user->image = $uploadImage;
            $user->email = $request->email;
            $user->country_code = $request->country_code; 
            $user->contact_no = $request->phone;  
            $user->birth_date = $request->birth_date;  
            $user->status = $request->status;  
            $user->password = bcrypt($request->new_password);
            $user->user_status = $request->user_status;             
            $user->type = "2";
            $user->terms = 1;
            $user->gdrp = 1;
            $user->save(); 
            return redirect()->to('users')->with('success', 'User Detail Updated successfully.');

         }else{

            $validator = \Validator::make($request->all(), [
                    'first_name'=>'required|alpha',
                    'last_name'=>'required|alpha',
                    'email'=>'required|email|unique:users,email,' . $id,
                    'country_code'=>'required',
                    'phone'=>'required',                     
                    'birth_date'=>'required|date_format:Y-m-d|before:today',
                    'status'=>'required',
                    'user_status'=>'required'
            ]);
            if($validator->fails()) {
                 return redirect()->back()->withErrors($validator)->withInput();
            }

            $user =User::findOrFail($id);
            $user->name = ucfirst($request->first_name) .' '.ucfirst($request->last_name);
            $user->first_name = ucfirst($request->first_name);
            $user->last_name = ucfirst($request->last_name);
            $user->email = $request->email;
            $user->image = $uploadImage;
            $user->country_code = $request->country_code; 
            $user->contact_no = $request->phone;  
            $user->birth_date = $request->birth_date;  
            $user->status = $request->status;  
            $user->user_status = $request->user_status;             
            $user->type = "2";
            $user->terms = 1;
            $user->gdrp = 1;
            $user->save(); 

            return redirect()->to('users')->with('success', 'User Detail Updated successfully.');
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
     User::where('id',$id)->delete();
     UserCart::where('user_id',$id)->delete();
     Wishlist::where('user_id',$id)->delete();
     $get_orders=Order::where('user_id',$id)->get();
     if($get_orders->count() >0){
        foreach($get_orders as $order_data){
        OrderItem::where('order_id',$order_data->id)->delete();
        }
     }
     Order::where('user_id',$id)->delete();
     return redirect()->to('users')->with('success', 'User has been deleted Successfully!.');
    }
}
