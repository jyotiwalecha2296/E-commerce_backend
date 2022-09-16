@extends('admin.layouts.app') 
@section('content')
<link type="text/css" rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<link type="text/css" rel="stylesheet" href="{{asset('public/multipleimages/image-uploader.min.css')}}">
<script type="text/javascript" src="{{asset('public/multipleimages/image-uploader.min.js')}}"></script>
<div class="container-fluid pt-5">
  <style>
    .image-uploader .upload-text i {
      display: none !important;
    }
    .image-uploader.has-files .upload-text {
      display: block !important;
    }
    .image-uploader .upload-text {
      position: inherit !important;
    }
  </style>
  <span class="title-data" id="titleData" data-link="products/{{$data->product_id}}/edit" data-parent="products" data-title="Edit Product"></span> 

  <form role="form" data-parsley-validate="" method="POST" action="{{url('update_product')}}" id="edit_product_form" name="edit_product_form"  enctype="multipart/form-data">
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
            <input type="hidden" value="{{$data->product_id}}" name="product_id"> 
            <div class="form-group row">
              <div class="col-sm-6 mb-3">
                <label for="name" class="form-label">Name</label>              
                <input type="text" name="name" id="name" class="form-control  @error('name') is-invalid @enderror" placeholder="Enter Name" value="{{$data->name}}" >              
                @error('name')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                @enderror 
              </div>
              <div class="col-sm-6 mb-3">          
                <label  class="form-label">Product Color</label>                             
                <input type="text" name="color" id="color" class="form-control @error('color') is-invalid @enderror" placeholder="Please write product color" value="{{$data->color}}">
                @error('color')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                @enderror 
              </div>   
            </div>
            


            @if(($data->is_steel=="0") && ($data->is_rubber=="0"))
             <div class="form-group row">
                    <div class="col-sm-4 mb-3" >
                      <label for="simple_price" class="form-label">Product Price ($)</label>
                      <input type="number" name="simple_price" class="form-control save_product_price @error('simple_price') is-invalid @enderror" id="simple_price" placeholder="Enter price" value="{{ $data->Price }}" >       
                      @error('simple_price')
                        <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                        </span>
                      @enderror 
                    </div>

                    <div class="col-sm-4 mb-3" >
                      <label for="simple_stock" class="form-label">Product Stock</label>
                      <input type="number" name="simple_stock" class="form-control @error('simple_stock') is-invalid @enderror" id="simple_stock" placeholder="Enter stock" value="{{ $data->stock }}" >       
                      @error('simple_stock')
                        <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                        </span>
                      @enderror 
                    </div>                  
                   
                    <div class="col-sm-4 mb-3" >
                      <label for="simple_item_code" class="form-label">Item Code</label>
                      <input type="text" name="simple_item_code" class="form-control @error('simple_item_code') is-invalid @enderror" id="simple_item_code" placeholder="Enter item code" value="{{ $data->item_code}}" >       
                      @error('simple_item_code')
                        <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                        </span>
                      @enderror
                    </div>                 
                  </div>
            @endif

            <div class="form-group row">
              <div class="col-sm-12 mb-3">         
                <label  class="">Description</label>                               
                <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror" placeholder="Please write description here" rows="5">{{htmlspecialchars_decode(str_replace("&quot;", "\"",$data->description))}}</textarea>
                <script>
                  CKEDITOR.replace('description');
                </script>


                @error('description')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror 
              </div>          
            </div>


        
          </div>          
        </div>

        @if(($data->is_steel=="1") || ($data->is_rubber=="1"))
          @if($data->is_steel=="1")
          <div class="card custom_card mb-3">
            <div class="collapse-box">
              <a class="collapse-border-box" data-bs-toggle="collapse" href="#createProductData" role="button" aria-expanded="true" aria-controls="pageSeoSettings">
                <span class="fs-6 title">Product Data-(Steel Braclet)</span> 
                <span class="icon">
                  <i class="lni lni-chevron-down"></i>
                  <i class="lni lni-chevron-up"></i>
                </span>
              </a>
              <div class="collapse show" id="createProductData">
                <div class="collapse-content">
                  <div class="card-body">
                    <input type="hidden" name="steel_product_id" value="{{$data->steel_product_id}}">                   
                    <div class="form-group row">
                      <div class="col-sm-4 mb-3" >
                        <label for="steel_price" class="form-label">Product Price ($)</label>
                        <input type="number" name="steel_price" id="steel_price" class="form-control save_product_price @error('steel_price') is-invalid @enderror" placeholder="Enter price"  @if($data->steel_price != null) value="{{$data->steel_price}}" @else value="{{ old('steel_price') }}" @endif > 
                        @error('steel_price')
                          <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                          </span>
                        @enderror 
                      </div>

                      <div class="col-sm-4 mb-3" >
                        <label for="Steel_t_stock" class="form-label">Product Stock</label>    
                        <input type="number" name="steel_stock" id="steel_stock" class="form-control @error('steel_stock') is-invalid @enderror" placeholder="Enter stock" @if($data->steel_stock != null) value="{{$data->steel_stock}}" @else value="{{ old('steel_stock') }}" @endif >                        
                        @error('steel_stock')
                          <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                          </span>
                        @enderror 
                      </div>
                      
                       <div class="col-sm-4 mb-3" >
                        <label for="product_price" class="form-label">Item Code</label>    
                        <input type="text" name="steel_item_code" id="steel_item_code"  class="form-control @error('steel_item_code') is-invalid @enderror" placeholder="Enter item code" @if($data->steel_item_code != null) value="{{$data->steel_item_code}}" @else value="{{ old('steel_item_code') }}" @endif>                 
                        @error('steel_item_code')
                          <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                          </span>
                        @enderror
                      </div>

                    </div>

                    <div class="form-group row">
                       <div class="col-sm-4 mb-3" >
                        <label for="steel_image" class="form-label">Featured Image</label>
                        <input type="file" name="steel_image" id="steel_image" class="form-control @error('steel_image') is-invalid @enderror" placeholder="Upload imgae" value="{{ old('steel_image') }}">
                          <p class="image-dimesion-label">For best results, use 900 px by 1438 px image</p>
                            @if($data->steel_image != null)
                            <img src="{{asset($data->steel_image ?: 'public/watch_placeholder.png')}}" height="120" width="120" />
                            <input type="hidden" value="{{$data->steel_image}}" name="old_steel_image">
                            @endif                              
                        @error('steel_image')
                          <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                          </span>
                        @enderror 
                      </div>

                      <div class="col-sm-4 mb-3" >
                        <label for="steel_image" class="form-label">Night View Image</label>
                        <input type="file" name="steel_night_view_image" id="steel_night_view_image" class="form-control @error('steel_night_view_image') is-invalid @enderror" placeholder="Upload imgae" value="{{ old('steel_night_view_image') }}">
                          <p class="image-dimesion-label">For best results, use 900 px by 1438 px image</p>
                            @if($data->steel_night_view_image != null)
                            <img src="{{asset($data->steel_night_view_image ?: 'public/watch_placeholder.png')}}" height="120" width="120" />
                            <input type="hidden" value="{{$data->steel_night_view_image}}" name="old_steel_night_view_image">
                            @endif                              
                        @error('steel_night_view_image')
                          <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                          </span>
                        @enderror 
                      </div>

                      <div class="col-sm-4 mb-3" >
                        <label for="steel_image" class="form-label">Strap Image</label>
                         <input type="file" name="steel_strap_image" id="steel_strap_image"  class="form-control @error('steel_strap_image') is-invalid @enderror" placeholder="Upload imgae" value="{{ old('steel_strap_image') }}" >
                          <p class="image-dimesion-label">For best results, use 328 px by 100 px image</p>
                            @if($data->steel_strap_image != null)
                            <img src="{{asset($data->steel_strap_image ?: 'public/watch_placeholder.png')}}" height="50" width="180" />
                            <input type="hidden" value="{{$data->steel_strap_image}}" name="old_steel_strap_image">
                            @endif                              
                        @error('steel_strap_image')
                          <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                          </span>
                        @enderror 
                      </div>

                      
                    </div>

                    <div class="form-group row">
                      <div class="col-sm-8 mb-3" >
                        <label for="steel_description" class="form-label">Product Description</label>
                        <textarea name="steel_description" id="steel_description" class="form-control @error('steel_description') is-invalid @enderror" placeholder="Please write steel description here" rows="5">{{htmlspecialchars_decode(str_replace("&quot;", "\"",$data->steel_description))}}</textarea>                      
                        <script>
                            CKEDITOR.replace('steel_description');
                        </script>

                        @error('steel_description')
                          <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                          </span>
                        @enderror 
                      </div>

                      <div class="col-sm-4 mb-3" >
                        <label for="steel_gallery_image" class="form-label">Gallery Images</label>
                        
                        <div class="steel-gallery-images"></div>
                        <p class="image-dimesion-label">For best results, use 900 px by 900 px image</p>
                         
                      </div>
                    </div>
                    
                  </div>
                </div>
              </div>
            </div>
          </div>
          @endif
        
          @if($data->is_rubber=="1")
          <div class="card custom_card mb-3">
            <div class="collapse-box">
              <a class="collapse-border-box" data-bs-toggle="collapse" href="#createProductDataRubber" role="button" aria-expanded="true" aria-controls="pageSeoSettings">
                <span class="fs-6 title">Product Data-(Rubber Strap)</span> 
                <span class="icon">
                  <i class="lni lni-chevron-down"></i>
                  <i class="lni lni-chevron-up"></i>
                </span>
              </a>
              <div class="collapse show" id="createProductDataRubber">
                <div class="collapse-content">
                  <div class="card-body">

                    <input type="hidden" name="rubber_product_id" value="{{$data->rubber_product_id}}">
                    <div class="form-group row">
                      <div class="col-sm-4 mb-3" >
                        <label for="rubber_price" class="form-label">Product Price ($)</label>
                        <input type="number" name="rubber_price"  id="rubber_price" class="form-control save_product_price @error('rubber_price') is-invalid @enderror" placeholder="Enter price" @if($data->rubber_price != null) value="{{$data->rubber_price}}" @else value="{{ old('rubber_price') }}" @endif>       
                        @error('rubber_price')
                          <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                          </span>
                        @enderror 
                      </div>

                      <div class="col-sm-4 mb-3" >
                        <label for="rubber_t_stock" class="form-label">Product Stock</label>
                        <input type="number" name="rubber_stock"  id="rubber_stock" class="form-control @error('rubber_stock') is-invalid @enderror" placeholder="Enter stock" @if($data->rubber_stock != null) value="{{$data->rubber_stock}}" @else value="{{ old('rubber_stock') }}" @endif>       
                        @error('rubber_stock')
                          <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                          </span>
                        @enderror 
                      </div>

                      <div class="col-sm-4 mb-3" >
                        <label for="product_price" class="form-label">Item Code</label>
                        <input type="text" name="rubber_item_code" id="rubber_item_code" class="form-control @error('rubber_item_code') is-invalid @enderror" placeholder="Enter iten code" @if($data->rubber_item_code != null) value="{{$data->rubber_item_code}}" @else value="{{ old('rubber_item_code') }}" @endif>       
                        @error('rubber_item_code')
                          <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                          </span>
                        @enderror
                      </div>
                    </div>

                    <div class="form-group row">

                      <div class="col-sm-4 mb-3" >
                        <label for="rubber_. image" class="form-label">Featured Image</label>
                      <input type="file" name="rubber_image" id="rubber_image" class="form-control @error('rubber_image') is-invalid @enderror" placeholder="Upload image" value="{{old('rubber_image')}}"> <p class="image-dimesion-label">For best results, use 900 px by 1438 px image</p> 
                        @if($data->rubber_image != null)
                            <img src="{{asset($data->rubber_image ?: 'public/watch_placeholder.png')}}" height="120" width="120" />
                            <input type="hidden" value="{{$data->rubber_image}}" name="old_rubber_image">
                            @endif     
                        @error('rubber_image')
                          <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                          </span>
                        @enderror 
                      </div>

                      <div class="col-sm-4 mb-3" >
                      <label for="rubber_. image" class="form-label">Night View Image</label>
                      <input type="file" name="rubber_night_view_image" id="rubber_night_view_image" class="form-control @error('rubber_night_view_image') is-invalid @enderror" placeholder="Upload image" value="{{old('rubber_night_view_image')}}"> <p class="image-dimesion-label">For best results, use 900 px by 1438 px image</p> 
                        @if($data->rubber_night_view_image != null)
                            <img src="{{asset($data->rubber_night_view_image ?: 'public/watch_placeholder.png')}}" height="120" width="120" />
                            <input type="hidden" value="{{$data->rubber_night_view_image}}" name="old_rubber_night_view_image">
                            @endif     
                        @error('rubber_image')
                          <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                          </span>
                        @enderror 
                      </div>

                      <div class="col-sm-4 mb-3" >
                        <label for="rubber_. image" class="form-label">Strap Image</label>
                        <input type="file" name="rubber_strap_image" id="rubber_strap_image"  class="form-control @error('rubber_strap_image') is-invalid @enderror" placeholder="Upload image" value="{{ old('rubber_strap_image') }}" > 
                         <p class="image-dimesion-label">For best results, use 328 px by 100 px image</p> 
                        @if($data->rubber_strap_image != null)
                            <img src="{{asset($data->rubber_strap_image ?: 'public/watch_placeholder.png')}}" height="50" width="180" />
                            <input type="hidden" value="{{$data->rubber_strap_image}}" name="old_rubber_strap_image">
                            @endif     
                        @error('rubber_strap_image')
                          <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                          </span>
                        @enderror 
                      </div>

                      

                    </div>


                    <div class="form-group row">
                      <div class="col-sm-8 mb-6" >
                        <label for="rubber_. description" class="form-label">Product Description</label>
                        <textarea name="rubber_description" id="rubber_description" class="form-control @error('rubber_description') is-invalid @enderror" placeholder="Please write steel description here" rows="5">{{htmlspecialchars_decode(str_replace("&quot;", "\"",$data->rubber_description))}}</textarea>    
                        <script>   
                          CKEDITOR.replace('rubber_description');                              
                        </script>   
                                               
                        @error('rubber_description')
                          <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                          </span>
                        @enderror 
                      </div>

                      <div class="col-sm-4 mb-6" >
                        <label for="rubber_. image" class="form-label">Gallery Image</label>
                        <div class="rubber-gallery-images"></div> 
                        <p class="image-dimesion-label">For best results, use 900 px by 900 px image</p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          @endif
        @endif

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
                    <table class="table table-bordered" id="editAddRemoveKeyFeature">
                        <tr>
                          <th>Image</th>
                          <th>Label</th>
                          <th>Value</th>
                          <th>Action</th>
                        </tr>

                        @if($data->key_features != null)
                        @foreach($data->key_features as $key_features)
                        <tr id="key_features_row_{{$loop->index}}">
                          <td>
                               <img src="{{asset($key_features['image'] ?: 'public/image_placeholder.png')}}" height="50" width="50" />
                               <input type="file" name="key_features[{{$loop->index}}][image]" placeholder="Upload image" class="form-control" />
                               <input type="hidden" name="key_features[{{$loop->index}}][oldfimage]" value="{{$key_features['image']}}"  placeholder="Upload image" class="form-control" />
                          </td>
                          <td><input type="text" name="key_features[{{$loop->index}}][label]" placeholder="Enter Label" class="form-control" value="{{ $key_features['label'] }}"/></td>
                          <td><input type="text" name="key_features[{{$loop->index}}][value]" placeholder="Enter Value" class="form-control" value="{{ $key_features['value'] }}"/></td>
                          <td><button type="button" class="btn btn-outline-danger remove-input-field">Delete</button></td>

                         </tr> 
                         @endforeach
                         @else
                         <tr  id="key_features_row_0">
                          <td><input type="file" name="key_features[0][image]" value="" placeholder="Upload image" class="form-control" /></td>
                          <td><input type="text" name="key_features[0][label]" value="" placeholder="Enter Label" class="form-control" /></td>
                          <td><input type="text" name="key_features[0][value]" value="" placeholder="Enter Value" class="form-control" /></td>
                          <td><button type="button" name="add" id="edit-dynamic-kf" class="btn btn-outline-primary">Add Key Feature</button></td>
                        </tr>
                        @endif
                    </table>
                    <button type="button" name="add" id="edit-dynamic-kf" class="btn btn-outline-primary custom-dark-btn">Add Key Feature</button>
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
                    <table class="table table-bordered" id="editspecificationstable">
                        <thead>
                          <th>Label</th>
                          <th>Value</th>
                          <th>Action</th>
                        </thead>
                 
                        @if($data->specification_data != null)
                        @foreach($data->specification_data as $specification_details)
                        <tr id="specification_row_{{$loop->index}}">
                          <td><input type="text" name="specification[{{$loop->index}}][label]" placeholder="Enter Label" class="form-control" value="{{ $specification_details['label'] }}"/></td>
                          <td><input type="text" name="specification[{{$loop->index}}][value]" placeholder="Enter Value" class="form-control" value="{{ $specification_details['value'] }}"/></td>
                          <td><button type="button" class="btn btn-outline-danger remove-input-field">Delete</button></td>
                         </tr> 
                         @endforeach
                         @else
                         <tr  id="specification_row_0">
                          <td><input type="text" name="specification[0][label]" placeholder="Enter Label" class="form-control" /></td>
                          <td><input type="text" name="specification[0][value]" placeholder="Enter Value" class="form-control" /></td>     
                          <td><button type="button" class="btn btn-outline-danger remove-input-field">Delete</button></td>
                        </tr>
                        @endif
                         
                    </table>
                    <button type="button" name="add" id="edit-dynamic-ar" class="btn btn-primary custom-dark-btn">Add Specification Item</button>
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
              <span class="fs-6 title">Product Story</span> 
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
                      <input type="text" name="story_title" class="form-control" value="{{$data->story_title}}" >
                    </div>
                   
                    <div class="col-sm-6 mb-3">          
                    <label  class="form-label">Story Image</label>                             
                       <input type="file" name="story_image" id="story_image"  class="form-control @error('story_image') is-invalid @enderror" placeholder="Upload image" value="{{ old('story_image') }}" >  <p class="image-dimesion-label">For best results, use 900 px by 1438 px image</p>
                        @if($data->story_image != null)
                            <img src="{{asset($data->story_image ?: 'public/image_placeholder.png')}}" height="120" width="120" />
                            <input type="hidden" value="{{$data->story_image}}" name="old_story_image">
                            @endif     
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
                      <textarea name="story_description" id="story_description" >{{htmlspecialchars_decode(str_replace("&quot;", "\"",$data->story_description))}}</textarea>
                          <script>                            
                          CKEDITOR.replace('story_description');                
                        </script>       
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
              <span class="fs-6 title">SEO Settings </span> 
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
                      <label for="copyright_text" class="col-sm-3 col-form-label">Meta-title</label>                        
                      <input type="text" name="meta_title" class="form-control field-validate" value="{{ $data->meta_title }}" >
                    </div>
                    <div class="col-sm-6 mb-3" >                     
                      <label for="copyright_text" class="col-sm-3 col-form-label">Meta-keywords</label>                        
                      <input type="text" name="meta_keywords" class="form-control field-validate" value="{{ $data->meta_keywords }}" >
                    </div>
                  </div>
                  <div class="form-group row">
                    <div class="col-sm-12" >                      
                      <label for="copyright_text" class="col-sm-3 col-form-label">Meta-description</label>                     
                      <textarea name="meta_description" class="form-control" rows="4" >{{ $data->meta_description }}</textarea>
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
                <span class="title">Update </span> 
                <span class="icon">
                  <i class="lni lni-chevron-down"></i>
                  <i class="lni lni-chevron-up"></i>
                </span>
              </a>
            </div>
            <div class="card-body">
              <div class="collapse show" id="productInfo">
                <!-- <div class="mb-3">
                  <p class="mb-1">
                    <span>Product Name: {{$data->name}}</span>
                    <span>Page Link: </span>
                    <span><a href="http://170.187.143.249/crm/products/{{$data->product_id}}/edit">http://170.187.143.249/crm/products/{{$data->product_id}}/edit</a></span>
                  </p>
                </div> -->
                <div class="mb-3">
                  <label for="status" class="form-label">Status</label>
                  <select class="form-select" name="status" id="status">                    
                    <option value="0" @if($data->status=="0") selected @endif >Disable</option>
                  <option value="1" @if($data->status=="1") selected @endif >Enable</option>
                  </select>
                   @error('status')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                @enderror 
                </div>       
                <div class="mb-3">
                  <label for="status" class="form-label">Product Line Type :- </label>
                    @if($data->product_line_type) {{ $data->product_line_type }} @endif
                   
                </div>               
              </div> 
              <div class="w-100 text-end">
                <button type="submit" class="btn btn-primary custom-dark-btn w-30">Update</button>
              </div>
            </div> 
          </div>
          <div class="card mb-3">
            <div class="">           
              <a class="collapse-border-box" data-bs-toggle="collapse" href="#productCategories" role="button" aria-expanded="true" aria-controls="pageSeoSettings">
                <span class="title">Product Categories </span>
                @error('collection')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror  
                <span class="icon">
                  <i class="lni lni-chevron-down"></i>
                  <i class="lni lni-chevron-up"></i>
                </span>
              </a>
            </div>              
            <div class="collapse show" id="productCategories">
              <div class="card-body border-top">                  
                <div class="row">
                  @php $col_array = explode(',',$data->collection_id); @endphp
                  @foreach($collection_list as $val)
                    <div class="col-sm-12">
                      <div class="form-check">
                        <input class="form-check-input" name="product_collection[]" type="checkbox" value="{{$val->id}}" id="category_{{$val->name}}" @if(in_array($val->id,$col_array)) checked @endif >
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
                    <label for="logo" class="col-sm-12 form-label">Featured Image</label>
                    <div class="col-sm-12 img-thumbnail">
                      <img src="{{ asset($data->featured_image ?: 'public/watch_placeholder.png') }}" alt="featured_image" class="img-fluid" style="max-width: 30% !important;">
                      
                    </div>
                    <div class="col-sm-12">
                      <input type="file" name="featured_image" id="featured_image"  onchange="loadfeaturedimage()">
                      <p class="image-dimesion-label">For best results, use 900 px by 1438 px image</p><br/>
                      <img id="featured_image_demo" class="img-fluid" style="max-width: 30% !important; display:none"/>                      
                      <input type="hidden" name="old_featured_image" value="{{$data->featured_image}}" >
                      @error('featured_image')
                      <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                      </span>
                      @enderror
                    </div>                    
                  </div>                  
                </div>
              </div>        
            </div>              
          </div>

         <div class="card mb-3">
            <div class="">           
              <a class="collapse-border-box" data-bs-toggle="collapse" href="#nightproductimage" role="button" aria-expanded="true" aria-controls="pageSeoSettings">
                <span class="title">Night View Featured Image </span> 
                <span class="icon">
                  <i class="lni lni-chevron-down"></i>
                  <i class="lni lni-chevron-up"></i>
                </span>
              </a>
            </div>              
            <div class="collapse show" id="nightproductimage">
              <div class="card-body border-top">                  
                <div class="row">
                  <div class="col-sm-12 mb-3">
                    <label for="logo" class="col-sm-12 form-label">Night View Featured Image</label>
                    <div class="col-sm-12 img-thumbnail">
                      <img src="{{ asset($data->night_view_image ?: 'public/watch_placeholder.png') }}" alt="Night View Image" class="img-fluid" style="max-width: 30% !important;">
                      
                    </div>
                    <div class="col-sm-12">
                      <input type="file" name="night_view_image" id="night_view_image"  onchange="loadnightfeaturedimage()">
                      <p class="image-dimesion-label">For best results, use 900 px by 1438 px image</p><br/>
                      <img id="night_view_image_demo" class="img-fluid" style="display:none; max-width: 30% !important;"/>                      
                      <input type="hidden" name="old_night_view_image" value="{{$data->night_view_image}}" >
                      @error('night_view_image')
                      <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                      </span>
                      @enderror
                    </div>                    
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
                       <div class="input-images-2"></div>
                       <p class="image-dimesion-label">For best results, use 900 px by 900 px image</p>
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
 

