@extends('admin.layouts.app') 
@section('content')
<div class="container-fluid pt-5">
  <span class="title-data" id="titleData" data-link="pages/{{ $data->id }}/edit" data-parent="home-slider" data-title="Edit Slider"></span>
  <span class="title-data" id="titleData" data-link="home-slider/create" data-parent="home-slider" data-title="Add Slider"></span>
  {!!Form::model($data,['method'=>'PATCH', 'route'=>['home-slider.update',$data->id] ,'id'=>'form','files'=>'true' ,'data-parsley-validate' => '','name'=>'page_form']) !!}         
    {{ csrf_field() }}
    <div class="row">      
      <div class="col-lg-9 col-md-8 col-sm-7 order-2 order-sm-1">      
        <div class="card custom_card mb-3">
          <div class="row">
            <div class="col-sm-12">
              <span class="fs-6">Slide Information</span>
            </div>
          </div>
          <div class="card-body">


            <div class="form-group row">
              <div class="col-sm-6 mb-3" > 
                <label for="watch_name" class="form-label">Title</label>                
                <input type="text" name="title" class="form-control title @error('title') is-invalid @enderror" placeholder="Enter watch name" value="{{ $data->title }}">                
                @error('title')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                @enderror 
              </div>
              <div class="col-sm-6 mb-3">          
                <label  class="form-label">Text</label>                             
                <input type="text" name="pretext" class="form-control @error('pretext') is-invalid @enderror" placeholder="Please write slide pretext" value="{{ $data->pretext }}">
                @error('pretext')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                @enderror 
              </div>     
            </div>

            <div class="form-group row">
              <div class="col-sm-12 mb-3" > 
                <label for="sub_title" class="form-label">Sub title</label>  
                <textarea name="sub_title" class="form-control @error('sub_title') is-invalid @enderror" placeholder="Please write sub title here" rows="2">{{ $data->sub_title }}</textarea>              
                @error('sub_title')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                @enderror 
              </div>
            </div>

              <div class="form-group row">
              <div class="col-sm-6 mb-3">          
                <label  class="form-label">Slide Link</label>   
                <select class="form-select @error('link') is-invalid @enderror" name="link" id="link" aria-label=".form-select-lg example">                    
                    @foreach($list as $val)
                      <option value="{{$val->slug}}" @if($data->link==$val->slug) selected @endif >{{$val->name}}</option>
                    @endforeach                                           
                  </select>                           
              
                @error('link')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                @enderror 
              </div>     
           
            
              <div class="col-sm-6 mb-3" > 
                <label for="position" class="form-label">Slide Position</label>   
                <select class="form-select @error('position') is-invalid @enderror" name="position" id="position" aria-label=".form-select-lg example">
                    @for($i=1; $i<15; $i++)
                    <option value="{{$i}}" @if($data->position==$i) selected @endif >{{$i}}</option>
                    @endfor
                    </select>             
                @error('position')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                @enderror 
              </div>
            </div>

            <div class="form-group row"> 
              <div class="col-sm-12 mb-3">          
                <label  class="form-label">Slide video</label>      
                

                <select class="form-select @error('video') is-invalid @enderror" name="video" id="position" aria-label=".form-select-lg example">
                    @foreach($filesnamedata as $vlink)
                      <option value="{{$vlink}}" @if($vlink==$data->video_link) selected @endif >{{$vlink}}</option>
                    @endforeach   
                </select>

                @error('video')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
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
                    <option value="0" @if($data->status=="0")selected @endif>Disable</option>
                    <option value="1" @if($data->status=="1")selected @endif>Enable</option>
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
              <a class="collapse-border-box" data-bs-toggle="collapse" href="#productTags" role="button" aria-expanded="true" aria-controls="pageSeoSettings">
                <span class="title">Slide watch Images</span> 
                <span class="icon">
                  <i class="lni lni-chevron-down"></i>
                  <i class="lni lni-chevron-up"></i>
                </span>
              </a>
            </div>              
            <div class="collapse show" id="productTags">
              <div class="card-body border-top">                  
                <div class="row">
                  <div class="col-sm-12">
                    <label for="watch_image" class="form-label">Watch Image</label>
                    <input type="file" class="form-control @error('watch_image') is-invalid @enderror" name="watch_image" id="watch_image" placeholder="Please upload watch image " onchange="loadWatchImage()">
                    <p class="image-dimesion-label">For best results, use 697 px by 697 px image</p>
                    <input type="hidden" name="old_watch_image" value="{{$data->watch_image}}" >
                    <div class="thumpnail-wrap mt-3"> 
                      <img src="{{ asset($data->watch_image ?: 'public/image_placeholder.png') }}" alt="image" class="img-thumbnail" width="100">
                      <img id="watch_image_demo"  class="img-thumbnail" style="display:none" width="100" />
                    </div>
                    @error('watch_image')
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
                <span class="title">BackGround Image</span> 
                <span class="icon">
                  <i class="lni lni-chevron-down"></i>
                  <i class="lni lni-chevron-up"></i>
                </span>
              </a>
            </div>              
            <div class="collapse show" id="featured_images">
              <div class="card-body border-top">                  
                <div class="row">
                <div class="col-sm-12">
                    <label for="bg_image" class="form-label">Background Image</label>
                    <input type="file" class="form-control @error('bg_image') is-invalid @enderror" name="bg_image" id="bg_image" placeholder="Please upload background image " onchange="loadBackgroundImage()">
                    <p class="image-dimesion-label">For best results, use 1920 px by 663 px image</p>
                     <input type="hidden" name="old_background_image" value="{{$data->background_image}}" >
                    <div class="thumpnail-wrap mt-3"> 
                      <img src="{{ asset($data->background_image ?: 'public/image_placeholder.png') }}" alt="image" class="img-thumbnail" width="100%" />
                      <img id="bg_image_demo"  class="img-thumbnail" style="display:none" width="100%" />
                    </div>
                    @error('bg_image')
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
    </div>  
  </form>
</div>

<script>
  function loadWatchImage(){
    $('#watch_image_demo').show();
    $('#watch_image_demo').attr('src', URL.createObjectURL(event.target.files[0]));
  }
  // $("#watch_image").change(function () {    
  //   var fileExtension = ['jpeg', 'jpg', 'png','gif'];
  //   var filesize=(this.files[0].size);

  //   if($.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) == -1) {
  //        swal("Only " +fileExtension.join(', ') +" formats are allowed");
  //          document.getElementById("watch_image").value = "";
  //          $('#watch_image_demo').hide();
  //   }  
     
  // }); 

  function loadBackgroundImage(){
    $('#bg_image_demo').show();
    $('#bg_image_demo').attr('src', URL.createObjectURL(event.target.files[0]));
  }

  // $("#bg_image").change(function (){    
  //   var fileExtension = ['jpeg', 'jpg', 'png','gif'];
  //   var filesize=(this.files[0].size);

  //   if($.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) == -1) {
  //        swal("Only " +fileExtension.join(', ') +" formats are allowed");
  //          document.getElementById("watch_image").value = "";
  //          $('#bg_image_demo').hide();
  //   }       
  // }); 
</script>
@endsection