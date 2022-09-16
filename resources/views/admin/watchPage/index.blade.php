@extends('admin.layouts.app') 
@section('content')

<span class="title-data" id="titleData" data-link="homepage-settings" data-parent="" data-title="homepage settings"></span> 
<div class="container-fluid pt-5">
	<form role="form" data-parsley-validate="" method="POST" action="{{url('update-watch-page')}}" enctype='multipart/form-data'>
		@csrf
		<div class="row"> 
			@if(Session::has('success'))
			<div class="alert alert-success">
				{{ Session::get('success') }}
				@php Session::forget('success'); @endphp
			</div>
			@endif

			<div class="col-sm-9">
				<input type="hidden" name="id" value="{{$data->id}}">

				

				<!-- About section -->
				<div class="card custom_card mb-3">
					<div class="collapse-box">
						<a class="collapse-border-box" data-bs-toggle="collapse" href="#aboutsec" role="button" aria-expanded="false" aria-controls="pagecontactinfo">
							<span class="fs-6 title">About Section</span> 
							<span class="icon">
								<i class="lni lni-chevron-down"></i>
								<i class="lni lni-chevron-up"></i>
							</span>
						</a>

						<div class="collapse" id="aboutsec">
							<div class="collapse-content">
								<div class="card-body">

									<div class="form-group row mb-3">
										<div class="col-sm-12" >
											<div class="form-group row">
												<label for="title" class="col-sm-12 col-form-label">Title </label>
												<div class="col-sm-12">
													<input name="about_title" type="text" class="form-control" id="title" placeholder="Enter title" value="{{$data->about_title}}" />
												</div>
											</div> 
										</div>
										<div class="col-sm-12" >
											<div class="form-group row">
												<label for="copyright_text" class="col-sm-12 col-form-label">Content</label>
												<div class="col-sm-12">
													<textarea  name="about_content"  class="form-control" placeholder="Enter content">{{$data->about_content}}</textarea>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>						
					</div>
				</div>

		 

				 <!-- Collection Widgets section -->
				<div class="card custom_card mb-3">
					<div class="collapse-box">
						<a class="collapse-border-box" data-bs-toggle="collapse" href="#collectionwidgets" role="button" aria-expanded="false" aria-controls="pagecontactinfo">
							<span class="fs-6 title">Collection Widgets</span> 
							<span class="icon">
								<i class="lni lni-chevron-down"></i>
								<i class="lni lni-chevron-up"></i>
							</span>
						</a>

						<div class="collapse" id="collectionwidgets">
							<div class="collapse-content">
								<div class="card-body">

									<div class="form-group row mb-3">
										<div class="col-sm-12" >
										      <table class="table" id="editAddRemoveCatWidget">
						                        <tr>
						                          <th>Image</th>
						                          <th>Button Label</th>
						                          <th>Button Link</th>
						                          <th>Action</th>
						                        </tr>

						                        @if($data->collection_widgets != null)
						                        @foreach($data->collection_widgets as $collection_widget)
						                        <tr id="collection_widgets_row_{{$loop->index}}">
						                          <td>
						                          	<div class="row">
						                          		<div class="col-sm-6" >
						                          			<input type="file" name="collection_widgets[{{$loop->index}}][image]" placeholder="Upload image" class="form-control" />
						                                     <input type="hidden" name="collection_widgets[{{$loop->index}}][oldfimage]" value="{{$collection_widget['image']}}"  placeholder="Upload image" class="form-control"/>
						                          		</div>
						                          		<div class="col-sm-6">
						                          			 <img src="{{asset($collection_widget['image'] ?: 'public/image_placeholder.png')}}" width="50" />
						                          		</div>
						                          	</div>
						                          		
						                             
						                               
						                               
						                               
						                          </td>
						                          <td><input type="text" name="collection_widgets[{{$loop->index}}][label]" placeholder="Enter Button Label" class="form-control" value="{{ $collection_widget['label'] }}"/></td>
						                          <td><input type="text" name="collection_widgets[{{$loop->index}}][link]" placeholder="Enter Button Link" class="form-control" value="{{ $collection_widget['link'] }}"/></td>
						                          <td><button type="button" class="btn btn-outline-danger remove-input-field">Delete</button></td>

						                         </tr> 
						                         @endforeach
						                         @else
						                         <tr  id="collection_widgets_row_0">
						                          <td><input type="file" name="collection_widgets[0][image]" value="" placeholder="Upload image" class="form-control" /></td>
						                          <td><input type="text" name="collection_widgets[0][label]" value="" placeholder="Enter Button Label" class="form-control" /></td>
						                          <td><input type="text" name="collection_widgets[0][link]" value="" placeholder="Enter Button Link" class="form-control" /></td>
						                          <td><button type="button" name="add" id="edit-dynamic-cat-widget" class="btn btn-outline-primary">Add More</button></td>
						                        </tr>
						                        @endif
						                    </table>
						                    @if($data->collection_widgets != null)
                                             <button type="button" name="add" id="edit-dynamic-cat-widget" class="btn btn-outline-primary custom-dark-btn">Add More</button>
                                             @endif
										</div>										 
									</div>
								</div>
							</div>
						</div>						
					</div>
				</div>


				 <!-- Collections section -->
				<div class="card custom_card mb-3">
					<div class="collapse-box">
						<a class="collapse-border-box" data-bs-toggle="collapse" href="#watchcollectionssec" role="button" aria-expanded="false" aria-controls="pagecontactinfo">
							<span class="fs-6 title">Collections</span> 
							<span class="icon">
								<i class="lni lni-chevron-down"></i>
								<i class="lni lni-chevron-up"></i>
							</span>
						</a>

						<div class="collapse" id="watchcollectionssec">
							<div class="collapse-content">
								<div class="card-body">

									<div class="form-group row mb-3">
										<div class="col-sm-12" >
										      <table class="table" id="watchcollectionstab">
						                        <tr>
						                          <th>Collection</th>						                  
						                          <th>Action</th>
						                        </tr>

						                        @if($data->collections != null)
						                        @foreach($data->collections as $collections_detail)
						                        <tr id="collection_row_{{$loop->index}}">
						                          <td>
						                          	 <select class="form-select" name="collections[{{$loop->index}}][collection_id]" id="status">                    
										                <option value="" selected disabled>Select Collection</option>
										                @foreach($allcollections as $collection_data)
										                <option value="{{$collection_data->id}}" @if($collection_data->id==$collections_detail['collection_id']) selected @endif >{{$collection_data->name}}</option>'
										                @endforeach
										            </select>			                          		
						                          </td>						                          
						                          <td><button type="button" class="btn btn-outline-danger remove-input-field">Delete</button></td>
						                         </tr> 
						                         @endforeach
						                         @else
						                         <tr  id="collection_widgets_row_0">
						                          <td><select class="form-select" name="collections[0][collection_id]" id="status">                    
										                <option value="" selected disabled>Select Collection</option>
										                @foreach($allcollections as $collection_data)
										                <option value="{{$collection_data->id}}">{{$collection_data->name}}</option>
										                @endforeach
										            </select></td>
						                         <td><button type="button" class="btn btn-outline-danger remove-input-field">Delete</button></td>
						                        </tr>
						                        @endif
						                    </table>
						                    @if($data->collection_widgets != null)
                                             <button type="button" name="add" id="dynamic-collection" class="btn btn-outline-primary custom-dark-btn">Add More</button>
                                             @endif
										</div>										 
									</div>
								</div>
							</div>
						</div>						
					</div>
				</div>


				 <!-- Collections section -->
				<div class="card custom_card mb-3">
					<div class="collapse-box">
						<a class="collapse-border-box" data-bs-toggle="collapse" href="#collectionproductssec" role="button" aria-expanded="false" aria-controls="pagecontactinfo">
							<span class="fs-6 title">Collection's Products</span> 
							<span class="icon">
								<i class="lni lni-chevron-down"></i>
								<i class="lni lni-chevron-up"></i>
							</span>
						</a>

						<div class="collapse" id="collectionproductssec">
							<div class="collapse-content">
								<div class="card-body">

									<div class="form-group row mb-3">
										<div class="col-sm-12" >
										      <table class="table" id="collectionproductstab">
						                        <tr>
						                          <th>Title</th>	
						                          <th>Collection</th>						                  
						                          <th>Action</th>
						                        </tr>

						                        @if($data->collection_products != null)
						                        @foreach($data->collection_products as $collections_p_detail)
						                        <tr id="collection_products_row_{{$loop->index}}">
						                          <td>
						                           	<input type="text" name="collectionsproducts[{{$loop->index}}][title]" placeholder="Enter title" class="form-control" value="{{ $collections_p_detail['title'] }}"/>
						                          </td>
						                          <td>
						                          	 <select class="form-select" name="collectionsproducts[{{$loop->index}}][collection_id]" id="status">                    
										                <option value="" selected disabled>Select Collection</option>
										                @foreach($allcollections as $collection_data)
										                <option value="{{$collection_data->id}}" @if($collection_data->id==$collections_p_detail['collection_id']) selected @endif >{{$collection_data->name}}</option>'
										                @endforeach
										            </select>			                          		
						                          </td>						                          
						                          <td><button type="button" class="btn btn-outline-danger remove-input-field">Delete</button></td>
						                         </tr> 
						                         @endforeach
						                         @else
						                         <tr  id="collection_widgets_row_0">
						                         	<td><input type="text" name="collectionsproducts[0][title]" placeholder="Enter title" class="form-control" value=""/></td>
						                            <td><select class="form-select" name="collectionsproducts[0][collection_id]" id="status">                    
										                <option value="" selected disabled>Select Collection</option>
										                @foreach($allcollections as $collection_data)
										                <option value="{{$collection_data->id}}">{{$collection_data->name}}</option>
										                @endforeach
										                </select>
										            </td>
						                         <td><button type="button" class="btn btn-outline-danger remove-input-field">Delete</button></td>
						                        </tr>
						                        @endif
						                    </table>
						                    
                                             <button type="button" name="add" id="dynamic-collection-products" class="btn btn-outline-primary custom-dark-btn">Add More</button>
                                             
										</div>										 
									</div>
								</div>
							</div>
						</div>						
					</div>
				</div>



				<!-- Featured section -->
				<div class="card custom_card mb-3">
					<div class="collapse-box">
						<a class="collapse-border-box" data-bs-toggle="collapse" href="#featuredcolsec" role="button" aria-expanded="false" aria-controls="pagecontactinfo">
							<span class="fs-6 title">Featured Collection section</span> 
							<span class="icon">
								<i class="lni lni-chevron-down"></i>
								<i class="lni lni-chevron-up"></i>
							</span>
						</a>
						<div class="collapse" id="featuredcolsec">
							<div class="collapse-content">
								<div class="card-body">
									<div class="row ">
										<div class="col-sm-6">
											<div class="col-sm-12">
												<span class="fs-6">Left Collection Details</span>
											</div>


											<div class="form-group row mb-3">									 
												<div class="col-sm-9" >
													<div class="form-group row">
														<label for="copyright_text" class="col-sm-12 col-form-label">Title</label>
														<div class="col-sm-12">
															<input type="text" name="feat_col_first_title"  class="form-control" placeholder="Enter title" value="{{$data->feat_col_first_title}}" />
														</div>
													</div>
												</div>
											</div>
											<div class="form-group row mb-3">									 
												<div class="col-sm-9" >
													<div class="form-group row">
														<label for="copyright_text" class="col-sm-12 col-form-label">Subtitle</label>
														<div class="col-sm-12">
															<textarea type="text" name="feat_col_first_subtitle"  class="form-control" placeholder="Enter subtitle" rows="5">{{$data->feat_col_first_subtitle}}</textarea>
														</div>
													</div>
												</div>
											</div>
											<div class="form-group row mb-3">	
												<div class="col-sm-9" >
													<div class="form-group row">
														<label for="copyright_text" class="col-sm-12 col-form-label">Button link</label>
														<div class="col-sm-12">
															<input type="text" name="feat_col_first_btn_link"  class="form-control" placeholder="Enter button link" value="{{$data->feat_col_first_btn_link}}" >
														</div>
													</div>
												</div>
											</div>

											<div class="form-group row mb-3">	
												<div class="col-sm-9" >
													<div class="form-group row">
														<label for="copyright_text" class="col-sm-12 col-form-label">Button label</label>
														<div class="col-sm-12">
															<input type="text" name="feat_col_first_btn_label"  class="form-control" placeholder="Enter button label" value="{{$data->feat_col_first_btn_label}}" >
														</div>
													</div>
												</div>
											</div>

											<div class="form-group row mb-3">	
												<div class="col-sm-9" >
													<div class="form-group row">
														<div class="col-sm-12 mb-3">	
															<label for="catalogue_logo" class="col-sm-12 col-form-label">Image </label>
															<input type="file" name="feat_col_first_image" id="feat_col_first_image" onchange="loadfeatfirstimg()">
															<p class="image-dimesion-label">For best results, use 219 px by 88 px image</p>
															<input type="hidden" name="old_feat_col_first_image" value="{{$data->feat_col_first_image }}" >
														</div>
														<div class="col-sm-12 thumpnail-wrap">
															<img id="feat_col_first_image_demo" class="img-thumbnail" width="100" style="display:none"/>
															<img src="{{asset($data->feat_col_first_image ?: 'public/image_placeholder.png') }}" alt="E-Commerce" class="img-thumbnail" width="200">											 
														</div>
													</div>
												</div>
											</div>


										</div>
										<div class="col-sm-6 ">
											<div class="col-sm-12">
												<span class="fs-6">Right Collection Details</span>
											</div>


											<div class="form-group row mb-3">									 
												<div class="col-sm-9" >
													<div class="form-group row">
														<label for="copyright_text" class="col-sm-12 col-form-label">Title</label>
														<div class="col-sm-12">
															<input type="text" name="feat_col_sec_title"  class="form-control" placeholder="Enter title" value="{{$data->feat_col_sec_title}}" />
														</div>
													</div>
												</div>
											</div>
											<div class="form-group row mb-3">									 
												<div class="col-sm-9" >
													<div class="form-group row">
														<label for="copyright_text" class="col-sm-12 col-form-label">Subtitle</label>
														<div class="col-sm-12">
															<textarea type="text" name="feat_col_sec_subtitle"  class="form-control" placeholder="Enter subtitle" rows="5">{{$data->feat_col_sec_subtitle}}</textarea>
														</div>
													</div>
												</div>
											</div>
											<div class="form-group row mb-3">	
												<div class="col-sm-9" >
													<div class="form-group row">
														<label for="copyright_text" class="col-sm-12 col-form-label">Button link</label>
														<div class="col-sm-12">
															<input type="text" name="feat_col_sec_btn_link"  class="form-control" placeholder="Enter button link" value="{{$data->feat_col_sec_btn_link}}" >
														</div>
													</div>
												</div>
											</div>

											<div class="form-group row mb-3">	
												<div class="col-sm-9" >
													<div class="form-group row">
														<label for="copyright_text" class="col-sm-12 col-form-label">Button label</label>
														<div class="col-sm-12">
															<input type="text" name="feat_col_sec_btn_label"  class="form-control" placeholder="Enter button label" value="{{$data->feat_col_sec_btn_label}}" >
														</div>
													</div>
												</div>
											</div>

											<div class="form-group row mb-3">	
												<div class="col-sm-9" >
													<div class="form-group row">
														<div class="col-sm-12 mb-3">	
															<label for="catalogue_logo" class="col-sm-12 col-form-label">Image </label>
															<input type="file" name="feat_col_sec_image" id="feat_col_first_image" onchange="loadfeatsecimg()">
															<p class="image-dimesion-label">For best results, use 219 px by 88 px image</p>
															<input type="hidden" name="old_feat_col_sec_image" value="{{$data->feat_col_sec_image }}" >
														</div>
														<div class="col-sm-12 thumpnail-wrap">
															<img id="feat_col_sec_image_demo" class="img-thumbnail" width="100" style="display:none"/>
															<img src="{{asset($data->feat_col_sec_image ?: 'public/image_placeholder.png') }}" alt="E-Commerce" class="img-thumbnail" width="200">											 
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
			              <a class="collapse-border-box" data-bs-toggle="collapse" href="#featured-image" role="button" aria-expanded="true" aria-controls="pageSeoSettings">
			                <span class="title">Poster Image</span> 
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
			                  <input type="file" class="form-control" name="poster_image" id="poster_image" placeholder="Please upload logo" onchange="loadposterimage()">
			                  <p class="image-dimesion-label">For best results, use 900 px by 1438 px image</p>
			                  <input type="hidden" name="old_poster_image" value="{{$data->poster_image}}" >
			                  @error('poster_image')
			                  <span class="invalid-feedback" role="alert">
			                    <strong>{{ $message }}</strong>
			                  </span>
			                  @enderror
			                </div>
			                <div class="thumpnail-wrap"> 
			                  <img src="{{ asset($data->poster_image ?: 'public/image_placeholder.png') }}" alt="image" class="img-thumbnail" width="100">
			                  <img id="poster_image_demo" class="img-thumbnail" width="200" style="display:none"/>
			                </div>  
			                </div>
			              </div>        
			            </div>              
			        </div> 

			        <div class="card mb-3">
			            <div class="">           
			              <a class="collapse-border-box" data-bs-toggle="collapse" href="#featured-image" role="button" aria-expanded="true" aria-controls="pageSeoSettings">
			                <span class="title">Banner Video</span> 
			                <span class="icon">
			                  <i class="lni lni-chevron-down"></i>
			                  <i class="lni lni-chevron-up"></i>
			                </span>
			              </a>
			            </div>              
			            <div class="collapse show" id="featured-image">
			              <div class="card-body border-top">                  
			                <div class="form-group row"> 
										<div class="col-sm-12 ">          
											<label  class="form-label"> video</label>      


											<select class="form-select @error('banner_video') is-invalid @enderror" name="banner_video" id="position" aria-label=".form-select-lg example">
												@foreach($videos as $vlink)
												<option value="{{$vlink->path}}" @if($vlink->path==$data->banner_video) selected @endif >{{$vlink->name}}</option>
												@endforeach   
											</select>

											@error('banner_video')
											<span class="invalid-feedback" role="alert">
												<strong>{{ $message }}</strong>
											</span>
											@enderror 
										</div>

										<div class="col-sm-12">          
											<label  class="form-label"> </label>      
											<div class="form-group mb-4 text-start">
												<a href="{{ url('videos') }}" type="button" class="btn btn-primary custom-dark-btn float-right text-end">  Upload New Video <i class="lni lni-arrow-up"></i></a>
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
	jQuery(document).ready(function($) {   
		$("#dynamic-collection").click(function () {
        var rownokf = $("#watchcollectionstab tr").length;
        var rownokf = rownokf-1;    
         $("#watchcollectionstab").append('<tr id="collections_row_'+rownokf+'"><td><select class="form-select" name="collections[' + rownokf +'][collection_id]" id="status"><option value="" selected disabled>Select Collection</option>@foreach($allcollections as $collection_data)<option value="{{$collection_data->id}}">{{$collection_data->name}}</option>@endforeach</select></td><td><button type="button" class="btn btn-outline-danger remove-input-field">Delete</button></td></tr>'
         );

          });

		$("#dynamic-collection-products").click(function () {
        var rownokf = $("#collectionproductstab tr").length;
        var rownokf = rownokf-1;    
         $("#collectionproductstab").append('<tr id="collection_products_row_'+rownokf+'"><td><input type="text" name="collectionsproducts[' + rownokf +'][title]" placeholder="Enter title" class="form-control" value=""/></td><td><select class="form-select" name="collectionsproducts[' + rownokf +'][collection_id]" id="status"><option value="" selected disabled>Select Collection</option>@foreach($allcollections as $collection_data)<option value="{{$collection_data->id}}">{{$collection_data->name}}</option>@endforeach</select></td><td><button type="button" class="btn btn-outline-danger remove-input-field">Delete</button></td></tr>'
         );

          });
		});