@if($data->merchandising_images != null)
 <script>
let merchandising_images = [
 <?php foreach(json_decode($data->merchandising_images) as $key => $val){ ?>
    {id: '<?php echo $val; ?>', src: '<?php echo $val; ?>'},
      <?php } ?>
];
$('.merchandising_images').imageUploader({
    preloaded: merchandising_images,
    imagesInputName: 'merchandising_images',
    preloadedInputName: 'oldmerchandisinggallery'
});  
</script>
@else
<script>
  $('.merchandising_images').imageUploader({
    preloaded: [],
    imagesInputName: 'merchandising_images',
    preloadedInputName: 'oldmerchandisinggallery',
    label: 'Drag & Drop files Steel Bracelet gallery Images here or click to browse'
  });
</script>
@endif

@if($data->steel_gallery_image != null)
 <script>
let steel_gallery_images = [
 <?php foreach(json_decode($data->steel_gallery_image) as $key => $val){ ?>
    {id: '<?php echo $val; ?>', src: '<?php echo $val; ?>'},
      <?php } ?>
];
$('.steel-gallery-images').imageUploader({
    preloaded: steel_gallery_images,
    imagesInputName: 'steel_gallery_images',
    preloadedInputName: 'old_steel_gallery_images'
});  
</script>
@else
<script>
  $('.steel-gallery-images').imageUploader({
    preloaded: [],
    imagesInputName: 'steel_gallery_images',
    preloadedInputName: 'old_steel_gallery_images',
    label: 'Drag & Drop files Steel Bracelet gallery Images here or click to browse'
  });
