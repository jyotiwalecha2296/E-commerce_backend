@extends('admin.layouts.app') 
@section('content')
<div class="container-fluid pt-5">
  <span class="title-data" id="titleData" data-link="videos/create" data-parent="home-slider" data-title="Add Video"></span>
  {!! Form::open(['route'=>['videos.store'], 'method' => 'POST','files'=>true,'autocomplete'=>'false', 'id'=>'form','data-parsley-validate' => '','class'=>'form-horizontal','name'=>'form']) !!} 
      {{ csrf_field() }}
    <div class="row">      
      <div class="col-lg-9 col-md-8 col-sm-7 order-2 order-sm-1">

      <div class="row">  
        <div class="col-sm-12 form-group mb-4 text-start">
          <a href="{{ url('videos') }}" type="button" class="btn btn-primary custom-dark-btn float-right text-end"> <i class="lni lni-arrow-left"></i> Back </a>
        </div>           
     </div>      
        <div class="card custom_card mb-3">
          <div class="row">
            <div class="col-sm-12">
              <span class="fs-6">Video Information</span>
            </div>
          </div>
          <div class="card-body">  

               <div class="form-group row">
                <div class="col-sm-12 mb-3">
                  <label for="name">Title</label>                        
                    <input type="text" name="title" class="form-control field-validate"  placeholder="Please enter title here" id="title" value="{{old('title')}}" >
                    @error('title')
                       <span class="invalid-feedback" role="alert">
                       {{ $message }}
                       </span>
                    @enderror
                </div>
              </div>


             <div class="form-group row">
                  <div class="col-sm-12 mb-3">         
                    <label for="video" class="form-label">Video</label>
                     <input type='file'  name="video" id='videoUpload' accept="video/mp4,video/x-m4v,video/*"/>
                     <br/>
                     <div id="show_video_preview" style="display:none">
                         <video width="320" height="240" controls>
                           Your browser does not support the video tag.
                         </video>
                     </div>                     
                    @error('video')
                      <span class="invalid-feedback" role="alert">
                        {{ $message }}
                      </span>
                    @enderror 
              </div> 
            </div>

             <div class="w-100 text-end">
                <button type="submit" class="btn btn-primary custom-dark-btn w-30">Upload</button>
              </div>
          </div>
        </div>
      </div>
       
    </div>  
  </form>
</div>

<script>
  document.getElementById("videoUpload").onchange = function(event) {

    var fileExtension = ['mp4', 'webm', 'ogg'];
       if ($.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) == -1) {
         swal("Only " +fileExtension.join(', ') +" formats are allowed");
           document.getElementById("videoUpload").value = "";
          document.getElementById("show_video_preview").style.display = "none";
          return false;
       }


  let file = event.target.files[0];
  let blobURL = URL.createObjectURL(file);
  document.querySelector("video").src = blobURL;
  document.getElementById("show_video_preview").style.display = "block";
}

</script>
@endsection