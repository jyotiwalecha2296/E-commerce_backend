@extends('admin.layouts.app') 
@section('content')
<div class="container-fluid pt-3">
  <span class="title-data" id="titleData" data-link="orders" data-parent="" data-title="View Order"></span> 
  @if (session('success'))
  <div class="alert alert-success">
    {{ session('success') }}
  </div>
  @endif
  <div class="row">
    <div class="card"> 

      <div class="row">            
        <div class="col-sm-6 form-group mb-4">
          <div class="view_page card">
            <div class="view_data">        
              <p><b>Customer name : </b><span>{{$order_data->customer_name}}</span></p>                             
              <p><b>Customer email : </b><span>{{$order_data->customer_email}}</span></p>                             
              <p><b>Customer phone : </b><span>{{$order_data->customer_phone}}</span></p>                               
            </div>
          </div>                      
        </div>
        <div class="col-sm-6 form-group mb-4">
          <div class="view_page card">
            <div class="view_data">
              <p><b>Order Id:-</b><span>{{$order_data->order_id}}</span></p>                           
              <p><b>Order Date:-</b><span>{{$order_data->created_at}}</span></p>                             
              <p><b>Order Time:-</b><span>{{$order_data->created_at}}</span></p> 
              <p><b>Order Status:-</b><span>{{$order_data->status}}</span></p>                               
            </div>
          </div>                      
        </div>
      </div>

      <div class="row">            
        <div class="col-sm-12 form-group mb-4">
          <div class="view_page card">
            <div class="view_data">                 
              <table data-page-length='25' class="table table-striped dataTable table-hover">
                <thead>
                  <tr>
                    <th>Serial No.</th>               
                    <th>Product Name</th>  
                    <th>Image</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Total</th>                                                     
                  </tr> 
                </thead>
                <tbody>              
                  @foreach ($order_item_data as $order_item)
                  <tr>
                    <td>{{ $loop->index + 1}}</td>                
                    <td>{{ $order_item->product_name}}</td> 
                    <td><img src="{{ asset($order_item->product_image)}}" height="50" width="50"/></td>
                    <td>${{ $order_item->product_price}}</td>
                    <td>{{ $order_item->quantity}}</td>  
                    <td>{{ $order_item->total}}</td>                
                  </tr>
                  @endforeach
                </tbody>
              </table>                             
            </div>
          </div>                      
        </div>           
      </div>

      <div class="row">            
        <div class="col-sm-6 form-group mb-4"> 
          <div class="view_data">    
            <p><b>Payment Method:-</b><span>{{$order_data->payment_method}}</span></p>                           
            <p><b>Shipping Method:-</b><span>{{$order_data->shipping_method}}</span></p>                             

          </div>             
        </div> 
        <div class="col-sm-6 form-group mb-4">
          <div class="view_data">    
            <p><b>Subtotal:-</b><span>${{$order_data->sub_total}}</span></p>                           
            <p><b>Coupon Code:-</b><span>{{$order_data->coupon_code}}</span></p>                             
            <p><b>Coupon Amount:-</b><span>{{$order_data->coupon_amount}}</span></p>  
            <p><b>Shipping Charges:-</b><span>${{$order_data->shipping_charges}}</span></p>  
            <p><b>Total:- ${{$order_data->final_total}} </b></p> 
          </div>                         
        </div>           
      </div>
       <div class="back_btn view_page text-start mt-3">
        @if($order_data->status=="pending")
        <a onclick="updateorderstatus('{{$order_data->order_id}}','processing')" class="btn btn-primary ">In-Processing</a>
        <a onclick="updateorderstatus('{{$order_data->order_id}}','completed')" class="btn btn-primary">Completed</a>
        <a onclick="updateorderstatus('{{$order_data->order_id}}','decline')" class="btn btn-primary">Declined</a>
        @elseif($order_data->status=="processing")
        <a  disabled class="btn btn-primary disabled">In-Processing</a>
        <a onclick="updateorderstatus('{{$order_data->order_id}}','completed')" class="btn btn-primary ">Completed</a>
        <a onclick="updateorderstatus('{{$order_data->order_id}}','decline')" class="btn btn-primary">Declined</a>        
        @endif
        </div>
    </div>
  </div>   

  <div class="back_btn view_page text-start mt-3">
    <a class="btn btn-primary float-right" href="/orders">Back</a>
  </div>

</div>
 <script>
    function updateorderstatus(order_id,order_status){            
        var token="{{ csrf_token() }}";
        $.ajax({
            url: "{{ route('update.order.status') }}",
            type:'POST',
            data: {_token:token,order_id:order_id,order_status:order_status},
            success: function(data) {
                 if($.isEmptyObject(data.error)){     
                           
                   location.reload();
                }else{
                  location.reload();
                }
            }
        });
    }
</script>
@endsection