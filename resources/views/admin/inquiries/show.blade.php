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
      <div class="col-sm-12 form-group mb-4 text-start">
                        <div class="view_page">
                          <div class="view_data">
                              <p><b>Name:-</b></p><span>{{$data->name}}</span>                             
                              <p><b>Email:-</b></p><span>{{$data->email}}</span>                             
                              <p><b>Subject:-</b></p><span>{{$data->subject}}</span>
                              <p><b>Message:-</b></p><span>{{$data->message}}</span>
                            </div>

                      </div>
                      <div class="back_btn view_page text-start mt-3">
                          <a class="btn btn-primary float-right" href="/crm/inquiries">Back</a>
                      </div>
       </div>
    </div>        
     
  </div>
 
@endsection