@extends('admin.layouts.app') 
@section('content')
<link type="text/css" rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<link type="text/css" rel="stylesheet" href="{{asset('public/multipleimages/image-uploader.min.css')}}">
<script type="text/javascript" src="{{asset('public/multipleimages/image-uploader.min.js')}}"></script>
<span class="title-data" id="titleData" data-link="products/create" data-parent="products" data-title="Add Product"></span> 
<div class="container-fluid pt-5">
  <form role="form" data-parsley-validate="" method="POST" action="{{url('save_product')}}"  id="add_product_form" name="product_form" enctype="multipart/form-data">
    {{ csrf_field() }}
    <div class="row">      
      <div class="col-sm-9">      
        <div class="card custom_card mb-3">
          <div class="row">
            <div class="col-sm-12">
              <span class="fs-6">Product Information</span>
            </div>
          </div>
          <div class="card-body">                                  
            <div class="form-group row">
              <div class="col-sm-6 mb-3" > 
                <label for="name" class="form-label">Name</label>                
                <input type="text" name="name" id="name" class="form-control save_product_name @error('name') is-invalid @enderror" placeholder="Enter name" value="{{ old('name') }}">                
                @error('name')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                @enderror 
              </div>
              <div class="col-sm-6 mb-3">          
                <label  class="form-label">Product Color</label>                             
                <input type="text" name="color" id="color" class="form-control @error('color') is-invalid @enderror" placeholder="Please write product color" value="{{ old('color') }}">
                @error('color')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                @enderror 
              </div>     
              <div class="col-sm-6 mb-3" >                
                <input type="hidden" name="slug" class="form-control save_product_slug @error('slug') is-invalid @enderror" placeholder="Enter slug" value="{{ old('slug') }}" >               
              </div>
              <div class="slug-result"></div>
            </div>
            <div class="form-group row"> 
              <div class="col-sm-12 mb-3">          
                <label  class="form-label">Description</label>                             
                <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror" placeholder="Please write description here" rows="2">{{ old('description') }}</textarea> 
                 
                @error('description')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                @enderror 
              </div>     
            </div>
          </div>
        </div>
        <div class="card custom_card mb-3">
          <div class="collapse-box">            
            <div class="flex-box">          
              <div class="collapse-box-header">
                <span class="fs-6 w-8">Product Data-</span> 
                <select name='product_type' class='form-select' label='Select Form' id='product_type' list='form_list' defaulttext='(Please Select)'>
                  <option value="" disabled>Select Product Type</option>
                  <option value="simple" selected>Simple Product</option>
                  <option value="only_steel_variant">Steel Bracelet Product</option>
                  <option value="only_rubber_variant">Rubber Strap Product</option>
                  <option value="both_variations">Both Steel & Rubber Product</option>
                </select>                
              </div>
              <div class="collapse-box-header">
                <span class="fs-6 w-8">Product Line Type-</span> 
                <select name='product_line' class='form-select' label='Select Form' id='product_line' list='form_list' defaulttext='(Please Select)' required>
                  <option value="" disabled>Select Product Type</option>
                  <option value="t-line" selected>T Line</option>
                  <option value="s-line">S Line</option>
                  <option value="strap">Strap</option>
                </select>                
              </div>
              <a class="collapse-border-box" data-bs-toggle="collapse" href="#createProductData" role="button" aria-expanded="false" aria-controls="pageSeoSettings">              
                <span class="icon">
                  <i class="lni lni-chevron-down"></i>
                  <i class="lni lni-chevron-up"></i>
                </span>
              </a>
            </div>   
            <div class="collapse show" id="createProductData">
              <div class="collapse-content">

              <!-- CASE 1: SIMPLE PRODUCT   -->
              <div class="row product_row simple">
                 <div class="card-body">
                  <div class="form-group row">
                    <div class="col-sm-4 mb-3" >
                      <label for="simple_price" class="form-label">Product Price ($)</label>
                      <input type="number" name="simple_price" class="form-control save_product_price @error('simple_price') is-invalid @enderror" id="simple_price" placeholder="Enter price" value="{{ old('simple_price') }}" >       
                      @error('simple_price')
                        <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                        </span>
                      @enderror 
                    </div>

                    <div class="col-sm-4 mb-3" >
                      <label for="simple_stock" class="form-label">Product Stock</label>
                      <input type="number" name="simple_stock" class="form-control @error('simple_stock') is-invalid @enderror" id="simple_stock" placeholder="Enter stock" value="{{ old('simple_stock') }}" >       
                      @error('simple_stock')
                        <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                        </span>
                      @enderror 
                    </div>                  
                   
                    <div class="col-sm-4 mb-3" >
                      <label for="simple_item_code" class="form-label">Item Code</label>
                      <input type="text" name="simple_item_code" class="form-control @error('simple_item_code') is-invalid @enderror" id="simple_item_code" placeholder="Enter item code" value="{{ old('simple_item_code') }}" >       
                      @error('simple_item_code')
                        <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                        </span>
                      @enderror
                    </div>                 
                  </div>        
                </div>
              </div>
 
             <!-- CASE 2: STEEL VARIANT -->
             <div class="row product_row only_steel_variant" style="display:none;">
                <div class="card-body">
                  <div class="form-group row">
                    <div class="col-sm-6 mb-3 form-check">
                      <h6 class="form-label">Steel Bracelet Details</h6> 
                    </div>                    
                  </div>
                   <div class="form-group row">
                    <div class="col-sm-4 mb-3" >
                      <label for="only_steel_variant_price" class="form-label">Product Price ($)</label>
                      <input type="number" name="only_steel_variant_price" id="only_steel_variant_price" class="form-control save_product_price @error('only_steel_variant_price') is-invalid @enderror" placeholder="Enter price" value="{{ old('only_steel_variant_price') }}" >       
                      @error('only_steel_variant_price')
                        <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                        </span>
                      @enderror 
                    </div>
                    <div class="col-sm-4 mb-3" >
                      <label for="only_steel_variant_stock" class="form-label">Product Stock</label>
                      <input type="number" name="only_steel_variant_stock" id="only_steel_variant_stock" class="form-control @error('only_steel_variant_stock') is-invalid @enderror" placeholder="Enter stock" value="{{ old('only_steel_variant_stock') }}" >       
                      @error('only_steel_variant_stock')
                        <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                        </span>
                      @enderror 
                    </div>
                    <div class="col-sm-4 mb-3" >
                      <label for="only_steel_variant_item_code" class="form-label">Item Code</label>
                      <input type="text" name="only_steel_variant_item_code" id="only_steel_variant_item_code" class="form-control @error('only_steel_variant_item_code') is-invalid @enderror" placeholder="Enter iten code" value="{{ old('only_steel_variant_item_code') }}" >       
                      @error('only_steel_variant_item_code')
                        <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                        </span>
                      @enderror
                    </div>

                  </div>
                 

                  <div class="form-group row">
                    <div class="col-sm-4 mb-3" >
                      <label for="only_steel_variant_image" class="form-label">Featured Image</label>
                      <input type="file" name="only_steel_variant_image" id="only_steel_variant_image" class="form-control @error('only_steel_variant_image') is-invalid @enderror" value="{{ old('only_steel_variant_image') }}" >
                      <p class="image-dimesion-label">For best results, use 900 px by 1438 px image</p>
       
                      @error('only_steel_variant_image')
                        <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                        </span>
                      @enderror 
                    </div>

                    <div class="col-sm-4 mb-3" >
                      <label for="only_steel_variant_strap_image" class="form-label">Strap Image</label>
                      <input type="file" name="only_steel_variant_strap_image" id="only_steel_variant_strap_image" class="form-control @error('only_steel_variant_strap_image') is-invalid @enderror" value="{{ old('only_steel_variant_strap_image') }}" > 
                      <p class="image-dimesion-label">For best results, use 328 px by 100 px image</p>
      
                      @error('only_steel_variant_strap_image')
                        <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                        </span>
                      @enderror
                    </div>

                   <div class="col-sm-4 mb-3" >
                      <label for="only_steel_variant_night_image" class="form-label">Night View Image</label>
                      <input type="file" name="only_steel_variant_night_image" id="only_steel_variant_night_image" class="form-control @error('only_steel_variant_night_image') is-invalid @enderror" value="{{ old('only_steel_variant_night_image') }}" > 
                      <p class="image-dimesion-label">For best results, use 900 px by 1438 px image</p>
      
                      @error('only_steel_variant_night_image')
                        <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                        </span>
                      @enderror
                    </div>

                  </div>


                  <div class="form-group row">
                    <div class="col-sm-8 mb-9" >
                      <label for="only_steel_variant_description" class="form-label">Product Description</label>
                      <textarea name="only_steel_variant_description" id="only_steel_variant_description" placeholder="Description" value="">{{ old('only_steel_variant_description') }}</textarea>
                      @error('only_steel_variant_description')
                        <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                        </span>
                      @enderror 
                    </div>

                     <div class="col-sm-4 mb-3" >
                      <label for="only_steel_variant_gallery_images" class="form-label">Gallery Image</label>                      
                      <div class="only-steel-gallery-images"></div>  
                      <p class="image-dimesion-label">For best results, use 900 px by 900 px image</p>                     
                    </div>
                  </div>
                </div>
             </div>
             
             <!-- CASE 3:RUBBER VARIANT -->
             <div class="row product_row only_rubber_variant" style="display:none;">
              <div class="form-group row">
                    <div class="col-sm-6 mb-3 form-check">
                      <h6 class="form-label">Rubber Strap Details </h6> 
                    </div>                    
                  </div>
                <div class="card-body">
                   <div class="form-group row">
                    <div class="col-sm-4 mb-3" >
                      <label for="only_rubber_variant_price" class="form-label">Product Price ($)</label>
                      <input type="number" name="only_rubber_variant_price" id="only_rubber_variant_price" class="form-control save_product_price @error('only_rubber_variant_price') is-invalid @enderror" placeholder="Enter price" value="{{ old('rubber_strap_price') }}" >       
                      @error('only_rubber_variant_price')
                        <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                        </span>
                      @enderror 
                    </div>

                    <div class="col-sm-4 mb-3" >
                      <label for="only_rubber_variant_stock" class="form-label">Product Stock</label>
                      <input type="number" name="only_rubber_variant_stock" id="only_rubber_variant_stock" class="form-control @error('only_rubber_variant_stock') is-invalid @enderror" placeholder="Enter stock" value="{{ old('only_rubber_variant_stock') }}" >       
                      @error('only_rubber_variant_stock')
                        <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                        </span>
                      @enderror 
                    </div>

                    <div class="col-sm-4 mb-3" >
                      <label for="only_rubber_variant_item_code" class="form-label">Item Code</label>
                      <input type="text" name="only_rubber_variant_item_code" id="only_rubber_variant_item_code" class="form-control @error('only_rubber_variant_item_code') is-invalid @enderror" placeholder="Enter iten code" value="{{ old('only_rubber_variant_item_code') }}" >       
                      @error('only_rubber_variant_item_code')
                        <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                        </span>
                      @enderror
                    </div>
                  </div>
                  
              

                  <div class="form-group row">
                    <div class="col-sm-4 mb-3" >
                      <label for="only_rubber_variant_image" class="form-label">Product Image</label>
                      <input type="file" name="only_rubber_variant_image"  id="only_rubber_variant_image" class="form-control @error('only_rubber_variant_image') is-invalid @enderror"  value="{{ old('only_rubber_variant_image') }}" > 
                      <p class="image-dimesion-label">For best results, use 900 px by 1438 px image</p>      
                      @error('only_rubber_variant_image')
                        <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                        </span>
                      @enderror 
                    </div>
                    <div class="col-sm-4 mb-3" >
                      <label for="only_rubber_variant_strap_image" class="form-label">Strap Image</label>
                      <input type="file" name="only_rubber_variant_strap_image"  id="only_rubber_variant_strap_image"  class="form-control @error('only_rubber_variant_strap_image') is-invalid @enderror"  value="{{ old('only_rubber_variant_strap_image') }}" >  
                       <p class="image-dimesion-label">For best results, use 328 px by 100 px image</p>     
                      @error('only_rubber_variant_strap_image')
                        <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                        </span>
                      @enderror
                    </div>

                     <div class="col-sm-4 mb-3" >
                      <label for="only_rubber_variant_night_image" class="form-label">Night View Image</label>
                      <input type="file" name="only_rubber_variant_night_image"  id="only_rubber_variant_night_image"  class="form-control @error('only_rubber_variant_night_image') is-invalid @enderror"  value="{{ old('only_rubber_variant_night_image') }}" >  
                       <p class="image-dimesion-label">For best results, use 900 px by 1438 px image</p>     
                      @error('only_rubber_variant_night_image')
                        <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                        </span>
                      @enderror
                    </div>
                  </div>

                  <div class="form-group row">
                    <div class="col-sm-8 mb-12" >
                      <label for="only_rubber_variant_description" class="form-label">Product Description</label>
                      <textarea  name="only_rubber_variant_description" id="only_rubber_variant_description" placeholder="Description"  rows="4">{{ old('only_rubber_variant_description') }}</textarea>       
                      @error('only_rubber_variant_description')
                        <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                        </span>
                      @enderror 
                    </div>
                    <div class="col-sm-4 mb-12" >
                      <label for="only_rubber_variant_gallery_images" class="form-label">Gallery Image</label>                      
                      <div class="only-rubber-gallery-images"></div>   
                      <p class="image-dimesion-label">For best results, use 900 px by 900 px image</p>                    
                    </div>
                  </div>
                </div>
             </div>
              
              <!-- CASE 4: BOTH STEEL AND RUBBER PRODUCT -->
              <div class="row product_row both_variations" style="display:none;">                
                <div class="card-body">
                  <div class="form-group row">
                    <div class="col-sm-6 mb-3 form-check">
                      <h6 class="form-label">Product Data-(Steel Bracelet)</h6> 
                    </div>                    
                  </div>
                   <div class="form-group row">
                    <div class="col-sm-4 mb-3" >
                      <label for="both_variations_steel_price" class="form-label">Product Price ($)</label>
                      <input type="number" name="both_variations_steel_price" id="both_variations_steel_price" class="form-control save_product_price @error('both_variations_steel_price') is-invalid @enderror" placeholder="Enter price" value="{{ old('both_variations_steel_price') }}" >       
                      @error('both_variations_steel_price')
                        <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                        </span>
                      @enderror 
                    </div>
                    <div class="col-sm-4 mb-3" >
                      <label for="both_variations_steel_stock" class="form-label">Product Stock</label>
                      <input type="number" name="both_variations_steel_stock" id="both_variations_steel_stock" class="form-control @error('both_variations_steel_stock') is-invalid @enderror" placeholder="Enter stock" value="{{ old('both_variations_steel_stock') }}" >       
                      @error('both_variations_steel_stock')
                        <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                        </span>
                      @enderror 
                    </div>
                    <div class="col-sm-4 mb-3" >
                      <label for="both_variations_steel_item_code" class="form-label">Item Code</label>
                      <input type="text" name="both_variations_steel_item_code"  id="both_variations_steel_item_code" class="form-control @error('both_variations_steel_item_code') is-invalid @enderror" placeholder="Enter iten code" value="{{ old('both_variations_steel_item_code') }}" >       
                      @error('both_variations_steel_item_code')
                        <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                        </span>
                      @enderror
                    </div>
                  </div>
                  

                  <div class="form-group row">
                     <div class="col-sm-4 mb-3" >
                      <label for="both_variations_steel_image" class="form-label">Featured Image</label>
                      <input type="file" name="both_variations_steel_image" id="both_variations_steel_image" class="form-control @error('both_variations_steel_image') is-invalid @enderror" value="{{ old('both_variations_steel_image') }}" > 
                      <p class="image-dimesion-label">For best results, use 900 px by 1438 px image</p>      
                      @error('both_variations_steel_image')
                        <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                        </span>
                      @enderror 
                    </div>
                    <div class="col-sm-4 mb-3" >
                      <label for="both_variations_steel_strap_image" class="form-label">Strap Image</label>
                      <input type="file" name="both_variations_steel_strap_image" id="both_variations_steel_strap_image"  class="form-control @error('both_variations_steel_strap_image') is-invalid @enderror" value="{{ old('both_variations_steel_strap_image') }}" >  
                       <p class="image-dimesion-label">For best results, use 328 px by 100 px image</p>     
                      @error('both_variations_strap_image')
                        <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                        </span>
                      @enderror
                    </div>

                    <div class="col-sm-4 mb-3" >
                      <label for="both_variations_steel_night_image" class="form-label">Nigth View Image</label>
                      <input type="file" name="both_variations_steel_night_image" id="both_variations_steel_night_image"  class="form-control @error('both_variations_steel_night_image') is-invalid @enderror" value="{{ old('both_variations_steel_night_image') }}" >  
                       <p class="image-dimesion-label">For best results, use 900 px by 1438 px image</p>     
                      @error('both_variations_steel_night_image')
                        <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                        </span>
                      @enderror
                    </div>

                  </div>
               
                  <div class="form-group row">

                    <div class="col-sm-8 mb-12" >
                      <label for="both_variations_steel_description" class="form-label">Product Description</label>
                      <textarea name="both_variations_steel_description" id="both_variations_steel_description" placeholder="Description" >{{ old('both_variations_steel_description') }}</textarea>       
                      @error('both_variations_steel_description')
                        <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                        </span>
                      @enderror 
                    </div>


                    <div class="col-sm-4 mb-3" >
                      <label for="both_variations_steel_gallery_images" class="form-label">Gallery Image</label>                      
                      <div class="both-variations-steel-gallery-images"></div> 
                      <p class="image-dimesion-label">For best results, use 900 px by 900 px image</p>
                     </div>

                  </div>
                </div>                
                <div class="card-body">
                  <div class="form-group row">
                    <div class="col-sm-6 mb-3 form-check">                      
                      <h6 class="form-label">Product Data-(Rubber Strap)</h6>
                    </div>
                  </div>  

                  <div class="form-group row">
                    <div class="col-sm-4 mb-3" >
                      <label for="both_variations_rubber_price" class="form-label">Product Price ($)</label>
                      <input type="number" name="both_variations_rubber_price" id="both_variations_rubber_price" class="form-control save_product_price @error('both_variations_rubber_price') is-invalid @enderror" placeholder="Enter price" value="{{ old('both_variations_rubber_price') }}" >       
                      @error('both_variations_rubber_price')
                        <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                        </span>
                      @enderror 
                    </div>

                    <div class="col-sm-4 mb-3" >
                      <label for="both_variations_rubber_stock" class="form-label">Product Stock</label>
                      <input type="number" name="both_variations_rubber_stock" id="both_variations_rubber_stock" class="form-control @error('both_variations_rubber_stock') is-invalid @enderror" placeholder="Enter stock" value="{{ old('both_variations_rubber_stock') }}" >       
                      @error('both_variations_rubber_stock')
                        <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                        </span>
                      @enderror 
                    </div>
                    <div class="col-sm-4 mb-3" >
                      <label for="both_variations_rubber_item_code" class="form-label">Item Code</label>
                      <input type="text" name="both_variations_rubber_item_code" id="both_variations_rubber_item_code" class="form-control @error('both_variations_rubber_item_code') is-invalid @enderror" placeholder="Enter iten code" value="{{ old('both_variations_rubber_item_code') }}" >       
                      @error('both_variations_rubber_item_code')
                        <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                        </span>
                      @enderror
                    </div>
                  </div>
                  
                  <div class="form-group row">
                    <div class="col-sm-4 mb-3" >
                      <label for="both_variations_rubber_image" class="form-label">Product Image</label>
                      <input type="file" name="both_variations_rubber_image" id="both_variations_rubber_image" class="form-control @error('both_variations_rubber_image') is-invalid @enderror"  value="{{ old('both_variations_rubber_image') }}" >  
                      <p class="image-dimesion-label">For best results, use 900 px by 1438 px image</p>     
                      @error('both_variations_rubber_image')
                        <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                        </span>
                      @enderror 
                    </div>


                    <div class="col-sm-4 mb-3" >
                      <label for="both_variations_rubber_strap_image" class="form-label">Strap Image</label>
                      <input type="file" name="both_variations_rubber_strap_image" id="both_variations_rubber_strap_image" class="form-control @error('both_variations_rubber_strap_image') is-invalid @enderror"  value="{{ old('both_variations_rubber_strap_image') }}" >  
                       <p class="image-dimesion-label">For best results, use 328 px by 100 px image</p>     
                      @error('both_variations_rubber_strap_image')
                        <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                        </span>
                      @enderror
                    </div>

                    <div class="col-sm-4 mb-3" >
                      <label for="both_variations_rubber_night_image" class="form-label">Night View Image</label>
                      <input type="file" name="both_variations_rubber_night_image" id="both_variations_rubber_night_image" class="form-control @error('both_variations_rubber_night_image') is-invalid @enderror"  value="{{ old('both_variations_rubber_night_image') }}" >  
                       <p class="image-dimesion-label">For best results, use 900 px by 1438 px image</p>     
                      @error('both_variations_rubber_night_image')
                        <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                        </span>
                      @enderror
                    </div>

                  </div>
              
                  <div class="form-group row">

                    <div class="col-sm-8 mb-12" >
                      <label for="both_variations_rubber_description" class="form-label">Product Description</label>
                      <textarea  name="both_variations_rubber_description"  id="both_variations_rubber_description" placeholder="Description">{{ old('both_variations_rubber_description') }}</textarea> @error('both_variations_rubber_description')
                        <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                        </span>
                      @enderror 
                    </div>

                    <div class="col-sm-4 mb-3" >
                      <label for="both_variations_rubber_gallery_images" class="form-label">Gallery Image</label>                      
                      <div class="both-variations-rubber-gallery-images"></div> 
                      <p class="image-dimesion-label">For best results, use 900 px by 900 px image</p>
                    </div>

                  </div>

                </div>
              </div>

              </div>
            </div>
          </div>
        </div>
        <div class="card custom_card mb-3">
          <div class="collapse-box">
            <a class="collapse-border-box" data-bs-toggle="collapse" href="#createProductKeyFeature" role="button" aria-expanded="false" aria-controls="pageProductKeyFeature">
              <span class="fs-6 title">Product Key Features-</span> 
              <span class="icon">
                <i class="lni lni-chevron-down"></i>
                <i class="lni lni-chevron-up"></i>
              </span>
            </a>
            <div class="collapse" id="createProductKeyFeature">
              <div class="collapse-content">
                <div class="card-body">
                  <div class="form-group row">
                    <div class="col-sm-12 mb-6" >
                    <table class="table table-bordered" id="dynamicAddRemoveKeyFeature">
                        <tr>
                          <th>Image</th>
                          <th>Label</th>
                          <th>Value</th>
                          <th>Action</th>
                        </tr>
                        <tr>
                          <td><input type="file" name="key_features[0][image]" placeholder="Upload image" class="form-control" /></td>
                          <td><input type="text" name="key_features[0][label]" placeholder="Enter Label" class="form-control" /></td>
                          <td><input type="text" name="key_features[0][value]" placeholder="Enter Value" class="form-control" /></td>
                          <td><button type="button" name="add" id="dynamic-kf" class="btn btn-outline-primary">Add Key Feature</button></td>
                        </tr>
                    </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>        
        <div class="card custom_card mb-3">
          <div class="collapse-box">
            <a class="collapse-border-box" data-bs-toggle="collapse" href="#createProductDataTech" role="button" aria-expanded="false" aria-controls="pageSeoSettings">
              <span class="fs-6 title">Product Technical Data-</span> 
              <span class="icon">
                <i class="lni lni-chevron-down"></i>
                <i class="lni lni-chevron-up"></i>
              </span>
            </a>
            <div class="collapse" id="createProductDataTech">
              <div class="collapse-content">
                <div class="card-body">
                  <div class="form-group row">
                    <div class="col-sm-12 mb-6" >
                    <table class="table table-bordered" id="dynamicAddRemove">
                        <tr>
                          <th>Label</th>
                          <th>Value</th>
                          <th>Action</th>
                        </tr>
                        <tr>
                          <td><input type="text" name="specification[0][label]" placeholder="Enter Label" class="form-control" /></td>
                          <td><input type="text" name="specification[0][value]" placeholder="Enter Value" class="form-control" /></td>
                          <td><button type="button" name="add" id="dynamic-ar" class="btn btn-outline-primary">Add Specification Item</button></td>
                        </tr>
                    </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        
        <div class="card custom_card mb-3">
          <div class="collapse-box">
            <a class="collapse-border-box" data-bs-toggle="collapse" href="#createProductStory" role="button" aria-expanded="false" aria-controls="ProductStory">
              <span class="fs-6 title">Product Story-</span> 
              <span class="icon">
                <i class="lni lni-chevron-down"></i>
                <i class="lni lni-chevron-up"></i>
              </span>
            </a>
            <div class="collapse" id="createProductStory">
              <div class="collapse-content">
                <div class="card-body">
                  <div class="form-group row">
                    <div class="col-sm-6 mb-3" >
                      <label for="copyright_text" class="form-label">Story Title</label>
                      <input type="text" name="story_title" class="form-control" value="{{ old('story_title') }}" >
                    </div>
                     <div class="col-sm-6 mb-3">          
                    <label  class="form-label">Story Image</label>  
                    <input type="file" name="story_image" id="story_image" class="form-control @error('story_image') is-invalid @enderror" value="{{ old('story_image') }}" >  
                     <p class="image-dimesion-label">For best results, use 900 px by 1438 px image</p>     
                      @error('story_image')
                        <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                        </span>
                      @enderror                           
                     </div>
                  </div>

                  <div class="form-group row">
                    <div class="col-sm-12" >                          
                      <label for="copyright_text" class="form-label">Story Description</label>
                      <textarea name="story_description" id="story_description" class="form-control" rows="4" >{{ old('story_description') }}</textarea>
                    </div>             
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div> 

        <div class="card custom_card mb-3">
          <div class="collapse-box">
            <a class="collapse-border-box" data-bs-toggle="collapse" href="#createProductmerchant" role="button" aria-expanded="false" aria-controls="pageProductmerchant">
              <span class="fs-6 title">Product Merchandising-</span> 
              <span class="icon">
                <i class="lni lni-chevron-down"></i>
                <i class="lni lni-chevron-up"></i>
              </span>
            </a>
            <div class="collapse" id="createProductmerchant">
              <div class="collapse-content">
                <div class="card-body">
                  <div class="form-group row">
                    <div class="col-sm-12 mb-6" >
                       <div class="merchandising_images"></div> 
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>  


        <div class="card custom_card mb-3">
          <div class="collapse-box">
            <a class="collapse-border-box" data-bs-toggle="collapse" href="#createProductSeoSettings" role="button" aria-expanded="false" aria-controls="pageSeoSettings">
              <span class="fs-6 title">SEO Settings- </span> 
              <span class="icon">
                <i class="lni lni-chevron-down"></i>
                <i class="lni lni-chevron-up"></i>
              </span>
            </a>
            <div class="collapse" id="createProductSeoSettings">
              <div class="collapse-content">
                <div class="card-body">
                  <div class="form-group row">
                    <div class="col-sm-6 mb-3" >
                      <label for="copyright_text" class="form-label">Meta-title</label>
                      <input type="text" name="meta_title" class="form-control" value="{{ old('meta_title') }}" >
                    </div>
                    <div class="col-sm-6 mb-3" >                          
                      <label for="copyright_text" class="form-label">Meta-keywords</label>                           
                      <input type="text" name="meta_keywords" class="form-control" value="{{ old('meta_keywords') }}" >
                    </div>
                  </div>
                  <div class="form-group row">
                    <div class="col-sm-12" >                          
                      <label for="copyright_text" class="form-label">Meta-description</label>
                      <textarea name="meta_description" class="form-control" rows="4" >{{ old('meta_description') }}</textarea>
                    </div>             
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div> 



      </div>
      <div class="col-sm-3">
        <div class="setting-wrap">
          <div class="card mb-3">
            <div class="border-bottom">            
              <a class="collapse-border-box" data-bs-toggle="collapse" href="#productInfo" role="button" aria-expanded="true" aria-controls="pageSeoSettings">
                <span class="title">Publish </span> 
                <span class="icon">
                  <i class="lni lni-chevron-down"></i>
                  <i class="lni lni-chevron-up"></i>
                </span>
              </a>
            </div>
            <div class="card-body">
              <div class="collapse show" id="productInfo">
                <div class="mb-3">
                  <label for="status" class="form-label">Status</label>
                  <select class="form-select" name="status" id="status">
                    <option value="" disabled>Select Status</option>
                    <option value="0">Disable</option>
                    <option value="1" selected>Enable</option>
                  </select>
                  @error('status')
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                  @enderror  
                </div>               
              </div> 
              <div class="w-100 text-end">
                <button type="submit" id="submitbtn" class="btn btn-primary custom-dark-btn w-30">Save</button>
              </div>
            </div> 
          </div>
          <div class="card mb-3">
            <div class="">           
              <a class="collapse-border-box" data-bs-toggle="collapse" href="#productCategories" role="button" aria-expanded="true" aria-controls="pageSeoSettings">
                <span class="title">Product Categories </span> 
                <span class="icon">
                  <i class="lni lni-chevron-down"></i>
                  <i class="lni lni-chevron-up"></i>
                </span>
              </a>
            </div>              
            <div class="collapse show" id="productCategories">
              <div class="card-body border-top">                  
                <div class="row">
                   <span class="text-danger" id="cat_sel_message" style="display:none">Select atleast one category</span>
                  @foreach($collection_list as $val)
                    <div class="col-sm-12">
                      <div class="form-check">
                        <input class="form-check-input" name="collection[]" type="checkbox" value="{{$val->id}}" id="category" >
                        <label class="form-check-label" for="category1">{{$val->name}}</label>
                      </div>
                      
                    </div>
                  @endforeach
                 
                   
                </div>
              </div>        
            </div>              
          </div>

          <div class="card mb-3">
            <div class="">           
              <a class="collapse-border-box" data-bs-toggle="collapse" href="#productTags" role="button" aria-expanded="true" aria-controls="pageSeoSettings">
                <span class="title">Product Images </span> 
                <span class="icon">
                  <i class="lni lni-chevron-down"></i>
                  <i class="lni lni-chevron-up"></i>
                </span>
              </a>
            </div>              
            <div class="collapse show" id="productTags">
              <div class="card-body border-top">                  
                <div class="row">
                  <div class="col-sm-12 mb-3">
                    <label for="logo" class="form-label">Featured Image</label>
                    <input type="file" class="form-control @error('featured_image') is-invalid @enderror" name="featured_image" id="featured_image" placeholder="Please upload featured image " onchange="loadFeaturedImage()">
                    <p class="image-dimesion-label">For best results, use 900 px by 1438 px image</p>
                    <img id="featured_image_demo"  class="img-thumbnail" style="display:none; max-width: 30% !important;"/>
                    @error('featured_image')
                      <span class="invalid-feedback" role="alert">
                        {{ $message }}
                      </span>
                    @enderror                    
                  </div>
                
                </div>
              </div>        
            </div>              
          </div> 

          <div class="card mb-3">
            <div class="">           
              <a class="collapse-border-box" data-bs-toggle="collapse" href="#productTags" role="button" aria-expanded="true" aria-controls="pageSeoSettings">
                <span class="title">Product Night View Images </span> 
                <span class="icon">
                  <i class="lni lni-chevron-down"></i>
                  <i class="lni lni-chevron-up"></i>
                </span>
              </a>
            </div>              
            <div class="collapse show" id="productTags">
              <div class="card-body border-top">                  
                <div class="row">
                  <div class="col-sm-12 mb-3">
                    <label for="logo" class="form-label">Night View Image</label>
                    <input type="file" class="form-control @error('night_view_image') is-invalid @enderror" name="night_view_image" id="night_view_image" placeholder="Please upload night view image " onchange="loadnightfeaturedimage()">
                    <p class="image-dimesion-label">For best results, use 900 px by 1438 px image</p>
                    <img id="night_view_image_demo"  class="img-thumbnail" style="display:none; max-width: 30% !important;"/>
                    @error('night_view_image')
                      <span class="invalid-feedback" role="alert">
                        {{ $message }}
                      </span>
                    @enderror                    
                  </div>
                
                </div>
              </div>        
            </div>              
          </div>

            <div class="card mb-3">
            <div class="">           
              <a class="collapse-border-box" data-bs-toggle="collapse" href="#featured_images" role="button" aria-expanded="true" aria-controls="pageSeoSettings">
                <span class="title">Gallery Images</span> 
                <span class="icon">
                  <i class="lni lni-chevron-down"></i>
                  <i class="lni lni-chevron-up"></i>
                </span>
              </a>
            </div>              
            <div class="collapse show" id="featured_images">
              <div class="card-body border-top">                  
                <div class="row">
                  <div class="col-sm-12 mb-3">                    
                    <div class="col-sm-12">
                      <label for="logo" class="col-sm-12 form-label">Upload Gallery Images</label>    
                      <p class="image-dimesion-label">For best results, use 900 px by 900 px image</p>              
                      <div class="input-images"></div>
                      <span class="text-danger" id="main_gallery_sel_message" style="display:none">Upload atleast one image</span>
                      @error('images')
                        <span class="invalid-feedback" role="alert">
                          {{ $message }}
                        </span>
                      @enderror  
                    </div>                    
                  </div>                  
                </div>
              </div>        
            </div>              
          </div> 
        </div>
      </div>
    </div>  
  </form>
