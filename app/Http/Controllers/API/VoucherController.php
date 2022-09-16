<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\GiftVoucher;
use App\Models\SendVoucher;
use App\Models\PurchaseVoucher;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth; 

class VoucherController extends Controller
{
    public function voucherList()
    {
        $data=[];
        $vouchers = GiftVoucher::latest()->get();
        if($vouchers!= null)
        {
            foreach($vouchers as $k=>$voucher)
            {
              $data[$k]['id'] = $voucher->id;
              $data[$k]['code'] = $voucher->code;
              $data[$k]['discount_amount'] = $voucher->discount_amount;
              $data[$k]['description'] = $voucher->description;
              $data[$k]['expires_at'] = $voucher->expires_at;
              $data[$k]['image'] = $voucher->image;
              $data[$k]['status'] = $voucher->status;
            }
          return response()->json(['success' => true,'data'=>$data], 200)->header('status', 200); 
        }else
        {
            return response()->json(['success' => false, 'message' => 'No Voucher'], 202)->header('status', 202);
        }
    }

    public function ViewVoucher(Request $request)
    {
        $validator = Validator::make($request->all(), [ 
        'voucher_id'=>'required|integer',
        ]);
        if ($validator->fails()) 
        { 
            return response()->json(['errors'=>$validator->errors()], 403);            
        }
        $Voucher = GiftVoucher::Where('id',$request->voucher_id)->first();
        if($Voucher)
        {
            return response()->json(["success" => true, "message" => 'Gift-Voucher Detail.',"data"=> $Voucher], 200);
        }else
        {
            return response()->json(['success' => false, 'message' => 'No Voucher'], 202)->header('status', 202);
        }
    }

    public function purchaseVoucher(Request $request)
    {
        $validator = Validator::make($request->all(), [ 
        'voucher_id'=>'required|integer',
        ]);
        if ($validator->fails()) 
        { 
            return response()->json(['errors'=>$validator->errors()], 403);            
        }
        if(Auth::check())
        {
            $voucher = GiftVoucher::Where('id',$request->voucher_id)->first();
            if($voucher)
            {
                $purchaseVoucher = PurchaseVoucher::create([
                    'user_id' => Auth::id(),
                    'voucher_id' => $request->voucher_id,
                    'voucher_actual_amount' => $voucher->discount_amount,
                    'status' => 1,
                ]);
                return response()->json(["success" => true, "message" => 'Voucher Purchase Successfully.',"data"=> $purchaseVoucher], 200);
            }else
            {
                return response()->json(['success' => false, 'message' => 'No Voucher'], 202)->header('status', 202);
            }
        }else
        {
            return response()->json(['success' => false, 'message' => 'Authentication Failed'], 401)->header('status', 401);
        }
    }

    public function sendVoucher(Request $request)
    {
        $validator = Validator::make($request->all(), [ 
        'voucher_id'=>'required|integer',
        'receiver_email'=>'required|email',
        ]);
        if ($validator->fails()) 
        { 
            return response()->json(['errors'=>$validator->errors()], 403);            
        }
        if(Auth::check())
        {
            $voucher = GiftVoucher::Where('id',$request->voucher_id)->first();
            if($voucher)
            {
                if($request->receiver_id)
                {
                    $receiver_id = $request->receiver_id;
                }else
                {
                    $receiver_id = null;
                }
                 $sendVoucher = SendVoucher::create([
                    'sender_id' => Auth::id(),
                    'voucher_id' => $request->voucher_id,
                    'receiver_id' => $receiver_id,
                    'receiver_email' => $request->receiver_email,
                    'status' => 1,
                ]);
                return response()->json(["success" => true, "message" => 'Voucher Send Successfully.',"data"=> $sendVoucher], 200);
            }else
            {
                return response()->json(['success' => false, 'message' => 'No Voucher'], 202)->header('status', 202);
            }
        }else
        {
            return response()->json(['success' => false, 'message' => 'Authentication Failed'], 401)->header('status', 401);
        }
    }

    public function purchasedVoucher()
    {
        if(Auth::check())
        {
            $myVouchers = PurchaseVoucher::where('user_id',Auth::id())->with('getVoucher')->get();
            $data =[];
            if($myVouchers)
            {
                foreach($myVouchers as $k=>$voucher)
                {
                    $data[$k]['id'] = $voucher->id;
                    $data[$k]['user_id'] = $voucher->user_id;
                    $data[$k]['voucher_id'] = $voucher->voucher_id;
                    $data[$k]['status'] = $voucher->status;
                    $data[$k]['code'] = $voucher->getVoucher->code;
                    $data[$k]['discount_amount'] = $voucher->getVoucher->discount_amount;
                    $data[$k]['expires_at'] = $voucher->getVoucher->expires_at;
                    $data[$k]['image'] = $voucher->getVoucher->image;
                    $data[$k]['description'] = $voucher->getVoucher->description;
                }
                return response()->json(["success" => true, "message" => 'My Gift Voucher.',"data"=> $data], 200);
            }else
            {
                return response()->json(['success' => false, 'message' => 'No Voucher'], 202)->header('status', 202);
            }
        }else
        {
            return response()->json(['success' => false, 'message' => 'Authentication Failed'], 401)->header('status', 401);
        }
    }

