@extends('admin.layouts.app') 
@section('content')

<span class="title-data" id="titleData" data-link="settings" data-parent="" data-title="settings"></span> 
<div class="container-fluid pt-5">
{!!Form::model($data,['method'=>'PATCH', 'route'=>['settings.update',$data->id] ,'id'=>'form','files'=>'true' ,'data-parsley-validate' => '','name'=>'form']) !!} 
@csrf
 <div class="row"> 
 	@if(Session::has('success'))
	  <div class="alert alert-success">
		{{ Session::get('success') }}
		@php Session::forget('success'); @endphp
	  </div>
	@endif

 	<div class="col-sm-9">
        <div class="card custom_card mb-3">
          <div class="row">
            <div class="col-sm-12">
              <span class="fs-6">Settings</span>
            </div>
	          <div class="card-body">

	         	 <div class="form-group row mb-3">
					<div class="col-sm-6" >
						<div class="form-group row">
							<label for="title" class="col-sm-12 col-form-label">Website Title </label>
							<div class="col-sm-12">
								<input name="application_title" type="text" class="form-control" id="title" placeholder="Please enter Website title" value="{{$data->application_title}}" required>
							</div>
						</div> 
					</div>
					<div class="col-sm-6" >
						<div class="form-group row">
							<label for="copyright_text" class="col-sm-12 col-form-label">Admin Email (Email)</label>
							<div class="col-sm-12">
								<input type="email" name="admin_email"  class="form-control" placeholder="Enter admil email to receive emails" value="{{$data->admin_email}}" required>
							</div>
						</div>
					</div>
				</div>

               	<div class="form-group row mb-3">
					<div class="col-sm-12" >
						<div class="form-group row">
							<label for="title" class="col-sm-12 col-form-label">Copyright Text </label>
							<div class="col-sm-12">
								<input name="copyright" type="text" class="form-control" id="title" placeholder="Please enter copyright text" value="{{$data->copyright}}" required>
							</div>
						</div> 
					</div>	

			 				 
				</div>
               
               <div class="form-group row mb-4">
					<div class="col-sm-3" >						
						<div class="form-group row">
							<div class="col-sm-12 mb-3">	
								<label for="application_logo" class="col-sm-12 col-form-label">Website White Logo  </label>							
								<input type="file" name="application_logo" id="application_logo" placeholder="Please upload application logo" onchange="loadlogo()">
								<p class="image-dimesion-label">For best results, use 219 px by 88 px image</p>
								<input type="hidden" name="old_application_logo" value="{{$data->application_logo}}" >
							</div>
							<div class="col-sm-12 thumpnail-wrap">
								<img id="new_application_logo"  class="img-thumbnail" width="100" style="display:none" />
								<img src="{{ asset($data->application_logo ?: 'public/image_placeholder.png') }}" alt="Logo" class="img-thumbnail" width="100">
							</div>
						</div>
					</div>
					<div class="col-sm-3" >						
						<div class="form-group row">
							<div class="col-sm-12 mb-3">	
								<label for="application_blue_logo" class="col-sm-12 col-form-label">Website Blue Logo  </label>							
								<input type="file" name="application_blue_logo" id="application_blue_logo" placeholder="Please upload application logo" onchange="loadbluelogo()">
								<p class="image-dimesion-label">For best results, use 219 px by 88 px image</p>
								<input type="hidden" name="old_application_blue_logo" value="{{$data->application_blue_logo}}" >
							</div>
							<div class="col-sm-12 thumpnail-wrap">
								<img id="application_blue_logo_demo"  class="img-thumbnail" width="100" style="display:none" />
								<img src="{{ asset($data->application_blue_logo ?: 'public/image_placeholder.png') }}" alt="Logo" class="img-thumbnail" width="100">
							</div>
						</div>
					</div>
					<div class="col-sm-3" >
						<div class="form-group row">
							<div class="col-sm-12 mb-3">	
								<label for="footer_logo" class="col-sm-12 col-form-label">Footer Logo </label>
								<input type="file" name="footer_logo" id="footer_logo" placeholder="Footer Logo" onchange="loadfooterlogo()">
								<p class="image-dimesion-label">For best results, use 219 px by 88 px image</p>
								<input type="hidden" name="old_footer_logo" value="{{$data->footer_logo}}" >
							</div>
							<div class="col-sm-12 thumpnail-wrap">
								<img id="afooterlogo"  class="img-thumbnail" width="100" style="display:none"/>
								<img src="{{ asset($data->footer_logo ?: 'public/image_placeholder.png') }}" alt="Footer Logo" class="img-thumbnail" width="100">
							</div>
						</div>
					</div>
					<div class="col-sm-3" >
						<div class="form-group row">
							<div class="col-sm-12 mb-3">	
								<label for="application_favicon" class="col-sm-12 col-form-label">Website Favicon </label>
								<input type="file" name="application_favicon" id="application_favicon" placeholder="Fav icon" onchange="loadfavicon()">
								<p class="image-dimesion-label">For best results, use 48 px by 48 px image</p>
								<input type="hidden" name="old_application_favicon" value="{{$data->application_favicon}}" >
							</div>
							<div class="col-sm-12 thumpnail-wrap">
								<img id="afavicon"  class="img-thumbnail" width="100" style="display:none"/>
								<img src="{{ asset($data->application_favicon ?: 'public/image_placeholder.png') }}" alt="Logo" class="img-thumbnail" width="100">
							</div>
						</div>
					</div>
				</div>
	          </div>
          </div>
        </div>


        <div class="card custom_card mb-3">
          <div class="collapse-box">
            <a class="collapse-border-box" data-bs-toggle="collapse" href="#contactinfo" role="button" aria-expanded="false" aria-controls="pagecontactinfo">
              <span class="fs-6 title">Contact Information & Social Links-</span> 
              <span class="icon">
                <i class="lni lni-chevron-down"></i>
                <i class="lni lni-chevron-up"></i>
              </span>
            </a>
            <div class="collapse show" id="contactinfo">
              <div class="collapse-content">
                <div class="card-body">
       				<div class="form-group row mb-3">
					<div class="col-sm-6" >
						<div class="form-group row">
							<label for="copyright_text" class="col-sm-12 col-form-label">Contact Email </label>
							<div class="col-sm-12">
								<input type="email" name="contact_email"  class="form-control" placeholder="Enter contact email" value="{{$data->contact_email}}" required>
							</div>
						</div>
					</div>
					<div class="col-sm-6" >
						<div class="form-group row">
							<label for="copyright_text" class="col-sm-12 col-form-label">Contact Phone </label>
							<div class="col-sm-12">
								<input type="number" name="contact_phone"  class="form-control" placeholder="Enter contact phone number" value="{{$data->contact_phone}}" required>
							</div>
						</div> 
					</div>
				</div>
				<div class="form-group row mb-3">
					<div class="col-sm-6" >
						<div class="form-group row">
							<label for="copyright_text" class="col-sm-12 col-form-label">Youtube Url </label>
							<div class="col-sm-12">
								<input type="text" name="youtube_url"  class="form-control" placeholder="Enter Youtube Url" value="{{$data->youtube_url}}" required>
							</div>
						</div>  
					</div>
					<div class="col-sm-6" >
						<div class="form-group row">
							<label for="copyright_text" class="col-sm-12 col-form-label">Facebook Url </label>
							<div class="col-sm-12">
								<input type="url" name="facebook_url"  class="form-control" placeholder="Enter Facebook Url" value="{{$data->facebook_url}}" required>
							</div>
						</div>  
					</div>
				</div>
				<div class="form-group row mb-4">
					<div class="col-sm-6" >
						<div class="form-group row">
							<label for="copyright_text" class="col-sm-12 col-form-label">Instagram Url </label>
							<div class="col-sm-12">
								<input type="url" name="instagram_url"  class="form-control" placeholder="Enter Instagram Url " value="{{$data->instagram_url}}" required>
							</div>
						</div>
					</div>
					<div class="col-sm-6" >
						<div class="form-group row">
							<label for="copyright_text" class="col-sm-12 col-form-label">Twitter Url </label>
							<div class="col-sm-12">
								<input type="url" name="twitter_url"  class="form-control" placeholder="Enter Twitter Url" value="{{$data->twitter_url}}" required>
							</div>
						</div>
					</div>
				</div>		
				<div class="form-group row mb-4">
					<div class="col-sm-6" >
						<div class="form-group row">
							<label for="linkedin_url" class="col-sm-12 col-form-label">LinkedIn Url </label>
							<div class="col-sm-12">
								<input type="url" name="linkedin_url"  class="form-control" placeholder="Enter lLnkedIn Url " value="{{$data->linkedin_url}}" required>
							</div>
						</div>
					</div>
					<div class="col-sm-6" >
						<div class="form-group row">
							<label for="pinterest_url" class="col-sm-12 col-form-label">Pinterest Url </label>
							<div class="col-sm-12">
								<input type="url" name="pinterest_url"  class="form-control" placeholder="Enter Pinterest Url" value="{{$data->pinterest_url}}" required>
							</div>
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
            <a class="collapse-border-box" data-bs-toggle="collapse" href="#seosettings" role="button" aria-expanded="false" aria-controls="pageseosettings">
              <span class="fs-6 title">SEO Settings-</span> 
              <span class="icon">
                <i class="lni lni-chevron-down"></i>
                <i class="lni lni-chevron-up"></i>
              </span>
            </a>
            <div class="collapse" id="seosettings">
              <div class="collapse-content">
                <div class="card-body">
       			<div class="form-group row mb-3">
					<div class="col-sm-6" >
						<div class="form-group row">
							<label for="copyright_text" class="col-sm-12 col-form-label">Meta-title</label>
							<div class="col-sm-12">
								<input type="text" name="meta_title" class="form-control field-validate" value="{{$data->meta_title}}" required>
								 
							</div>
						</div>
					</div>
					<div class="col-sm-6" >
						<div class="form-group row">
							<label for="copyright_text" class="col-sm-12 col-form-label">Meta-keywords</label>
							<div class="col-sm-12">
								 <input type="text" name="meta_keywords" class="form-control field-validate" value="{{$data->meta_keywords}}" required>
								 
							</div>
						</div>
					</div>
				</div>
				<div class="form-group row mb-3">
					<div class="col-sm-12" >
						<div class="form-group row">
							<label for="copyright_text" class="col-sm-12 col-form-label">Meta-description</label>
							<div class="col-sm-12">
								<textarea name="meta_description" class="form-control" rows="4" required>{{$data->meta_description}}</textarea>				
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
               
              </div> 
              <div class="w-100">
                <input type="submit" value="Update" class="btn btn-primary custom-dark-btn" name="update" id="submitbtn"> 
              </div>
            </div> 
          </div>


          <div class="card mb-3">
            <div class="">           
              <a class="collapse-border-box" data-bs-toggle="collapse" href="#createCatalogue" role="button" aria-expanded="true" aria-controls="pageSeoSettings">
                <span class="title">Catalogue </span> 
                <span class="icon">
                  <i class="lni lni-chevron-down"></i>
                  <i class="lni lni-chevron-up"></i>
                </span>
              </a>
            </div>              
            <div class="collapse show" id="createCatalogue">
              <div class="card-body border-top">                  
                <div class="row">
                     
                   	<div class="form-group row">
							<div class="col-sm-12 mb-3">	
								<label for="catalogue" class="col-sm-12 col-form-label">Catalogue</label>
								<input type="file" name="catalogue" id="catalogue" placeholder="Footer Logo" onchange="loadcatalogue()">
								<input type="hidden" name="old_catalogue" value="{{$data->catalogue}}" >
							</div>
							<div class="col-sm-12 thumpnail-wrap">
								 
								<embed id="acatalogue" src="{{ asset($data->catalogue) }}" type="application/pdf" width="100%" height="450px"  style="display:none"/>
								<embed src="{{ asset($data->catalogue) }}" type="application/pdf" width="100%" height="450px" />
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
	  	function loadlogo(){
		  $('#new_application_logo').show();
		  $('#new_application_logo').attr('src', URL.createObjectURL(event.target.files[0]));
		}
		function loadbluelogo(){
		  $('#application_blue_logo_demo').show();
		  $('#application_blue_logo_demo').attr('src', URL.createObjectURL(event.target.files[0]));
		}
		
		function loadfooterlogo(){
		  $('#afooterlogo').show();
		  $('#afooterlogo').attr('src', URL.createObjectURL(event.target.files[0]));
		}
		function loadfavicon(){
		  $('#afavicon').show();
		  $('#afavicon').attr('src', URL.createObjectURL(event.target.files[0]));
		}

		function loadcatalogue(){
		  $('#acatalogue').show();
		  $('#acatalogue').attr('src', URL.createObjectURL(event.target.files[0]));
		}

		$("#catalogue").change(function () {    
		    var fileExtension = ['jpeg', 'jpg', 'png','gif'];     
		    $('#acatalogue').show();
		    $('#acatalogue').attr('src', URL.createObjectURL(event.target.files[0]));       
		}); 
		
		$("#footer_logo").change(function () {    
		    var fileExtension = ['jpeg', 'jpg', 'png','gif'];     
		    $('#afooterlogo').show();
		    $('#afooterlogo').attr('src', URL.createObjectURL(event.target.files[0]));       
		}); 

		$("#application_logo").change(function () {    
		    var fileExtension = ['jpeg', 'jpg', 'png','gif'];     
		    $('#new_application_logo').show();
		    $('#new_application_logo').attr('src', URL.createObjectURL(event.target.files[0]));       
		}); 
		$("#application_logo").change(function () {    
		    var fileExtension = ['jpeg', 'jpg', 'png','gif'];     
		    $('#new_application_logo').show();
		    $('#new_application_logo').attr('src', URL.createObjectURL(event.target.files[0]));       
		});
	  	$("#application_favicon").change(function () { 
	    	$('#afavicon').show();
	    	$('#afavicon').attr('src', URL.createObjectURL(event.target.files[0]));
	  	});
	</script>
@endsection