</script>
@endif

@if($data->rubber_gallery_image != null)
<script>
let rubber_gallery_images = [
 <?php foreach(json_decode($data->rubber_gallery_image) as $key => $val){ ?>
    {id: '<?php echo $val; ?>', src: '<?php echo $val; ?>'},
      <?php } ?>
];
$('.rubber-gallery-images').imageUploader({
    preloaded: rubber_gallery_images,
    imagesInputName: 'rubber_gallery_images',
    preloadedInputName: 'old_rubber_gallery_images'
});  
</script>
@else
<script>
  $('.rubber-gallery-images').imageUploader({
    preloaded: [],
    imagesInputName: 'rubber_gallery_images',
    preloadedInputName: 'old_rubber_gallery_images',
    label: 'Drag & Drop files Rubber Strap gallery Images here or click to browse'
  });
</script>
@endif




@if($data->gallery_images != null)
<script>     
let preloaded = [
 <?php foreach(json_decode($data->gallery_images) as $key => $val){ ?>
    {id: '<?php echo $val; ?>', src: '<?php echo $val; ?>'},
      <?php } ?>
];
$('.input-images-2').imageUploader({
    preloaded: preloaded,
    imagesInputName: 'images',
    preloadedInputName: 'oldgallery'
});
   
</script>
@else
<script>
  $('.input-images-2').imageUploader();
