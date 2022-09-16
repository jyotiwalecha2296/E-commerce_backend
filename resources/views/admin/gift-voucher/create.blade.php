@extends('admin.layouts.app') 
@section('content')
  <div class="container-fluid pt-5">
    <span class="title-data" id="titleData" data-link="gift-vouchers/create" data-parent="vouchers" data-title="Create Vouchers"></span>
    {!! Form::open(array('route' => 'gift-vouchers.store','method'=>'POST',  'enctype'=>'multipart/form-data' , 'class'=>'form-horizontal', 'id'=>'form','files'=>true,'data-parsley-validate' => '','name'=>'vouchers_form'))!!}
      {{ csrf_field() }}
      <div class="row">      
        <div class="col-lg-9 col-md-8 col-sm-7 order-2 order-sm-1">     
          <div class="card custom_card mb-3">
            <div class="row">
              <div class="col-sm-12">
                <span class="fs-6">Gift Voucher Information</span>
              </div>
            </div>
            <div class="card-body">              
             
              <div class="form-group row">
                <div class="col-sm-6 mb-3">
                  <label for="name">Voucher Code</label>                        
                    <input type="text" name="code" class="form-control field-validate"  placeholder="Please enter voucher code here" id="voucher_code" value="{{old('code')}}" >
                    @error('code')
                       <span class="invalid-feedback" role="alert">
                       {{ $message }}
                       </span>
                    @enderror
                </div>

                <div class="col-sm-6 mb-3 {{ $errors->has('value') ? 'has-error' :'' }}" > 
                  <label for="name">Discount Amount</label>
                  <input type="number" min="1" oninput="validity.valid||(value='');" name="discount_amount" class="form-control field-validate" placeholder="Please enter discount Amount here" value="{{old('discount_amount')}}" >@error('discount_amount')
                    <span class="invalid-feedback" role="alert">
                      {{ $message }}
                    </span>
                  @enderror                 
                </div> 

                
              </div>      
             

              <div class="form-group row">
                     <div class="col-sm-6 mb-3">
                      <label for="tagline" class="form-label">Expire At</label>              
                       <input type="date" name="expire_at" id="expire_at" class="form-control field-validate" value="{{old('start_date')}}" >             
                      @error('expire_at')
                        <span class="invalid-feedback" role="alert">
                          {{ $message }}
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
                  <span class="title">Create Gift-Voucher </span> 
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
                 <div class="collapse show" id="productTags">
              <div class="card-body border-top">                  
                <div class="row">
                  <div class="col-sm-12 mb-3">
                    <label for="logo" class="form-label">Voucher Image</label>
                    <input type="file" class="form-control @error('voucher_image') is-invalid @enderror" name="voucher_image" id="voucher_image" placeholder="Please upload Voucher image " onchange="loadVoucherImage()">
                    <p class="image-dimesion-label">For best results, use 900 px by 1438 px image</p>
                    <img id="voucher_image_demo"  class="img-thumbnail" style="display:none; max-width: 30% !important;"/>
                    @error('voucher_image')
                      <span class="invalid-feedback" role="alert">
                        {{ $message }}
                      </span>
                    @enderror                    
                  </div>
                
                </div>
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
    $('#voucher_code').keyup(function(){
        $(this).val($(this).val().toUpperCase());
    });

      function loadVoucherImage(){
    $('#voucher_image_demo').show();
    $('#voucher_image_demo').attr('src', URL.createObjectURL(event.target.files[0]));
  }
  $("#voucher_image").change(function () {    
    var fileExtension = ['jpeg', 'jpg', 'png','gif'];
    var filesize=(this.files[0].size);

    if($.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) == -1) {
         swal("Only " +fileExtension.join(', ') +" formats are allowed");
           document.getElementById("voucher_image").value = "";
           $('#voucher_image_demo').hide();
    }

    if(filesize > 1000000) {
       swal("Please do not upload image of more than 1 Mb size");
       document.getElementById("voucher_image").value = "";
           $('#voucher_image_demo').hide();
    }

     
  }); 

});
</script>
@endsection