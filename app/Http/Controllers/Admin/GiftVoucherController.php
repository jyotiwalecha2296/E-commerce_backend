<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\GiftVoucher;
use Illuminate\Support\Facades\File;


class GiftVoucherController extends Controller
{
    public function index()
    {
        $data = GiftVoucher::orderBy('id','DESC')->get(); 
        return view("admin.gift-voucher.index")->with('data',$data);
       
    }

    public function create()
    {
        return view("admin.gift-voucher.create");
    }

    public function store(Request $request)
    {
        $validator = \Validator::make($request->all(), [
                    'code'=>'required|unique:gift_vouchers,code',
                    'discount_amount'=>'required',
                    'expire_at'=>'required|date_format:Y-m-d|after:today',    
        ]);
        
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        if($request->hasFile('voucher_image')){
          $filenameWithExt = $request->file('voucher_image')->getClientOriginalName();
          $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
          $extension = $request->file('voucher_image')->getClientOriginalExtension();
          $fileNameToStore=$filename.'.'.$extension;
          $path = $request->file('voucher_image')->move('public/voucher_image/', $fileNameToStore);
          $uploadImage= $path;
          }else{
            $uploadImage= '';
          }
     
        $vouchers = new GiftVoucher;
        $vouchers->code = $request->code;       
        $vouchers->discount_amount =  $request->discount_amount;
        $vouchers->expires_at = $request->expire_at;
        $vouchers->status = $request->status;
        $vouchers->description = $request->description;
        $vouchers->image = $uploadImage;
        $vouchers->save();

        return redirect()->to('gift-vouchers')->with('success', 'Gift Voucher created successfully.');
    }

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
         $data=GiftVoucher::where('id',$id)->first();
         return view("admin.gift-voucher.edit")->with('data', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {;
        $validator = \Validator::make($request->all(), [
                    'code' => 'required|unique:gift_vouchers,code,' . $id, 
                    'discount_amount'=>'required',
                    'expires_at'=>'required|date_format:Y-m-d',
        ]);
        if($validator->fails()) 
        {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        if($request->hasFile('voucher_image')){
          $filenameWithExt = $request->file('voucher_image')->getClientOriginalName();
          $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
          $extension = $request->file('voucher_image')->getClientOriginalExtension();
          $fileNameToStore=$filename.'.'.$extension;
          $path = $request->file('voucher_image')->move('public/voucher_image/', $fileNameToStore);
          $uploadImage= $path;
          if(File::exists($request->old_voucher_image)) 
            {
                File::delete($request->old_voucher_image);
            }
          }

           
        $voucher = GiftVoucher::findOrFail($id);
        $voucher->code = $request->code;
        $voucher->discount_amount =  $request->discount_amount;
        $voucher->expires_at = $request->expires_at;      
        $voucher->status=$request->status;
        $voucher->description = $request->description;
        if($request->hasFile('voucher_image'))
        {
            $voucher->image = $uploadImage;
        }
        $voucher->save();

       return redirect()->to('gift-vouchers')->with('success', 'Gift Voucher Updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $giftVoucher = GiftVoucher::where('id',$id)->first();
        if($giftVoucher)
        {
            if(File::exists($giftVoucher->image)) 
            {
                File::delete($giftVoucher->image);
            }
            $giftVoucher->delete();
            return redirect()->to('gift-vouchers')->with('success', 'Gift Voucher has been deleted Successfully!.');
        }else
        {
            return response()->json(['success' => false, 'message' => 'No Voucher'], 202)->header('status', 202);
        }
    }
}