</script>
@endif

<!-- EDIT PRODUCT FORM -->
@if(($data->is_steel=="0") && ($data->is_rubber=="0"))
<script>
 $(document).ready(function () {
        $("#edit_product_form").submit(function (e) {
            var $form = $("form[name='edit_product_form']");
            
            //general content
            $('#name, #color ').each(function(){              
              if ($(this).val().length == 0) {
                $(this).addClass('is-invalid');
                e.preventDefault();                 
              }else{
                $(this).removeClass('is-invalid');
              }
            });
            
            $('#simple_price, #simple_stock , #simple_item_code').each(function(){              
              if ($(this).val().length == 0) {
                $(this).addClass('is-invalid');
                e.preventDefault();                 
              }else{
                $(this).removeClass('is-invalid');
              }
            });
            
            return true;                     
        });
  });
</script>
@elseif(($data->is_steel=="1") && ($data->is_rubber=="0"))
<script>
 $(document).ready(function () {
        $("#edit_product_form").submit(function (e) {
            var $form = $("form[name='edit_product_form']");
            
            //general content
            $('#name, #color , #description ').each(function(){              
              if ($(this).val().length == 0) {
                $(this).addClass('is-invalid');
                e.preventDefault();                 
              }else{
                $(this).removeClass('is-invalid');
              }
            });
            
            $('#steel_price, #steel_stock , #steel_item_code ').each(function(){              
              if ($(this).val().length == 0) {
                $(this).addClass('is-invalid');
                e.preventDefault();                 
              }else{
                $(this).removeClass('is-invalid');
              }
            });
            
            return true;                     
        });
  });