</div>
<script>
  CKEDITOR.replace('description'); 
  CKEDITOR.replace('only_steel_variant_description'); 
  CKEDITOR.replace('only_rubber_variant_description');
  CKEDITOR.replace('both_variations_steel_description');
  CKEDITOR.replace('both_variations_rubber_description');
  CKEDITOR.replace('story_description');                 
</script>
 
<script>
 


  $('.merchandising_images').imageUploader({
    preloaded: [],
    imagesInputName: 'merchandising_images',
    preloadedInputName: 'merchandising_images',
    label: 'Drag & Drop files here or click to browse'
  });


  $('.only-steel-gallery-images').imageUploader({
    preloaded: [],
    imagesInputName: 'only_steel_gallery_images',
    preloadedInputName: 'only_steel_gallery_images',
    label: 'Drag & Drop files here or click to browse'
  });

  $('.only-rubber-gallery-images').imageUploader({
    preloaded: [],
    imagesInputName: 'only_rubber_gallery_images',
    preloadedInputName: 'only_rubber_gallery_images',
    label: 'Drag & Drop files here or click to browse'
  });

  $('.both-variations-steel-gallery-images').imageUploader({
    preloaded: [],
    imagesInputName: 'both_variations_steel_gallery_images',
    preloadedInputName: 'both_variations_steel_gallery_images',
    label: 'Drag & Drop files here or click to browse'
  });

  $('.both-variations-rubber-gallery-images').imageUploader({
    preloaded: [],
    imagesInputName: 'both_variations_rubber_gallery_images',
    preloadedInputName: 'both_variations_rubber_gallery_images',
    label: 'Drag & Drop files here or click to browse'
  });
