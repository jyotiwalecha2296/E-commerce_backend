@extends('admin.layouts.app') 
@section('content')
  <div class="container-fluid pt-5">
    <span class="title-data" id="titleData" data-link="collections/create" data-parent="collections" data-title="Create collection"></span>
    {!! Form::open(['route'=>['collections.store'], 'method' => 'POST','files'=>true,'autocomplete'=>'false', 'id'=>'form','data-parsley-validate' => '','class'=>'form-horizontal','name'=>'form']) !!} 
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
                  <label for="name" class="form-label">Name</label>              
                  <input type="text" name="name" class="form-control  @error('name') is-invalid @enderror" placeholder="Enter Name" value="{{ old('name') }}">              
                  @error('name')
                    <span class="invalid-feedback" role="alert">
                      {{ $message }}
                    </span>
                  @enderror
                </div>

                <div class="col-sm-6 mb-3 {{ $errors->has('value') ? 'has-error' :'' }}" > 
                  <label for="value" class="form-label">Parent</label>
                  <select class="form-select" name="parent_id" id="parent_id" aria-label=".form-select-lg example">
                    <option value="">None</option>
                    @foreach($list as $val)
                      <option value="{{$val->id}}">{{$val->name}}</option>
                    @endforeach                                           
                  </select>            
                  @error('parent_id')
                    <span class="invalid-feedback" role="alert">
                      {{ $message }}
                    </span>
                  @enderror                 
                </div> 
              </div>


              <div class="form-group row">
                     <div class="col-sm-6 mb-3">
                      <label for="tagline" class="form-label">Tagline</label>              
                      <input type="text" name="tagline" class="form-control  @error('tagline') is-invalid @enderror" placeholder="Enter Tagline" value="{{ old('tagline') }}">              
                      @error('name')
                        <span class="invalid-feedback" role="alert">
                          {{ $message }}
                        </span>
                      @enderror
                    </div>
                
                    <div class="col-sm-6 mb-3">          
                    <label  class="form-label">Front Side Video</label>                             
                    <select class="form-select @error('video') is-invalid @enderror" name="video" id="position" aria-label=".form-select-lg example">
                      <option value="" selected disabled>Select Video</option>
                        @foreach($filesnamedata as $vlink)
                          <option value="{{$vlink}}">{{$vlink}}</option>
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
                      <input type="text" name="content" class="form-control  @error('content') is-invalid @enderror" placeholder="Enter Content" value="{{ old('content') }}">              
                      @error('name')
                        <span class="invalid-feedback" role="alert">
                          {{ $message }}
                        </span>
                      @enderror
                    </div>

                    <div class="col-sm-6 mb-3">          
                    <label  class="form-label">Back Side Video</label>                             
                    <select class="form-select @error('back_video_link') is-invalid @enderror" name="back_video_link" id="back_video_link" aria-label=".form-select-lg example">
                      <option value="" selected disabled>Select Video</option>
                        @foreach($filesnamedata as $vlink)
                          <option value="{{$vlink}}">{{$vlink}}</option>
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
                <div class="col-sm-12 mb-3">           
                  <label for="description" class="form-label">Description</label>                         
                  <textarea name="description" id="description" class="form-control" placeholder="Please write description here" rows="2">{{ old('description') }}</textarea> 
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
                    {{ $message }}
                  </span>
                  @enderror 
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
                      <div class="col-sm-6 mb-3 " >              
                        <label for="copyright_text" class="form-label">Meta-title</label>                
                        <input type="text" name="meta_title" class="form-control" value="{{ old('meta_title') }}"> 
                      </div>
                      <div class="col-sm-6 mb-3">             
                        <label for="copyright_text" class="form-label">Meta-keywords</label>                
                        <input type="text" name="meta_keywords" class="form-control" value="{{ old('meta_keywords') }}"> 
                      </div>
                    </div>
                    <div class="form-group row">
                      <div class="col-sm-12 mb-3" >              
                        <label for="copyright_text" class="form-label">Meta-description</label>                
                        <textarea name="meta_description" class="form-control" rows="4">{{ old('meta_description') }}</textarea>
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
                    <label for="collection_page_status" class="form-label">Show on Collection Page</label>
                    <select class="form-select" name="collection_page_status" id="collection_page_status" aria-label=".form-select-lg example">
                      <option value="">Select Status</option>
                      <option value="0">No</option>
                      <option value="1" selected>Yes</option>
                    </select>
                    @error('collection_page_status')
                      <span class="invalid-feedback" role="alert">
                        {{ $message }}
                      </span>
                    @enderror 
                  </div>


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
            <div class="card mb-3">
              <div class="border-bottom">            
                <a class="collapse-border-box" data-bs-toggle="collapse" href="#featured-image" role="button" aria-expanded="true" aria-controls="pageSeoSettings">
                  <span class="title">Featured Image</span> 
                  <span class="icon">
                    <i class="lni lni-chevron-down"></i>
                    <i class="lni lni-chevron-up"></i>
                  </span>
                </a>
              </div>
              <div class="card-body">
                <div class="collapse show" id="featured-image">
                  <div class="col-sm-12">
                  <label for="logo" class="form-label">Featured Image</label>

                  <input type="file" class="form-control" name="featured_image" id="f_image" placeholder="Please upload logo" onchange="loadimage()"><br/>
                  <p class="image-dimesion-label">For best results, use 900 px by 1438 px image</p>

                  <img id="fimage" class="img-thumbnail" height="100" width="200" style="display:none"/>
                  @error('featured_image')
                    <span class="invalid-feedback" role="alert">
                      {{ $message }}
                    </span>
                  @enderror         
                </div>                
                </div> 
              </div> 
            </div>     
             <div class="card mb-3">
              <div class="border-bottom">            
                <a class="collapse-border-box" data-bs-toggle="collapse" href="#banner-image" role="button" aria-expanded="true" aria-controls="pageSeoSettings">
                  <span class="title">Banner Image </span> 
                  <span class="icon">
                    <i class="lni lni-chevron-down"></i>
                    <i class="lni lni-chevron-up"></i>
                  </span>
                </a>
              </div>
              <div class="card-body">
                <div class="collapse show" id="banner-image">
                  <div class="col-sm-12">
                  <label for="logo" class="form-label">Banner Image</label>

                  <input type="file" class="form-control" name="banner_image" id="banner_image" placeholder="Please upload banner " onchange="loadbanner()"><br/>
                  <p class="image-dimesion-label">For best results, use 1920 px by 343 px image</p>
                  
                  <img id="banner"  class="img-thumbnail" height="100" width="200" style="display:none"/>
                  @error('banner_image')
                    <span class="invalid-feedback" role="alert">
                      {{ $message }}
                    </span>
                  @enderror   
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
                  
                  @error('model_image')
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                  @enderror
                </div>
                <div class="thumpnail-wrap">         
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
      $('#fimage').show();
      $('#fimage').attr('src', URL.createObjectURL(event.target.files[0]));
    }

    $("#f_image").change(function () {    
      var fileExtension = ['jpeg', 'jpg', 'png','gif'];
      $('#fimage').show();
      $('#fimage').attr('src', URL.createObjectURL(event.target.files[0]));
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