</script>
<script>
	 
	function loadposterimage(){
		$('#poster_image_demo').show();
		$('#poster_image_demo').attr('src', URL.createObjectURL(event.target.files[0]));
	}

	$("#poster_image").change(function () {    
		var fileExtension = ['jpeg', 'jpg', 'png','gif'];  

		if($.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) == -1) {
         swal("Only " +fileExtension.join(', ') +" formats are allowed");
           document.getElementById("poster_image").value = "";
           $('#poster_image_demo').hide();
	    }else{
	    	$('#poster_image_demo').show();
			$('#poster_image_demo').attr('src', URL.createObjectURL(event.target.files[0]));   
	    }		    
	});	 

	function loadfeatfirstimg(){
		$('#feat_col_first_image_demo').show();
		$('#feat_col_first_image_demo').attr('src', URL.createObjectURL(event.target.files[0]));
	}

	$("#feat_col_first_image").change(function () {    
		var fileExtension = ['jpeg', 'jpg', 'png','gif'];     

		if($.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) == -1) {
         swal("Only " +fileExtension.join(', ') +" formats are allowed");
           document.getElementById("feat_col_first_image").value = "";
           $('#feat_col_first_image_demo').hide();
	    }else{
	    	$('#feat_col_first_image_demo').show();
	     	$('#feat_col_first_image_demo').attr('src', URL.createObjectURL(event.target.files[0])); 
		
	    }	      
	});

	function loadfeatsecimg(){
		$('#feat_col_sec_image_demo').show();
		$('#feat_col_sec_image_demo').attr('src', URL.createObjectURL(event.target.files[0]));
	}

	$("#feat_col_sec_image").change(function () {    
		var fileExtension = ['jpeg', 'jpg', 'png','gif'];    

		if($.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) == -1) {
         swal("Only " +fileExtension.join(', ') +" formats are allowed");
           document.getElementById("feat_col_sec_image").value = "";
           $('#feat_col_sec_image_demo').hide();
	    }else{
	    	$('#feat_col_sec_image_demo').show();
		    $('#feat_col_sec_image_demo').attr('src', URL.createObjectURL(event.target.files[0]));  
	    }	     
	});
</script>
@endsection