</script>



<style type="text/css">
  input[type="file"] {
  display: block;
}
.imageThumb {
  max-height: 75px;
  border: 2px solid;
  padding: 1px;
  cursor: pointer;
}
.steel-bracelet {
  display: inline-block;
  margin: 10px 10px 0 0;
}
.remove {
  display: block;
  background: #444;
  border: 1px solid black;
  color: white;
  text-align: center;
  cursor: pointer;
}
.remove:hover {
  background: white;
  color: black;
}
</style>
<script>
  $('.input-images').imageUploader();
</script>


<script>


  //Add PRODUCT FORM
$(document).ready(function () {
        $("#add_product_form").submit(function (e) {
            var $form = $("form[name='product_form']");
            
            //general content
            $('#name, #color ,#featured_image ').each(function() {              
              if ($(this).val().length == 0) {
                $(this).addClass('is-invalid');
                e.preventDefault();                 
              }else{
                $(this).removeClass('is-invalid');
              }
            });

            if($('#category:checked').val() == undefined){   
                $("#cat_sel_message").show();                     
                e.preventDefault();
            }else{                 
                $("#cat_sel_message").hide();
            }

            if($('.uploaded-image').length == 0){   
                $("#main_gallery_sel_message").show();                     
                e.preventDefault();
            }else{                 
                $("#main_gallery_sel_message").hide();
            }

            //product type validations
            var selected_variant=$('#product_type').val();

            if(selected_variant == "simple"){  
              $('#simple_price, #simple_stock , #simple_item_code').each(function() {              
              if ($(this).val().length == 0) {
                $(this).addClass('is-invalid');
                e.preventDefault();                 
              }else{
                $(this).removeClass('is-invalid');
              }
            });

            }else if(selected_variant== "only_steel_variant"){

              $('#only_steel_variant_price, #only_steel_variant_stock , #only_steel_variant_item_code , #only_steel_variant_image , #only_steel_variant_strap_image').each(function() {              
              if ($(this).val().length == 0) {
                $(this).addClass('is-invalid');
                e.preventDefault();                 
              }else{
                $(this).removeClass('is-invalid');
              }
              });


            }else if(selected_variant== "only_rubber_variant"){
              
              $('#only_rubber_variant_price, #only_rubber_variant_stock , #only_rubber_variant_item_code , #only_rubber_variant_image , #only_rubber_variant_strap_image').each(function() {              
              if ($(this).val().length == 0) {
                $(this).addClass('is-invalid');
                e.preventDefault();                 
              }else{
                $(this).removeClass('is-invalid');
              }
              });

            }else if(selected_variant== "both_variations"){
              $('#both_variations_steel_price, #both_variations_steel_stock , #both_variations_steel_item_code , #both_variations_steel_image , #both_variations_steel_strap_image ,  #both_variations_rubber_price , #both_variations_rubber_stock, #both_variations_rubber_item_code, #both_variations_rubber_image, #both_variations_rubber_strap_image').each(function() {              
              if ($(this).val().length == 0) {
                $(this).addClass('is-invalid');
                e.preventDefault();                 
              }else{
                $(this).removeClass('is-invalid');
              }
              });
            }
             return true;                     
        });

  // Bulk image upload for steel  bravlet

  if (window.File && window.FileList && window.FileReader) {
    $("#both_variations_steel_gallery_images").on("change", function(e) {
      var files = e.target.files,
      filesLength = files.length;
      for (var i = 0; i < filesLength; i++) {
        var f = files[i]
        var fileReader = new FileReader();
        fileReader.onload = (function(e) {
          var file = e.target;
          $("<input type='file' name='both_variations_steel_gallery_images[]' value=\"" + f + "\">" +
            "<span class=\"steel-bracelet\">" +
            "<img class=\"imageThumb\" src=\"" + e.target.result + "\" title=\"" + file.name + "\"/>" +
            "<br/><span class=\"remove\"><i class='fa fa-remove'></i></span>" +
            "</span>").insertAfter("#both_variations_steel_gallery_images");
          $(".remove").click(function(){
            $(this).parent(".steel-bracelet").remove();
          });
          
        });
        fileReader.readAsDataURL(f);
      }
    });
  } else {
    alert("Somthing went Wrong")
  }
    });

