@extends('admin.layouts.app') 
@section('content')
  <div class="container-fluid pt-5">
    <span class="title-data" id="titleData" data-link="shipping/create" data-parent="shipping" data-title="Create shipping"></span>
    {!! Form::open(['route'=>['shipping.store'], 'method' => 'POST','files'=>true,'autocomplete'=>'false', 'id'=>'form','data-parsley-validate' => '','class'=>'form-horizontal','name'=>'form']) !!} 
      {{ csrf_field() }}
      <div class="row">      
        <div class="col-lg-9 col-md-8 col-sm-7 order-2 order-sm-1">     
          <div class="card custom_card mb-3">
            <div class="row">
              <div class="col-sm-12">
                <span class="fs-6">Shipping Information</span>
              </div>
            </div>
            <div class="card-body">   
                    <div class="form-group row">
                      <div class="col-sm-12 mb-3">
                        <label for="name" class="form-label">Country</label> 
                        <select class="form-select" name="country_code" id="status" aria-label=".form-select-lg example">
                            <option value="" disabled selected>Select Country</option>
                            @foreach($countrycode as $country)
                            <option value="{{$country->code}}">{{$country->country_name}}</option>
                            @endforeach                      
                          </select>    
                          @error('country_code')
                            <span class="invalid-feedback" role="alert">
                              {{ $message }}
                            </span>
                          @enderror
                      </div>  
                    </div>
                    <div class="form-group row">
                           <div class="col-sm-12 mb-3">
                            <label for="shipping_charges" class="form-label">Shipping Charges</label>              
                            <input  type="number" min="1" oninput="validity.valid||(value='');"  name="shipping_charges" class="form-control  @error('shipping_charges') is-invalid @enderror" placeholder="Enter shipping charges" value="{{ old('shipping_charges') }}">              
                            @error('shipping_charges')
                              <span class="invalid-feedback" role="alert">
                                {{ $message }}
                              </span>
                            @enderror
                          </div>              
                    </div>                          
            </div> 
          </div>

         
        </div>
        <div class="col-lg-3 col-md-4 col-sm-5 order-1 order-sm-2">
          <div class="setting-wrap">
            <div class="card mb-3">
              <div class="border-bottom">            
                <a class="collapse-border-box" data-bs-toggle="collapse" href="#pageInfo" role="button" aria-expanded="true" aria-controls="pageSeoSettings">
                  <span class="title">Create Collection </span> 
                  <span class="icon">
                    <i class="lni lni-chevron-down"></i>
                    <i class="lni lni-chevron-up"></i>
                  </span>
                </a>
              </div>
              <div class="card-body">
                <div class="collapse show" id="pageInfo">
                  <div class="col-sm-12 mb-3">
                    <label for="status" class="form-label">Status</label>
                    <select class="form-select" name="status" id="status" aria-label=".form-select-lg example">
                      <option value="">Select Status</option>
                      <option value="0">Disable</option>
                      <option value="1" selected>Enable</option>
                    </select>
                    @error('status')
                      <span class="invalid-feedback" role="alert">
                        {{ $message }}
                      </span>
                    @enderror 
                  </div>                
                </div> 
                <div class="w-100 text-end">
                  <button type="submit" class="btn btn-primary custom-dark-btn w-30">Save</button>
                </div>
              </div> 
            </div>
            
     
          </div>
        </div>
      </div>
    {!! Form::close() !!}              
  </div>
   
@endsection