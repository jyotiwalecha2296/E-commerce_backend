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
<div class="container-fluid pt-5">
  <span class="title-data" id="titleData" data-link="collections/{{$data->id}}/edit" data-parent="collections" data-title="edit collection"></span>
  {!!Form::model($data,['method'=>'PATCH', 'route'=>['collections.update',$data->collection_id] ,'id'=>'form','files'=>'true' ,'data-parsley-validate' => '','name'=>'page_form']) !!}         
    {{ csrf_field() }}
    <div class="row">      
      <div class="col-lg-9 col-md-8 col-sm-7 order-2 order-sm-1">
        <div class="card custom_card mb-3">
          <div class="row">
            <div class="col-sm-12">
              <span class="fs-6">Collection Information</span>
            </div>
          </div>
          <div class="card-body">            
            <div class="form-group row">
              <div class="col-sm-6 mb-3">
                <label for="name" class="">Name</label>          
                <input type="text" name="name" class="form-control  @error('name') is-invalid @enderror" placeholder="Enter Name" value="{{$data->name}}">          
                @error('name')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                @enderror 
              </div>
               <div class="col-sm-6 mb-3 {{ $errors->has('value') ? 'has-error' :'' }}" > 
                <label for="value" class="form-label">Parent</label>
                <select class="form-select" name="parent_id" id="parent_id">
                  <option value=""  @if($data->parent_id=="0") selected @endif >None</option>
                  @foreach($list as $val)
                  <option value="{{$val->id}}" @if($val->id== $data->parent_id) selected @endif >{{$val->name}}</option>
                  @endforeach                                           
                </select>            
                @error('parent_id')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror 
              </div>

            </div>
            <div class="form-group row">
             <div class="col-sm-6 mb-3">
                      <label for="tagline" class="form-label">Tagline</label>              
                      <input type="text" name="tagline" class="form-control  @error('tagline') is-invalid @enderror" placeholder="Enter Tagline" value="{{ $data->tagline }}">              
                      @error('name')
                        <span class="invalid-feedback" role="alert">
                          {{ $message }}
                        </span>
                      @enderror
              </div>
              <div class="col-sm-6 mb-3">          
                    <label  class="form-label">Front Video</label>                             
                    <select class="form-select @error('video') is-invalid @enderror" name="video" id="position" aria-label=".form-select-lg example">
                    @foreach($filesnamedata as $vlink)
                      <option value="{{$vlink}}" @if($vlink==$data->video_link) selected @endif >{{$vlink}}</option>
                    @endforeach   
                </select>
                    @error('video')
                      <span class="invalid-feedback" role="alert">
                        <span>{{ $message }}</span>
                      </span>
                    @enderror 
                  </div>
            </div>

            <div class="form-group row">
                <div class="col-sm-6 mb-3">
                      <label for="content" class="form-label">Content</label>              
                      <input type="text" name="content" class="form-control  @error('content') is-invalid @enderror" placeholder="Enter content" value="{{ $data->content }}">              
                      @error('name')
                        <span class="invalid-feedback" role="alert">
                          {{ $message }}
                        </span>
                      @enderror
                    </div>

                      <div class="col-sm-6 mb-3">          
                    <label  class="form-label">Back Video</label>                             
                    <select class="form-select @error('back_video_link') is-invalid @enderror" name="back_video_link" id="position" aria-label=".form-select-lg example">
                    @foreach($filesnamedata as $vlink)
                      <option value="{{$vlink}}" @if($vlink==$data->back_video_link) selected @endif >{{$vlink}}</option>
                    @endforeach   
                </select>
                    @error('back_video_link')
                      <span class="invalid-feedback" role="alert">
                        <span>{{ $message }}</span>
                      </span>
                    @enderror 
                  </div>
            </div>

            <div class="form-group row">
              <div class=" col-sm-6 mb-3">         
                <label  class="">Description</label>                           
                <textarea name="description" id="description" class="form-control" placeholder="Please write description here">{{htmlspecialchars_decode(str_replace("&quot;", "\"",$data->description))}}</textarea> 
                <script>
                CKEDITOR.replace('description');
                $("form").submit(function (e) {
                var messageLength = CKEDITOR.instances['description'].getData().replace(/<[^>]*>/gi, '').length;
                if (!messageLength) {
                  swal({
                    title: "You Missed Something!",
                    text: "Please write description ",
                    icon: "warning",
                    button: "close",
                    });
                    e.preventDefault();
                  }
                });
              </script>
                @error('description')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror 
              </div> 


              <div class="col-sm-6 mb-6" >
                        <label for="rubber_. image" class="form-label">Gallery Image</label>
                        <div class="gallery-images"></div> 
                        <p class="image-dimesion-label">For best results, use 900 px by 900 px image</p>
              </div>
            </div>            
          </div>
        </div>
        <div class="card custom_card mb-3">
          <div class="collapse-box">
            <a class="collapse-border-box" data-bs-toggle="collapse" href="#pageSeoSettings" role="button" aria-expanded="false" aria-controls="pageSeoSettings">
              <span class="fs-6 title">SEO Settings </span> 
              <span class="icon">
                <i class="lni lni-chevron-down"></i>
                <i class="lni lni-chevron-up"></i>
              </span>
            </a>
            <div class="collapse" id="pageSeoSettings">
              <div class="collapse-content">
                <div class="card-body">
                  <div class="form-group row">
                    <div class="col-sm-6 mb-3" >
                      <div class="form-group row">
                        <label for="copyright_text" class="col-sm-3 col-form-label">Meta-title</label>
                        <div class="col-sm-12">
                          <input type="text" name="meta_title" class="form-control" value="{{$data->meta_title}}">
                        </div>
                      </div>
                    </div>
                    <div class="col-sm-6 mb-3" >
                      <div class="form-group row">
                        <label for="copyright_text" class="col-sm-3 col-form-label">Meta-keywords</label>
                        <div class="col-sm-12">
                          <input type="text" name="meta_keywords" class="form-control" value="{{$data->meta_keywords}}">                   
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="form-group row">
                    <div class="col-sm-12 mb-3" >
                      <div class="form-group row">
                        <label for="copyright_text" class="col-sm-3 col-form-label">Meta-description</label>
                        <div class="col-sm-12">
                          <textarea name="meta_description" class="form-control" rows="4">{{$data->meta_description}}</textarea>       
                        </div>
                      </div>
                    </div>             
                  </div>
                </div>
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
                  <label for="collection_page_status" class="form-label">Show on Collection Page</label>
                  <select class="form-select" name="collection_page_status" id="collection_page_status">
                    <option value="">Select Status</option>
                    <option value="0" @if($data->collection_page_status=="0") selected @endif>No</option>
                    <option value="1" @if($data->collection_page_status=="1") selected @endif>Yes</option>
                  </select>
                  @error('collection_page_status')
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                  @enderror
                </div>  


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
              <div class="w-100 text-end">
                <button type="submit" class="btn btn-primary custom-dark-btn w-30">Update</button>
              </div>
            </div> 
          </div>
          <div class="card mb-3">
            <div class="">           
              <a class="collapse-border-box" data-bs-toggle="collapse" href="#featured-image" role="button" aria-expanded="true" aria-controls="pageSeoSettings">
                <span class="title">Featured Image</span> 
                <span class="icon">
                  <i class="lni lni-chevron-down"></i>
                  <i class="lni lni-chevron-up"></i>
                </span>
              </a>
            </div>              
            <div class="collapse show" id="featured-image">
              <div class="card-body border-top">                  
                <div class="row">
                  
                <div class="mb-2"> 
                  <input type="file" class="form-control" name="featured_image" id="aimage" placeholder="Please upload logo" onchange="loadimage()">
                  <p class="image-dimesion-label">For best results, use 900 px by 1438 px image</p>
                  <input type="hidden" name="old_featured_image" value="{{$data->featured_image}}" >
                  @error('featured_image')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                  @enderror
                </div>
                <div class="thumpnail-wrap"> 
                  <img src="{{ asset($data->featured_image ?: 'public/image_placeholder.png') }}" alt="image" class="img-thumbnail" width="100">
                  <img id="image" class="img-thumbnail" width="200" style="display:none"/>
                </div>  
                </div>
              </div>        
            </div>              
          </div>  

          <div class="card mb-3">
            <div class="">           
              <a class="collapse-border-box" data-bs-toggle="collapse" href="#banner-image" role="button" aria-expanded="true" aria-controls="pageSeoSettings">
                <span class="title">Banner Image</span> 
                <span class="icon">
                  <i class="lni lni-chevron-down"></i>
                  <i class="lni lni-chevron-up"></i>
                </span>
              </a>
            </div>              
            <div class="collapse show" id="banner-image">
              <div class="card-body border-top">                  
                <div class="row">
               
                <div class="mb-2">
                  <input type="file" class="form-control" name="banner_image" id="banner_image" placeholder="Please upload banner " onchange="loadbanner()">
                   <p class="image-dimesion-label">For best results, use 1920 px by 343 px image</p>
                  <input type="hidden" name="old_banner_image" value="{{$data->banner_image}}" >
                  @error('banner_image')
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                  @enderror
                </div>
                <div class="thumpnail-wrap">           
                  <img src="{{ asset($data->banner_image ?: 'public/image_placeholder.png') }}" alt="banner_image" class="img-thumbnail" height="50" width="100">
                  <img id="banner"  class="img-thumbnail" height="50" width="100" style="display:none"/>
                </div>  
                </div>
              </div>        
            </div>              
          </div>

          <div class="card mb-3">
            <div class="">           
              <a class="collapse-border-box" data-bs-toggle="collapse" href="#modelimage" role="button" aria-expanded="true" aria-controls="pageSeoSettings">
                <span class="title">Model Image</span> 
                <span class="icon">
                  <i class="lni lni-chevron-down"></i>
                  <i class="lni lni-chevron-up"></i>
                </span>
              </a>
            </div>              
            <div class="collapse show" id="modelimage">
              <div class="card-body border-top">                  
                <div class="row">
               
                <div class="mb-2">
                  <input type="file" class="form-control" name="model_image" id="model_image" placeholder="Please upload model image" onchange="loadmodelimage()">
                   <p class="image-dimesion-label">For best results, use 1920 px by 343 px image</p>
                  <input type="hidden" name="old_model_image" value="{{$data->model_image}}" >
                  @error('model_image')
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                  @enderror
                </div>
                <div class="thumpnail-wrap">           
                  <img src="{{ asset($data->model_image ?: 'public/image_placeholder.png') }}" alt="model_image" class="img-thumbnail" height="50" width="100">
                  <img id="model_image_demo"  class="img-thumbnail" height="50" width="100" style="display:none"/>
                </div>  
                </div>
              </div>        
            </div>              
          </div>
   
        </div>
      </div> 
    </div>
  {!! Form::close() !!}
</div>
<script>
  function loadbanner(){
    $('#banner').show();
    $('#banner').attr('src', URL.createObjectURL(event.target.files[0]));
  }

  $("#banner_image").change(function () {    
    var fileExtension = ['jpeg', 'jpg', 'png','gif'];

    $('#banner').show();
    $('#banner').attr('src', URL.createObjectURL(event.target.files[0]));

  });


  function loadimage(){
    $('#image').show();
    $('#image').attr('src', URL.createObjectURL(event.target.files[0]));
  }

  $("#aimage").change(function () {    
    var fileExtension = ['jpeg', 'jpg', 'png','gif'];
    $('#image').show();
    $('#image').attr('src', URL.createObjectURL(event.target.files[0]));

  });

  function loadmodelimage(){
    $('#model_image_demo').show();
    $('#model_image_demo').attr('src', URL.createObjectURL(event.target.files[0]));
  }

  $("#model_image").change(function () {    
    var fileExtension = ['jpeg', 'jpg', 'png','gif'];
    $('#model_image_demo').show();
    $('#model_image_demo').attr('src', URL.createObjectURL(event.target.files[0]));

  });
 </script>
@endsection