</script>
<script>
  function loadFeaturedImage(){
    $('#featured_image_demo').show();
    $('#featured_image_demo').attr('src', URL.createObjectURL(event.target.files[0]));
  }
  $("#featured_image").change(function () {    
    var fileExtension = ['jpeg', 'jpg', 'png','gif'];
    var filesize=(this.files[0].size);

    if($.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) == -1) {
         swal("Only " +fileExtension.join(', ') +" formats are allowed");
           document.getElementById("featured_image").value = "";
           $('#featured_image_demo').hide();
    }

    if(filesize > 1000000) {
       swal("Please do not upload image of more than 1 Mb size");
       document.getElementById("featured_image").value = "";
           $('#featured_image_demo').hide();
    }

     
  }); 


  function loadnightfeaturedimage(){
    $('#night_view_image_demo').show();
    $('#night_view_image_demo').attr('src', URL.createObjectURL(event.target.files[0]));
  }

  $("#night_view_image").change(function () {    
    var fileExtension = ['jpeg', 'jpg', 'png','gif'];
    var filesize=(this.files[0].size);
    if($.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) == -1) {
         swal("Only " +fileExtension.join(', ') +" formats are allowed");
           document.getElementById("night_view_image").value = "";
           $('#night_view_image_demo').hide();
    }

    if(filesize > 1000000) {
       swal("Please do not upload image of more than 1 Mb size");
       document.getElementById("night_view_image").value = "";
           $('#night_view_image_demo').hide();
    }     
  }); 

  function loadGalleryImage(){
    $('#gallery_image_demo').show();
    $('#gallery_image_demo').attr('src', URL.createObjectURL(event.target.files[0]));
  }
  $("#gallery_image").change(function () {    
    var fileExtension = ['jpeg', 'jpg', 'png','gif'];
    $('#gallery_image_demo').show();
    $('#gallery_image_demo').attr('src', URL.createObjectURL(event.target.files[0]));
  });  
</script>
@endsection