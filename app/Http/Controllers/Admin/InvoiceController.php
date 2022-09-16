<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use PDF;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Setting;
class InvoiceController extends Controller
{
    public function invoice(Request $request, $id){
        $order_data=Order::where('order_id',$id)->first();
        $order_item_data=OrderItem::where('order_id',$order_data->id)->get();
        $setting=Setting::first();
        $data =['order_id' => $order_data->order_id,
		        'customer_name' => $order_data->customer_name,
		        'customer_phone' => $order_data->customer_phone,
		        'customer_email' => $order_data->customer_email,		         
		        'sub_total' => $order_data->sub_total, 
		        'final_total' => $order_data->final_total,
		        'coupon_code' => $order_data->coupon_code,
		        'coupon_amount' => $order_data->coupon_amount,
		        'shipping_charges' => $order_data->shipping_charges,
		        'shipping_method' => $order_data->shipping_method,
		        'payment_method' => $order_data->payment_method,
		        'status' => $order_data->status ,
		        'order_date' => $order_data->created_at,
                'order_time' => $order_data->created_at,
                'logo' => asset($setting->application_blue_logo)                    
		       ];
       $data = compact('data','order_item_data');

       view()->share('pdf.invoice', compact('data'));
 
       $pdf = PDF::loadView('pdf.invoice', $data)->setOptions(['defaultFont' => 'sans-serif','isRemoteEnabled' => true,'isPhpEnabled' => true]);
       // $pdf->setPaper('A4', 'landscape');
     
       return $pdf->download('invoice.pdf');




        

    }
}
