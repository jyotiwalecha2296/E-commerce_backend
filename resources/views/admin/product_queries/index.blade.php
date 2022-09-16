@extends('admin.layouts.app') 
@section('content')
  <div class="container-fluid pt-3">
    <span class="title-data" id="titleData" data-link="product-queries" data-parent="" data-title="Product Inqueries"></span> 
    @if (session('success'))
      <div class="alert alert-success">
        {{ session('success') }}
      </div>
    @endif
    <div class="row">              
      <div class="col-sm-12 form-group mb-4 text-end">
       </div>
    </div>        
    <div class="card custom_card">
      <div class="dataTables_wrapper dt-bootstrap5 table-responsive"> 
      @if($data->count() > 0)            
        <table id="custom_datatable" class="table table-striped dataTable table-hover">
          <thead>
            <tr>
              <th>Serial No.</th> 
              <th>First Name</th>
              <th>Last Name</th>
              <th>Email</th>
              <th>Phone</th>
              <th>Address</th>
              <th>Concern</th>
              <th>Product Name</th>   
              <th>Product Image</th>  
              <th>Item Code</th> 
              <th>Price</th>     
              <th>status</th> 
              <th>Created At</th>  
              <th>Action</th>                 
            </tr>
          </thead>
          <tbody> 
            @foreach ($data as $detail)
            <tr>
              <td>{{ $loop->index + 1}}</td>
              <td>{{ $detail->first_name}}</td>    
              <td>{{ $detail->last_name}}</td>                  
              <td>{{$detail->email}}</td>
              <td>{{$detail->phone}}</td>
              <td>{{$detail->address}}</td>
              <td>{{$detail->concern}}</td>
              <td>{{$detail->product_name}}</td>
              <td><img src="{{asset($detail->product_image ?: 'public/watch_placeholder.png')}}" width="40"></td>
              <td>{{$detail->product_item_code}}</td>
              <td>{{$detail->product_price}}</td>
              <td>@if($detail->status=="0") Pending @else Replied @endif </td>  
              <td>{{ $detail->created_at}}</td>   
              <td><a class="tooltip-wrap" href="{{route('product-queries.show',$detail->id)}}"> <i class="lni lni-eye"></i><span class="show_name">View</span></a>
                  <form method="POST" action="{{ route('product-queries.destroy', $detail->id) }}">
                      @csrf
                      <input name="_method" type="hidden" value="DELETE">
                      <button type="submit" class="delete tooltip-wrap show_confirm" data-toggle="tooltip" title='Delete'><i class="lni lni-trash-can"></i><span class="show_name">Delete</span></button>
                  </form>
              </td>            
            </tr>
            @endforeach              
          </tbody>
        </table>
        @else
        <div class="text-center">No Inquiry Received Yet</div>
        @endif
      </div>
    </div>
  </div>
 
@endsection