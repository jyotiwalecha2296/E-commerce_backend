@extends('admin.layouts.app') 
@section('content')
  <div class="container-fluid pt-3">
    <span class="title-data" id="titleData" data-link="product-queries" data-parent="" data-title="Product Inqueries"></span> 
    @if (session('success'))
      <div class="alert alert-success">
        {{ session('success') }}
      </div>
    @endif
     <div class="back_btn view_page text-start my-3">
                          <a class="btn btn-primary float-right" href="/crm/product-queries"><i class="lni lni-arrow-left"></i>&nbsp;Back</a>
                      </div>
    <div class="row">              
      <div class="col-sm-6 form-group mb-4 text-start">
                        <div class="view_page">
                          <div class="card custom_card">
                            <div class="dataTables_wrapper dt-bootstrap5 table-responsive">
                              <table id="custom_datatable" class="table table-striped dataTable table-hover no-footer result">
                                <tr>
                                  <td>First Name</td>
                                  <td>{{$data->first_name}}</td>
                                </tr>
                                <tr>
                                  <td>Last Name</td>
                                  <td>{{$data->last_name}}</td>
                                </tr>
                                <tr>
                                  <td>Email</td>
                                  <td>{{$data->email}}</td>
                                </tr>
                                <tr>
                                  <td>Phone</td>
                                  <td>{{$data->phone}}</td>
                                </tr>
                                <tr>
                                  <td>Address</td>
                                  <td>{{$data->address}}</td>
                                </tr>
                                <tr>
                                  <td>Concern</td>
                                  <td>{{$data->concern}}</td>
                                </tr>
                                <tr>
                                  <td>Product Name</td>
                                  <td>{{$data->product_name}}</td>
                                </tr>
                                <tr>
                                  <td>Product Item Code</td>
                                  <td>{{$data->product_item_code}}</td>
                                </tr>
                                <tr>
                                  <td>Product Image</td>
                                  <td><img src="{{asset($data->product_image ?: 'public/watch_placeholder.png')}}" height="100" width="100"></td>
                                </tr>
                                <tr>
                                  <td>Product Price</td>
                                  <td>{{$data->product_price}}</td>
                                </tr>
                              </table>
                            </div>

                          </div>

                      </div>
                     
       </div>
    </div>        
     
  </div>
 
@endsection