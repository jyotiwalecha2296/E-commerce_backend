@extends('admin.layouts.app') 
@section('content')
  <div class="container-fluid pt-5">
    <style>
 
/* Style the tab */
.tab {
  overflow: hidden;
  border: 1px solid #ccc;
  background-color: #f1f1f1;
}

/* Style the buttons inside the tab */
.tab button {
  background-color: inherit;
  float: left;
  border: none;
  outline: none;
  cursor: pointer;
  padding: 14px 16px;
  transition: 0.3s;
  font-size: 17px;
}

/* Change background color of buttons on hover */
.tab button:hover {
  background-color: #ddd;
}

/* Create an active/current tablink class */
.tab button.active {
  background-color: #ccc;
}

/* Style the tab content */
.tabcontent {
  display: none;
  padding: 6px 12px;
  border: 1px solid #ccc;
  border-top: none;
}
</style>

    <span class="title-data" id="titleData" data-link="users/view" data-parent="users" data-title="View User Details"></span>
    
    
      <div class="row"> 

        <div class="col-lg-3 col-md-3 col-sm-7">
         <div class="card"> 

          <div class="profile_div mb-3">
            <div class="text-center">
               <img src="{{asset($data->image ?: 'public/images/user.png')}}" height="75" width="100">
               <h4>{{$data->first_name}} {{$data->last_name}} </h4>
            </div>           
            
            <p><b>First Name : </b><span  class="text-end">{{$data->first_name}} </span></p>
            <p><b>Last Name : </b> <span>{{$data->last_name}} </span></p>           
            <p><b>Email : </b> <span>{{$data->email}}</span></p>
            <p><b>Phone : </b> <span>{{$data->country_code}}{{$data->contact_no}} </span></p>
            <p><b>Status : </b> <span>@if($data->user_status=="1") Active @else Inactive @endif</span></p>
          </div>
          
          </div> 
        </div>

        <div class="col-lg-9 col-md-9 col-sm-5">     
          <div class="card">


            <div class="tab">
              <button class="tablinks active" onclick="openCity(event, 'order')">Orders</button>
              <button class="tablinks" onclick="openCity(event, 'address')">Address</button>
              <button class="tablinks" onclick="openCity(event, 'wishlist')">Wishlist Items</button>
              <button class="tablinks" onclick="openCity(event, 'cart')">Cart Items</button>
            </div>

            <!-- View order section -->
            <div id="order" class="tabcontent"  style="display: block;">               
               @if($orders->count() > 0) 
               <table class="table table-striped dataTable table-hover no-footer">
                  <thead>
                    <tr>
                      <th>Order Id</th>
                      <th>Order Date</th>
                      <th>Order Time</th>
                      <th>Order Status</th>
                      <th>Payment Method</th>
                      <th>Total</th>
                    </tr>
                  </thead>

                  <tbody>
                    @foreach($orders as $order)
                    <tr>
                      <td>{{$order->order_id}}</td>
                      <td>{{ $order->created_at->format('d/m/Y') }}</td>
                      <td>{{$order->created_at->format('H:i:s') }}</td>
                      <td>{{$order->status}}</td>
                      <td>{{$order->payment_method}}</td>
                      <td>${{$order->final_total}} </td>
                    </tr> 
                    @endforeach                   
                  </tbody>
              </table>
              @else
               <br/><br/>
               <h6 align="center">No Order Yet</h6>
               <br/><br/>
              @endif
            </div>

            <!-- Addresses  -->
            <div id="address" class="tabcontent">                
                 @if($addresses->count() > 0) 
                 <table class="table table-striped dataTable table-hover no-footer">
                  <thead>
                    <tr>
                      <th>Address</th>
                      <th>City</th>
                      <th>Pincode</th>
                      <th>Country</th>                     
                    </tr>
                  </thead>

                  <tbody>
                    @foreach($addresses as $address_data)
                    <tr>
                      <td>{{$address_data->address}}</td>
                      <td>{{$address_data->city }}</td>
                      <td>{{$address_data->pincode }}</td>
                      <td>{{$address_data->country}}</td>                       
                    </tr> 
                    @endforeach                   
                  </tbody>
              </table>
              @else
              <br/><br/>
               <h6 align="center">No Address Yet</h6>
               <br/><br/>
              @endif
            </div>

            <div id="wishlist" class="tabcontent">
               @if($wishlists->count() > 0) 
                 <table class="table table-striped dataTable table-hover no-footer">
                    <thead>
                      <tr>                      
                        <th>Image</th>
                        <th>Product Name</th>
                        <th>Price</th>
                        <th>Color</th>  
                        <th>Type</th>  
                        <th>Item Code</th>                     
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($wishlists as $wishlist_data)
                      <tr>
                        <td><img src="{{asset($wishlist_data->featured_image ?: 'public/watch_placeholder.png')}}" height="103" width="70"></td>
                        <td>{{$wishlist_data->name}}</td>                      
                        <td>${{$wishlist_data->Price }}</td>
                        <td>{{$wishlist_data->color }}</td>
                        <td>{{$wishlist_data->product_line_type}}</td>
                        <td>{{$wishlist_data->item_code}}</td>                       
                      </tr> 
                      @endforeach                   
                    </tbody>
                </table>
               @else
                 <br/><br/>
                 <h6 align="center">No Item In Wishlist Yet</h6>
                 <br/><br/>
               @endif
            </div>

              <div id="cart" class="tabcontent">               
               @if($carts->count() > 0) 
                 <table class="table table-striped dataTable table-hover no-footer">
                    <thead>
                      <tr>                      
                        <th>Image</th>
                        <th>Product Name</th>
                        <th>Price</th>
                        <th>Color</th>  
                        <th>Type</th>  
                        <th>Item Code</th>    
                        <th>Quantity</th>                 
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($carts as $cart_data)
                      <tr>
                        <td><img src="{{asset($cart_data->featured_image ?: 'public/watch_placeholder.png')}}" height="103" width="70"></td>
                        <td>{{$cart_data->name}}</td>                      
                        <td>${{$cart_data->Price }}</td>
                        <td>{{$cart_data->color }}</td>
                        <td>{{$cart_data->product_line_type}}</td>
                        <td>{{$cart_data->item_code}}</td>     
                        <td>{{$cart_data->quantity}}</td>                  
                      </tr> 
                      @endforeach                   
                    </tbody>
                </table>
               @else
                 <br/><br/>
                 <h6 align="center">No Item In Cart Yet</h6>
                 <br/><br/>
               @endif
              </div>			 
          </div>      
        </div>
         
 
      </div>
  </div>
   <script>
function openCity(evt, cityName) {
  var i, tabcontent, tablinks;
  tabcontent = document.getElementsByClassName("tabcontent");
  for (i = 0; i < tabcontent.length; i++) {
    tabcontent[i].style.display = "none";
  }
  tablinks = document.getElementsByClassName("tablinks");
  for (i = 0; i < tablinks.length; i++) {
    tablinks[i].className = tablinks[i].className.replace(" active", "");
  }
  document.getElementById(cityName).style.display = "block";
  evt.currentTarget.className += " active";
}
</script>
@endsection