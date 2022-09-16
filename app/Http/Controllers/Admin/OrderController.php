<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        $data=Order::orderBy('id','DESC')->get(); 
        $pending_orders=Order::join('users', 'users.id', '=', 'orders.user_id')->where('orders.status','pending')->orderBy('orders.id','DESC')->get();
        $processing_orders=Order::join('users', 'users.id', '=', 'orders.user_id')->where('orders.status','processing')->orderBy('orders.id','DESC')->get();
        $completed_orders=Order::join('users', 'users.id', '=', 'orders.user_id')->where('orders.status','completed')->orderBy('orders.id','DESC')->get();
        $decline_orders=Order::join('users', 'users.id', '=', 'orders.user_id')->where('orders.status','decline')->orderBy('orders.id','DESC')->get();
        $deleted_orders=Order::onlyTrashed()->get();

        return view("admin.orders.index")->with('data',$data)
                                         ->with('pending_orders',$pending_orders)
                                         ->with('processing_orders',$processing_orders)
                                         ->with('completed_orders',$completed_orders)
                                         ->with('decline_orders',$decline_orders)
                                         ->with('deleted_orders',$deleted_orders);
       
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id){                
        $order_data=Order::where('order_id',$id)->first();
        $order_item_data=OrderItem::where('order_id',$order_data->id)->get();
        return view('admin.orders.show')->with('order_data',$order_data)->with('order_item_data',$order_item_data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
       $order_data=Order::where('order_id',$id)->first();
        $order_item_data=OrderItem::where('order_id',$order_data->id)->get();
        return view('admin.orders.edit')->with('order_data',$order_data)->with('order_item_data',$order_item_data);
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      $oid=Order::where('order_id',$id)->value('id');
      OrderItem::where('order_id',$oid)->delete();
      Order::where('order_id',$id)->delete();
      return redirect()->to('orders')->with('success', 'Order has been deleted Successfully!.');
    
    }

    public function updateOrderStatus(Request $request){
      
    	$id=Order::where('order_id',$request->order_id)->value('id');
        $updateorder = Order::find($id);
        $updateorder->status = $request->order_status;                    
        $updateorder->save();

        $order_item_data=OrderItem::where('order_id',$id)->get();
        foreach($order_item_data as $orderitemdata){
        $updateorderitem = OrderItem::find($orderitemdata->id);
        $updateorderitem->status = $request->order_status;                    
        $updateorderitem->save();
        }
    	return response()->json(['success'=>true,'message'=>'Order Status Updated Successfully']);
    }
}