</script>
@elseif(($data->is_steel=="0") && ($data->is_rubber=="1"))
<script>
 $(document).ready(function () {
        $("#edit_product_form").submit(function (e) {
            var $form = $("form[name='edit_product_form']");
            
            //general content
            $('#name, #color , #description ').each(function(){              
              if ($(this).val().length == 0) {
                $(this).addClass('is-invalid');
                e.preventDefault();                 
              }else{
                $(this).removeClass('is-invalid');
              }
            });
            
            $('#rubber_price, #rubber_stock , #rubber_item_code ').each(function(){              
              if ($(this).val().length == 0) {
                $(this).addClass('is-invalid');
                e.preventDefault();                 
              }else{
                $(this).removeClass('is-invalid');
              }
            });
            
            return true;                     
        });
  });
</script>
@elseif(($data->is_steel=="1") && ($data->is_rubber=="1"))
<script>
 $(document).ready(function () {
        $("#edit_product_form").submit(function (e) {
            var $form = $("form[name='edit_product_form']");           
            //general content
            $('#name, #color , #description ').each(function(){              
              if ($(this).val().length == 0) {                
                $(this).addClass('is-invalid');
                e.preventDefault();                 
              }else{
                $(this).removeClass('is-invalid');
              }
            });
            
            $('#steel_price, #steel_stock , #steel_item_code ').each(function(){              
              if ($(this).val().length == 0) {
                $(this).addClass('is-invalid');
                e.preventDefault();                 
              }else{
                $(this).removeClass('is-invalid');
              }
            });

            $('#rubber_price, #rubber_stock , #rubber_item_code ').each(function(){              
              if ($(this).val().length == 0) {
                $(this).addClass('is-invalid');
                e.preventDefault();                 
              }else{
                $(this).removeClass('is-invalid');
              }
            });
            
            return true;                     
        });
  });
</script>
@endif


<script>

  function loadfeaturedimage(){
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

   
  }); 

</script>
@endsection