@extends('admin.layouts.app') 
@section('content')
  <div class="container-fluid pt-5">
    <span class="title-data" id="titleData" data-link="coupons/create" data-parent="coupons" data-title="Create coupon"></span>
    {!! Form::open(array('route' => 'coupons.store','method'=>'POST' , 'class'=>'form-horizontal', 'id'=>'form','files'=>true,'data-parsley-validate' => '','name'=>'coupons_form'))!!}
      {{ csrf_field() }}
      <div class="row">      
        <div class="col-lg-9 col-md-8 col-sm-7 order-2 order-sm-1">     
          <div class="card custom_card mb-3">
            <div class="row">
              <div class="col-sm-12">
                <span class="fs-6">Coupon Information</span>
              </div>
            </div>
            <div class="card-body">              
             
              <div class="form-group row">
                <div class="col-sm-6 mb-3">
                  <label for="name">Coupon Code</label>                        
                    <input type="text" name="code" class="form-control field-validate"  placeholder="Please enter coupon code here" id="coupon_code" value="{{old('code')}}" >
                    @error('code')
                       <span class="invalid-feedback" role="alert">
                       {{ $message }}
                       </span>
                    @enderror
                </div>

                <div class="col-sm-6 mb-3 {{ $errors->has('value') ? 'has-error' :'' }}" > 
                  <label for="name">Discount Percentage</label>
                  <input type="number" min="1" oninput="validity.valid||(value='');" name="discount_percentage" class="form-control field-validate" placeholder="Please enter discount percentage here" value="{{old('discount_percentage')}}" >@error('discount_percentage')
                    <span class="invalid-feedback" role="alert">
                      {{ $message }}
                    </span>
                  @enderror                 
                </div> 

                
              </div>

              <div class="form-group row">
                      <div class="col-sm-6 mb-3">
                      <label for="tagline">Minimum Amount</label>              
                      <input type="number" min="1" oninput="validity.valid||(value='');" name="minimum_amount" class="form-control field-validate" placeholder="Please enter minimum amount on which customer can apply coupon" value="{{old('minimum_amount')}}" >              
                      @error('minimum_amount')
                        <span class="invalid-feedback" role="alert">
                          {{ $message }}
                        </span>
                      @enderror
                    </div>
                
                    <div class="col-sm-6 mb-3">          
                    <label for="tagline">Coupon Limit</label>              
                      <input type="number" min="1" oninput="validity.valid||(value='');" name="coupon_limit" class="form-control field-validate" placeholder="Please enter coupon limit" value="{{old('coupon_limit')}}" >              
                      @error('coupon_limit')
                        <span class="invalid-feedback" role="alert">
                          {{ $message }}
                        </span>
                      @enderror
                  </div>
              </div>

         
             

              <div class="form-group row">
                     <div class="col-sm-6 mb-3">
                      <label for="tagline" class="form-label">Start Date</label>              
                       <input type="date" name="start_date" id="start_date" class="form-control field-validate" value="{{old('start_date')}}" >             
                      @error('start_date')
                        <span class="invalid-feedback" role="alert">
                          {{ $message }}
                        </span>
                      @enderror
                    </div>
                
                    <div class="col-sm-6 mb-3">          
                    <label  class="form-label">End Date</label>                             
                     <input type="date" name="end_date" id="end_date" class="form-control field-validate" value="{{old('end_date')}}" >     
                    @error('end_date')
                      <span class="invalid-feedback" role="alert">
                        <span>{{ $message }}</span>
                      </span>
                    @enderror 
                  </div>
              </div>

               <div class="form-group row">
                   
                
                    <div class="col-sm-12 mb-3">          
                    <label  class="form-label">Description(Optional)</label>                             
                     <textarea name="description" class="form-control" placeholder="Please write description here" rows="2" id="description"></textarea>       
                    @error('description')
                      <span class="invalid-feedback" role="alert">
                        <span>{{ $message }}</span>
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
                  <span class="title">Create Coupon </span> 
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
   <script>
    $(document).ready(function(){
    $('#coupon_code').keyup(function(){
        $(this).val($(this).val().toUpperCase());
    });
});
</script>
@endsection