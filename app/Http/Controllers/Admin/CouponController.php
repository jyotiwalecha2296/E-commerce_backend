<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Coupon;
class CouponController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data=Coupon::orderBy('id','DESC')->get(); 
        return view("admin.coupons.index")->with('data',$data);
       
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("admin.coupons.create");
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
                    'code'=>'required|unique:coupons,code',
                    'discount_percentage'=>'required',
                    'start_date'=>'required|date_format:Y-m-d|after:today',   
                    'end_date'=>'required|date_format:Y-m-d|after:today',                    
                    'status'=>'required',  
                    'minimum_amount' =>'required'    
        ]);
        
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
     
        $coupon = new Coupon;
        $coupon->code = $request->code;       
        $coupon->discount_percentage =  $request->discount_percentage;
        $coupon->description = $request->description;
        $coupon->coupon_limit = $request->coupon_limit; 
        $coupon->minimum_amount = $request->minimum_amount;
        $coupon->start_date = $request->start_date;        
        $coupon->end_date = $request->end_date;        
        $coupon->status=$request->status;
        $coupon->save();
    


        return redirect()->to('coupons')->with('success', 'Coupon created successfully.');
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
    public function edit($id){
         $data=Coupon::where('id',$id)->first();
         return view("admin.coupons.edit")->with('data', $data);
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
                    'code' => 'required|unique:coupons,code,' . $id, 
                    'discount_percentage'=>'required',
                    'start_date'=>'required|date_format:Y-m-d',   
                    'end_date'=>'required|date_format:Y-m-d|after:today',                     
                    'status'=>'required',
        ]);
        if($validator->fails()) 
        {
            return redirect()->back()->withErrors($validator)->withInput();
        }
           
        $coupon = Coupon::findOrFail($id);
        $coupon->code = $request->code;
        $coupon->discount_percentage =  $request->discount_percentage;
        $coupon->description = $request->description;
        $coupon->coupon_limit = $request->coupon_limit; 
        $coupon->minimum_amount = $request->minimum_amount; 
        $coupon->start_date = $request->start_date;        
        $coupon->end_date = $request->end_date;        
        $coupon->status=$request->status;
        $coupon->save();

       return redirect()->to('coupons')->with('success', 'Coupon Updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Coupon::where('id',$id)->delete();
        return redirect()->to('coupons')->with('success', 'Coupon has been deleted Successfully!.');
    }
}
