<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Order;  
use App\Models\User;
use App\Models\Product;
use Illuminate\Support\Facades\Redirect;
class WidgetsServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer('admin.layouts.common.title', function($view) {
  
        
            $this->order_count = Order::count();
            $this->user_count = User::count();
            $this->product_count = Product::where('parent_id','0')->count();
           
            $view->with(['order_count' => $this->order_count,'user_count' => $this->user_count,'product_count' => $this->product_count]);

        });
    }
}
