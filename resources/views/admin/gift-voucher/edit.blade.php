@extends('admin.layouts.app') 
@section('content')
<div class="container-fluid pt-5">
  <span class="title-data" id="titleData" data-link="gift-vouchers/{{$data->id}}/edit" data-parent="vouchers" data-title="edit vouchers"></span>
  {!!Form::model($data,['method'=>'PATCH', 'enctype'=>'multipart/form-data' ,'route'=>['gift-vouchers.update',$data->id] ,'id'=>'form','files'=>'true' ,'data-parsley-validate' => '','name'=>'voucher_form']) !!}         
    {{ csrf_field() }}
    <div class="row">      
      <div class="col-lg-9 col-md-8 col-sm-7 order-2 order-sm-1">
        <div class="card custom_card mb-3">
          <div class="row">
            <div class="col-sm-12">
              <span class="fs-6">Gift-Voucher Information</span>
            </div>
          </div>
          <div class="card-body">     

            <div class="form-group row">
                <div class="col-sm-6 mb-3">
                  <label for="name" class="">Voucher Code</label>          
                  <input type="text" class="form-control field-validate" placeholder="Please enter coupon code here" value="{{$data->code}}" disabled="">
                  <input type="hidden" name="code" value="{{$data->code}}"> 
                </div>

                <div class="col-sm-6 mb-3">
                  <label for="name" class="">Discount Amount</label>          
                  <input type="number" min="1" oninput="validity.valid||(value='');" name="discount_amount" class="form-control field-validate" placeholder="Please enter Voucher code here" value="{{$data->discount_amount}}">
                </div> 
            </div>

            <div class="form-group row">
                     <div class="col-sm-6 mb-3">
                      <label for="tagline" class="form-label">Expires At</label>              
                       <input type="date" name="expires_at" id="expires_at" class="form-control field-validate" value="{{$data->expires_at}}" >             
                      @error('expires_at')
                        <span class="invalid-feedback" role="alert">
                          {{ $message }}
                        </span>
                      @enderror
                    </div>
              </div>

            <div class="form-group row">
                <div class="col-sm-12 mb-3">
                      <label  class="form-label">Description(Optional)</label>                             
                     <textarea name="description" class="form-control" placeholder="Please write description here" rows="6" id="description">{{$data->description}}</textarea>       
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
                <span class="title">Update Collection </span> 
                <span class="icon">
                  <i class="lni lni-chevron-down"></i>
                  <i class="lni lni-chevron-up"></i>
                </span>
              </a>
            </div>
            <div class="card-body">
              <div class="collapse show" id="pageInfo">
                <div class="mb-3">
                  <label for="status" class="form-label">Status</label>
                  <select class="form-select" name="status" id="status">
                    <option value="">Select Status</option>
                    <option value="0" @if($data->status=="0") selected @endif>Disable</option>
                    <option value="1" @if($data->status=="1") selected @endif>Enable</option>
                  </select>
                  @error('status')
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                  @enderror
                </div>                
              </div> 
              <div class="collapse show" id="productTags">
                <div class="card-body border-top">                  
                  <div class="row">
                    <div class="col-sm-12 mb-3">
                      <label for="logo" class="col-sm-12 form-label">Voucher Image</label>
                      <div class="col-sm-12 img-thumbnail">
                        <img src="{{ asset($data->image  ?: 'public/gift-voucher.png') }}" alt="mage" class="img-fluid" style="max-width: 30% !important;">
                        
                      </div>
                      <div class="col-sm-12">
                        <input type="file" name="voucher_image" id="voucher_image"  onchange="loadvoucherimage()">
                        <p class="image-dimesion-label">For best results, use 900 px by 1438 px image</p><br/>
                        <img id="voucher_image_demo" class="img-fluid" style="max-width: 30% !important; display:none"/>                      
                        <input type="hidden" name="old_voucher_image" value="{{$data->image}}" >
                        @error('voucher_image')
                        <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                      </div>                    
                    </div>                  
                  </div>
                </div>        
              </div>
              <div class="w-100 text-end">
                <button type="submit" class="btn btn-primary custom-dark-btn w-30">Update</button>
              </div>
            </div> 
          </div>
          
          
        </div>
      </div> 
    </div>
  {!! Form::close() !!}
</div>
<script type="text/javascript">
  
    function loadvouchermage(){
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

</script> 
@endsection