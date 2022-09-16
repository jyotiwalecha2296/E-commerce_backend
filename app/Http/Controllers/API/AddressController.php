<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Address; 
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth; 

class AddressController extends Controller
{

    // Add address of user
    public function addAddress(Request $request)
    {
        $validator = Validator::make($request->all(), [ 
            'address' => 'required|alpha',
            'city' => 'required|alpha',
            'pincode' => 'required',
            'country' => 'required',
            'country_code' => 'required',
        ]);
        if ($validator->fails()) 
        { 
            return response()->json(['errors'=>$validator->errors()], 403);            
        }
        $updateAddress = Address::where('user_id',$request->user_id)->get();
        if($updateAddress)
        {
            Address::where('user_id',Auth::id())->update([
                'is_default' => 0
            ]);
        }
        $Address = Address::create([
            'user_id' => Auth::id(),
            'address' => $request->address,
            'city' => $request->city,
            'pincode' => $request->pincode,
            'country' => $request->country,
            'country_code' => $request->country_code,
            'is_default' => 1,
        ]); 
        $Address = Address::where('id',$Address->id)->with('getShipping')->first();

        return response()->json(["success" => true, "message" => 'Address Added Successfully.' ,"data"=> $Address], 200);
    }

    // update the address Api

    public function updateAddress(Request $request)
    {
        $validator = Validator::make($request->all(), [ 
            'address_id' => 'required|integer',
            'address' => 'required',
            'city' => 'required',
            'pincode' => 'required',
            'country' => 'required',
            'country_code' => 'required',
        ]);
        if ($validator->fails()) 
        { 
            return response()->json(['errors'=>$validator->errors()], 403);            
        }

        $Address = Address::where('id',$request->address_id)->where('user_id',Auth::id())->first();
        $updateAddress = Address::where('id',$request->address_id)->where('user_id',Auth::id())->get();
        if($updateAddress)
        {
            Address::where('user_id',Auth::id())->update([
                'is_default' => 0
            ]);
        }
        if($Address)
        {
            $Address->update([
                'user_id' => Auth::id(),
                'address' => $request->address,
                'city' => $request->city,
                'pincode' => $request->pincode,
                'country' => $request->country,
                'country_code' => $request->country_code,
                'is_default' => 1,
            ]); 
        }else{
            $response = ["message" =>'Address does not exist'];
               return response($response, 202);
        }
        $Address = Address::where('id',$Address->id)->where('user_id',Auth::id())->with('getShipping')->first();
        return response()->json(["success" => true, "message" => 'Address Updated Successfully.' ,"data"=> $Address], 200);
    }

    // delete the address Api

    public function deleteAddress(Request $request)
    {
        $validator = Validator::make($request->all(), [ 
            'id' => 'required|integer|exists:addresses',
        ]);
        if ($validator->fails()) 
        { 
            return response()->json(['errors'=>$validator->errors()], 403);            
        }

        $Address = Address::where('id',$request->id)->where('user_id',Auth::id())->first();
        if($Address)
        {
            $Address->delete();
        }else
        {
            $response = ["message" =>'Address does not exist'];
            return response($response, 202);
        }
        return response()->json(["success" => true, "message" => 'Address Deleted Successfully.'], 200);
    }

    // To get the List of the login user Addressess

    public function addressList(Request $request)
    {
        $address =[];
        if(Auth::check())
        {
            $address = Address::Where('user_id',Auth::id())->with('getShipping')->get();
            return response()->json(["success" => true, "message" => 'Address List.',"data"=> $address], 200);
        }else
        {
            return response()->json(['success' => false, 'message' => 'Authentication Failed'], 401)->header('status', 401);
        }
    }

    // To get the details of the particular address

    public function viewAddress(Request $request)
    {
        $validator = Validator::make($request->all(), [ 
            'id' => 'required|integer|exists:addresses',
        ]);
        if ($validator->fails()) 
        { 
            return response()->json(['errors'=>$validator->errors()], 403);            
        }
        $address = Address::where('id',$request->id)->with('getShipping')->first();
        if($address)
        {
            $data['address']['id'] = $address['id'];
            $data['address']['address'] = $address['address'];
            $data['address']['user_id'] = $address['user_id'];
            $data['address']['city'] = $address['city'];
            $data['address']['pincode'] = $address['pincode'];
            $data['address']['country'] = $address['country'];
            $data['address']['country_code'] = $address['country_code'];
            $data['address']['is_default'] = $address['is_default'];
            $data['address']['shipping'] = $address['getShipping'];

            return response()->json(["success" => true, "message" => 'Address Detail.',"data"=> $data], 200);
        }else
        {
            return response()->json(['success' => false, 'message' => 'No Coupon'], 202)->header('status', 202);
        }
    }

}
