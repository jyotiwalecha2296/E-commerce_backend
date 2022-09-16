<?php
  
namespace App\Http\Controllers;
 
use Illuminate\Http\Request;
use App\Models\Order;  
use App\Models\User;
use App\Models\Product;
class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
  
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function profile()
    {
        return view('admin.profile');
    } 
    
    
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function adminHome(){
      $order_data = Order::join('users', 'users.id', '=', 'orders.user_id')->orderBy('orders.id','DESC')->limit(10)->get();
     
      $product_data=Product::where('parent_id','0')->orderBy('id','DESC')->limit(10)->get();
      return view('admin.adminhome')->with('order_data',$order_data)
                                    ->with('product_data',$product_data);
    }

     
}