    public function sendVoucherList()
    {
         if(Auth::check())
        {
            $myVouchers = SendVoucher::where('sender_id',Auth::id())->with('getVoucher')->get();
            $data =[];
            if($myVouchers)
            {
                foreach($myVouchers as $k=>$voucher)
                {
                    $data[$k]['id'] = $voucher->id;
                    $data[$k]['sender_id'] = $voucher->sender_id;
                    $data[$k]['receiver_id'] = $voucher->receiver_id;
                    $data[$k]['receiver_email'] = $voucher->receiver_email;
                    $data[$k]['voucher_id'] = $voucher->voucher_id;
                    $data[$k]['status'] = $voucher->status;
                    $data[$k]['code'] = $voucher->getVoucher->code;
                    $data[$k]['discount_amount'] = $voucher->getVoucher->discount_amount;
                    $data[$k]['expires_at'] = $voucher->getVoucher->expires_at;
                    $data[$k]['image'] = $voucher->getVoucher->image;
                    $data[$k]['description'] = $voucher->getVoucher->description;
                }
                return response()->json(["success" => true, "message" => 'My Voucher Send List.',"data"=> $data], 200);
            }else
            {
                return response()->json(['success' => false, 'message' => 'No Voucher'], 202)->header('status', 202);
            }
        }else
        {
            return response()->json(['success' => false, 'message' => 'Authentication Failed'], 401)->header('status', 401);
        }
    }

    public function receivedVoucherList()
    {
        if(Auth::check())
        {
            $myVouchers = SendVoucher::where('receiver_email',Auth::user()->email)->with('getVoucher')->get();
            $data =[];
            if($myVouchers)
            {
                foreach($myVouchers as $k=>$voucher)
                {
                    $data[$k]['id'] = $voucher->id;
                    $data[$k]['sender_id'] = $voucher->sender_id;
                    $data[$k]['receiver_id'] = $voucher->receiver_id;
                    $data[$k]['receiver_email'] = $voucher->receiver_email;
                    $data[$k]['voucher_id'] = $voucher->voucher_id;
                    $data[$k]['status'] = $voucher->status;
                    $data[$k]['code'] = $voucher->getVoucher->code;
                    $data[$k]['discount_amount'] = $voucher->getVoucher->discount_amount;
                    $data[$k]['expires_at'] = $voucher->getVoucher->expires_at;
                    $data[$k]['image'] = $voucher->getVoucher->image;
                    $data[$k]['description'] = $voucher->getVoucher->description;
                }
                return response()->json(["success" => true, "message" => 'My Voucher Received List.',"data"=> $data], 200);
            }else
            {
                return response()->json(['success' => false, 'message' => 'No Voucher'], 202)->header('status', 202);
            }
        }else
        {
            return response()->json(['success' => false, 'message' => 'Authentication Failed'], 401)->header('status', 401);
        }
    }

    public function applyVoucher(Request $request)
    {
        $validator = Validator::make($request->all(), [ 
        'code'=>'required|exists:gift_vouchers',
        'total_amount'=>'required|numeric',
        ]);
        if ($validator->fails()) 
        { 
            return response()->json(['errors'=>$validator->errors()], 403);            
        }
        if(Auth::check())
        {
            $data=[];
            $voucher = GiftVoucher::Where('code',$request->code)->first();
            if($voucher)
            {
                $myvoucher = PurchaseVoucher::where('voucher_id',$voucher->id)->where('user_id',Auth::id())->first();
                $sendvoucher = SendVoucher::where('voucher_id',$voucher->id)->where('receiver_id',Auth::id())->first();
                if($myvoucher && $myvoucher->voucher_actual_amount != 0)
                {
                    if($request->total_amount > $myvoucher->voucher_actual_amount)
                    {
                        $amount = $request->total_amount - $myvoucher->voucher_actual_amount;
                        $remaining_amount = 0;
                    }elseif($request->total_amount < $myvoucher->voucher_actual_amount)
                    {
                        $amount = 0;
                        $remaining_amount = $myvoucher->voucher_actual_amount- $request->total_amount;
                    }

                    $myvoucher = PurchaseVoucher::where('voucher_id',$voucher->id)->where('user_id',Auth::id())->update([
                        'voucher_actual_amount' => $remaining_amount
                    ]);
                }elseif($sendvoucher)
                {
                    $isvalid = PurchaseVoucher::where('voucher_id',$sendvoucher->voucher_id)->where('user_id',$sendvoucher->sender_id)->first();
                    if($isvalid)
                    {
                        if($request->total_amount > $isvalid->voucher_actual_amount)
                        {
                            $amount = $request->total_amount - $isvalid->voucher_actual_amount;
                            $remaining_amount = 0;
                        }elseif($request->total_amount < $isvalid->voucher_actual_amount)
                        {
                            $amount = 0;
                            $remaining_amount = $isvalid->voucher_actual_amount- $request->total_amount;
                        }

                        $isvalid = PurchaseVoucher::where('voucher_id',$sendvoucher->voucher_id)->where('user_id',$sendvoucher->sender_id)->update([
                            'voucher_actual_amount' => $remaining_amount
                        ]);

                    }else
                    {
                        return response()->json(['success' => false, 'message' => 'Gift Voucher not Valid'], 403)->header('status', 403);
                    }
                }else
                {
                    $amount =$request->total_amount;
                    $remaining_amount = 0;
                }
                    $data['voucher']['code']= $voucher->code;
                    $data['voucher']['discount_percentage']= $voucher->discount_amount;
                    $data['amount_after_discount']= $amount;
                    $data['remaining_voucher_amount']= $remaining_amount;
                    return response()->json(['success' => true,'data'=>$data], 200)->header('status', 200); 
            }else
            {
                return response()->json(['success' => false, 'message' => 'No Voucher'], 202)->header('status', 202);
            }
        }else
        {
            return response()->json(['success' => false, 'message' => 'Authentication Failed'], 401)->header('status', 401);
        }
    }
}
