<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth; 
use App\Models\Order;
use App\Models\Coupon;
use App\Models\OrderItem;
use App\Models\User;
use App\Models\Product;

class OrderController extends Controller
{

    // to save the  order
    public function addOrder(Request $request)
    {
        $validator = Validator::make($request->all(), [ 
            'user_id' => 'required|integer',
            'sub_total' => 'required|numeric',
            'final_total' => 'required|numeric',
            'shipping_charges' => 'required',
            'shipping_method' => 'required',
            'payment_method' => 'required',
            'status' => 'required|in:pending,processing,completed,decline',
            'order_items' =>'required',
        ]);
        if ($validator->fails()) 
        { 
             return response()->json(['errors'=>$validator->errors()], 403);            
        }
        $userid = $request->user_id;
        $user = User::where('id',$userid)->first();
        if($user)
        {
            $today = date("Ymd");
            $rand = strtoupper(substr(uniqid(sha1(time())),0,4));
            $unique = $today . $rand;
            // $unique_id = time() . mt_rand() . $userid;
            if(isset($request->coupon_code))
            {
                $coupon_code = $request->coupon_code;
            }else
            {
                $coupon_code = '';
            }
            if(isset($request->description))
            {
                $description = $request->description;
            }else
            {
                $description = '';
            }
            if(isset($request->coupon_amount))
            {
                $coupon_amount = $request->coupon_amount;
            }else
            {
                $coupon_amount = '';
            }
            if(isset($request->voucher_amount))
            {
                $voucher_amount = $request->voucher_amount;
            }else
            {
                $voucher_amount = '';
            }
            if(isset($request->voucher_code))
            {
                $voucher_code = $request->voucher_code;
            }else
            {
                $voucher_code = '';
            }

            $order = Order::create([
                'user_id' => $userid,
                'order_id' => $unique,
                'customer_name' => $user->name,
                'customer_email' => $user->email,
                'customer_phone' => $user->contact_no,
                'sub_total' => $request->sub_total,
                'final_total' => $request->final_total,
                'coupon_code' => $coupon_code,
                'voucher_amount' => $voucher_amount,
                'voucher_code' => $voucher_code,
                'description' => $description,
                'coupon_amount' => $coupon_amount,
                'shipping_charges' => $request->shipping_charges,
                'shipping_method' => $request->shipping_method,
                'payment_method' => $request->payment_method,
                'status' => $request->status,
            ]); 

            foreach($request->order_items as $order_item)
            {
                $product = Product::where('item_code',$order_item['item_code'])->first();
                if($product)
                {
                    $total = $order_item['quantity'] * $product->Price;

                    $orderItems = OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $product->id,
                        'product_name' => $product->name,
                        'product_price' => $product->Price,
                        'product_image' => $product->featured_image,
                        'quantity' => $order_item['quantity'],
                        'total' => $total,
                        'status' => 'pending',
                    ]);
                    if($product->stock != null)
                    {
                        $stock = $product->stock - $order_item['quantity'];
                        $product = Product::where('item_code',$order_item['item_code'])->update([
                                'stock' => $stock
                        ]);
                    }else{
                        $response = ["message" =>'Empty stock'];
                            return response($response, 202);
                    }
                }else{
                    $response = ["message" =>'Product Not Found'];
                            return response($response, 202);
                }
            }
            $data = Order::Where('id',$order->id)->with('getOrderItem.getProduct','getUser.getAddress')->first();
            return response()->json(["success" => true, "message" => 'Order saved Successfully.',"data"=> $data], 200);
        }else
        {
            $response = ["message" =>'User does not exist'];
            return response($response, 202);
        }    
    }

    // to view the detail of the particular order

    public function viewOrder(Request $request)
    {
        $validator = Validator::make($request->all(), [ 
        'order_id'=>'required|integer',
        ]);
        if ($validator->fails()) 
        { 
            return response()->json(['errors'=>$validator->errors()], 403);            
        }
        $order = Order::Where('id',$request->order_id)->with('getOrderItem.getProduct','getUser.getAddress')->first();
        return response()->json(["success" => true, "message" => 'Order Detail.',"data"=> $order], 200);
    }

    // to get the list of the login user order list

    public function orderList(Request $request)
    {
        $orders =[];
        if(Auth::check())
        {
            $orders = Order::Where('user_id',Auth::id())->with('getOrderItem.getProduct','getUser.getAddress')->get();
            return response()->json(["success" => true, "message" => 'Order List.',"data"=> $orders], 200);
        }else
        {
            return response()->json(['success' => false, 'message' => 'Authentication Failed'], 401)->header('status', 401);
        }
    }

    // to get the list of the coupons

    public function couponList(Request $request)
    {
        $data=[];
        $coupons = Coupon::latest()->get();
        if($coupons!= null)
        {
            foreach($coupons as $k=>$coupon)
            {
              $data[$k]['id'] = $coupon->id;
              $data[$k]['code'] = $coupon->code;
              $data[$k]['discount_percentage'] = $coupon->discount_percentage;
              $data[$k]['description'] = $coupon->description;
              $data[$k]['minimum_amount'] = $coupon->minimum_amount;
              $data[$k]['start_date'] = $coupon->start_date;
              $data[$k]['end_date'] = $coupon->end_date;
              $data[$k]['status'] = $coupon->status;
            }
          return response()->json(['success' => true,'data'=>$data], 200)->header('status', 200); 
        }else
        {
            return response()->json(['success' => false, 'message' => 'No Coupon'], 202)->header('status', 202);
        }
    }

    // apply the particular coupon

    public function applyCoupon(Request $request)
    {
        $validator = Validator::make($request->all(), [ 
            'code' => 'required|exists:coupons',
            'total_amount' => 'required|numeric',
        ]);
        if ($validator->fails()) 
        { 
             return response()->json(['errors'=>$validator->errors()], 403);            
        }
        $Coupon = Coupon::Where('code',$request->code)->first();
        if($Coupon)
        {
            $start_date = strtotime($Coupon->start_date);
            $end_date = strtotime($Coupon->end_date);
            $today = strtotime(date('Y-m-d'));
            if($start_date <= $today && $today <= $end_date)
            {
                if($request->total_amount >= $Coupon->minimum_amount)
                {
                    $amount = $request->total_amount*$Coupon->discount_percentage/100;
                    $data=[];
                    $data['coupon']['code']= $Coupon->code;
                    $data['coupon']['discount_percentage']= $Coupon->discount_percentage;
                    $data['final_amount']= $amount;
                    return response()->json(['success' => true,'data'=>$data], 200)->header('status', 200); 

                }else
                {
                    return response()->json(['success' => false, 'message' => 'Minimum Amount Should be '.$Coupon->minimum_amount], 202)->header('status', 403);
                }

            }else
            {
                return response()->json(['success' => false, 'message' => 'Invalid Coupon'], 202)->header('status', 202);
            }
        }else
        {
            return response()->json(['success' => false, 'message' => 'Coupon not exist'], 202)->header('status', 202);
        }
    }
    public function viewCoupon(Request $request)
    {
        $validator = Validator::make($request->all(), [ 
            'id' => 'required|exists:coupons',
        ]);
        if ($validator->fails()) 
        { 
             return response()->json(['errors'=>$validator->errors()], 403);            
        }
        $Coupon = Coupon::Where('id',$request->id)->first();
        if($Coupon)
        {
                
            return response()->json(['success' => true,'data'=>$Coupon], 200)->header('status', 200); 
        }else
        {
            return response()->json(['success' => false, 'message' => 'Coupon not exist'], 202)->header('status', 202);
        }
    }
}
