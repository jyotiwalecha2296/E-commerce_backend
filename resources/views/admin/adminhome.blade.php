@extends('admin.layouts.app')  
@section('content')
<div class="container-fluid pt-5">
    <span class="title-data" id="titleData" data-link="crm" data-parent="" data-title="dashboard"></span>
    <div class="row">
        <div class="col-md-6 mb-4">
            <div class="card custom_card">
                <div class="card-title mb-4">Recent Orders</div>
                <div id="example_wrapper" class="dataTables_wrapper dt-bootstrap5">                    
                    <div class="row">
                        <div class="col-sm-12 table-responsive">
                        	@if($order_data->count() > 0)
                            <table id="recentOrderTable" class="table table-striped dataTable table-hover" style="width: 100%;" aria-describedby="example_info">
                                <thead>
                                    <tr>                                 	  
                                        <th>S.No.</th> 
                                        <th>Order ID</th>                              
                                        <th style="width:160px;">Customer</th>                                        
                                        <th>Customer Email</th>                                        
                                        <th>Amount</th>                                                                                 
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                  @foreach ($order_data as $orderdetail)                  
                                    <tr>
                                        <td align="center">{{ $loop->index + 1}}</td>
                                        <td>{{ $orderdetail->order_id}}</td>
                                       <td class="sorting_1"><span class="user-img"><img src="{{ asset($orderdetail->image ?: 'public/images/user.png') }}" width="30"></span>{{ $orderdetail->customer_name}}</td>
                                       <td class="sorting_1">{{ $orderdetail->customer_email}}</td>                                         
                                        <td>${{ $orderdetail->final_total}}</td>
                                        <td class="action">
                                            <a class="edit tooltip-wrap" href="{{route('orders.edit',$orderdetail->id)}}">
                                                <i class="lni lni-pencil"></i>
                                                <span class="show_name">Edit</span>
                                            </a>
                                            <a class="view tooltip-wrap" href="{{route('orders.show',$orderdetail->id)}}">
                                                <i class="lni lni-eye"></i>
                                                <span class="show_name">View</span>
                                            </a>
                                        </td>
                                    </tr> 
                                    @endforeach                                   
                                </tbody>                                               
                            </table>
                             @else
					          <div class="text-center"> 
					            No Order Yet
					          </div>
					        @endif
                        </div>
                    </div>                 
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-4">
            <div class="card custom_card">
                <div class="card-title">Recent Products</div>
                <div id="example_wrapper" class="dataTables_wrapper dt-bootstrap5">                    
                    <div class="row">
                        <div class="col-sm-12 table-responsive">
                        	@if($product_data->count() > 0)
                            <table id="recentProductTable" class="table table-striped dataTable table-hover" style="width: 100%;" aria-describedby="example_info">
                                <thead>
                                    <tr> 
                                        <th>S.No.</th>
                                        <th>Product Name</th>                              
                                        <th>Stock</th>                                       
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>   
                                   @foreach ($product_data as $product_detail)                     
                                    <tr> 
                                        <td align="center">{{ $loop->index + 1}}</td>                                      
                                        <td><span class="user-img"><img src="{{ asset($product_detail->featured_image ?: 'public/watch_placeholder.png') }}" width="20"></span>{{ $product_detail->name}}</td>                                                                           
                                        <td>@if($product_detail->status=="0") Not Available @else Available @endif </td>                                       
                                        <td class="action">
                                            <a class="edit tooltip-wrap" href="{{url('products/'.$product_detail->id.'/edit')}}">
                                                <i class="lni lni-pencil"></i>
                                                <span class="show_name">Edit</span>
                                            </a>                                          
                                        </td>
                                    </tr>  
                                   @endforeach                                                               
                                </tbody>                                               
                            </table>
                             @else
					          <div class="text-center"> 
					            No Product Yet
					          </div>
					        @endif
                        </div>
                    </div>                 
                </div>
            </div>
        </div>
    </div>
</div>
@endsection