<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request; 
use App\Models\Shipping;
use App\Models\CountryCode;
class ShippingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Shipping::all();
        return view("admin.shipping.index")->with('data',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){
        $countrycode=CountryCode::all();
        return view("admin.shipping.create")->with('countrycode',$countrycode);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){    


       $validator = \Validator::make($request->all(), [
                    'country_code'=>'required|unique:shipping,country_code',
                    'shipping_charges'=>'required',                                     
                    'status'=>'required' 
                  ]);    
        
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $country=CountryCode::where('code',$request->country_code)->value('country_name');

        $savedata = new Shipping;
        $savedata->country = $country;       
        $savedata->country_code =  $request->country_code;
        $savedata->shipping_charges = $request->shipping_charges;
        $savedata->status=$request->status;
        $savedata->save();

        return redirect()->to('shipping')->with('success', 'Shipping created successfully.');
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
         $data=Shipping::where('id',$id)->first();
         $countrycode=CountryCode::all();
         return view("admin.shipping.edit")->with('data', $data)->with('countrycode',$countrycode);
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
                    'country_code' => 'required|unique:shipping,country_code,' . $id, 
                    'shipping_charges'=>'required',                                     
                    'status'=>'required' 
        ]);
        if($validator->fails()) 
        {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $country=CountryCode::where('code',$request->country_code)->value('country_name');

        $savedata = Shipping::findOrFail($id);
        $savedata->country = $country;       
        $savedata->country_code =  $request->country_code;
        $savedata->shipping_charges = $request->shipping_charges;
        $savedata->status=$request->status;
        $savedata->save();
       return redirect()->to('shipping')->with('success', 'Shipping Updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       Shipping::where('id',$id)->delete();
        return redirect()->to('shipping')->with('success', 'Shipping has been deleted Successfully!.');
    }
}
