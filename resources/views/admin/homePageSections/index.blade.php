@extends('admin.layouts.app') 
@section('content')

<span class="title-data" id="titleData" data-link="homepage-settings" data-parent="" data-title="homepage settings"></span> 
<div class="container-fluid pt-5">
	<form role="form" data-parsley-validate="" method="POST" action="{{url('update-homepage-sections')}}" enctype='multipart/form-data'>
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
										<div class="col-sm-6" >
											<div class="form-group row">
												<label for="title" class="col-sm-12 col-form-label">Title </label>
												<div class="col-sm-12">
													<input name="about_title" type="text" class="form-control" id="title" placeholder="Enter title" value="{{$data->about_title}}" />
												</div>
											</div> 
										</div>
										<div class="col-sm-6" >
											<div class="form-group row">
												<label for="copyright_text" class="col-sm-12 col-form-label">Subtitle</label>
												<div class="col-sm-12">
													<input type="text" name="about_subtile"  class="form-control" placeholder="Enter subtitle" value="{{$data->about_subtile}}" />
												</div>
											</div>
										</div>
									</div>

									<div class="form-group row mb-3">
										<div class="col-sm-6" >
											<div class="form-group row">
												<label for="title" class="col-sm-12 col-form-label">Button Label </label>
												<div class="col-sm-12">
													<input type="text" name="about_button_text" class="form-control" id="title" placeholder="Enter button label" value="{{$data->about_button_text}}" />
												</div>
											</div> 
										</div>
										<div class="col-sm-6">
											<div class="form-group row">
												<label for="copyright_text" class="col-sm-12 col-form-label">Button Link</label>
												<div class="col-sm-12">
													<input type="text" name="about_button_link"  class="form-control" placeholder="Enter button link" value="{{$data->about_button_link}}" />
												</div>
											</div>
										</div>
									</div>
									<div class="form-group row mb-4">					
										<div class="col-sm-6" >
											<div class="form-group row">
												<div class="col-sm-12 mb-3">	
													<label for="about_logo" class="col-sm-12 col-form-label">About Logo </label>
													<input type="file" name="about_logo" id="about_logo" placeholder="Footer Logo" onchange="loadaboutlogo()"/>
													<p class="image-dimesion-label">For best results, use 219 px by 88 px image</p>
													<input type="hidden" name="old_about_logo" value="{{$data->about_logo }}"/ >
												</div>
												<div class="col-sm-12 thumpnail-wrap">
													<img id="aboutlogodemo" class="img-thumbnail" width="100" style="display:none"/>
													<img src="{{asset($data->about_logo ?: 'public/image_placeholder.png') }}" alt="Logo" class="img-thumbnail" width="100"/>											 
												</div>
											</div>
										</div>							 
									</div>

								</div>
							</div>
						</div>						
					</div>
				</div>

				<!-- Trigalight -->
				<div class="card custom_card mb-3">
					<div class="collapse-box">
						<a class="collapse-border-box" data-bs-toggle="collapse" href="#trigalightsec" role="button" aria-expanded="false" aria-controls="pagecontactinfo">
							<span class="fs-6 title">Trigalight section</span> 
							<span class="icon">
								<i class="lni lni-chevron-down"></i>
								<i class="lni lni-chevron-up"></i>
							</span>
						</a>
						<div class="collapse" id="trigalightsec">
							<div class="collapse-content">
								<div class="card-body">
									<div class="form-group row mb-3">
										<div class="col-sm-6" >
											<div class="form-group row">
												<label for="title" class="col-sm-12 col-form-label">Title </label>
												<div class="col-sm-12">
													<input name="trigalight_title" type="text" class="form-control" id="title" placeholder="Enter title" value="{{$data->trigalight_title}}" >
												</div>
											</div> 
										</div>
										<div class="col-sm-6" >
											<div class="form-group row">
												<label for="copyright_text" class="col-sm-12 col-form-label">Subtitle</label>
												<div class="col-sm-12">
													<input type="text" name="trigalight_subtitle"  class="form-control" placeholder="Enter subtitle" value="{{$data->trigalight_subtitle}}" >
												</div>
											</div>
										</div>
									</div>
									<div class="form-group row mb-3">

										<div class="col-sm-9" >
											<div class="form-group row">
												<label for="title" class="col-sm-12 col-form-label">Content </label>
												<div class="col-sm-12">
													<textarea name="trigalight_content" id="trigalight_content" class="form-control @error('trigalight_content') is-invalid @enderror" placeholder="Please enter content here">{{htmlspecialchars_decode(str_replace("&quot;", "\"",$data->trigalight_content))}}</textarea>
													<script>
														CKEDITOR.replace('trigalight_content');
													</script>
												</div>
											</div> 
										</div>	

										<div class="col-sm-3" >
											<div class="form-group row">
												<div class="col-sm-12 mb-3">	
													<label for="trigalight_title_image" class="col-sm-12 col-form-label">Title Image </label>
													<input type="file" name="trigalight_title_image" id="trigalight_title_image" onchange="loadtrigalighttitleimage()">
													<p class="image-dimesion-label">For best results, use 219 px by 88 px image</p>
													<input type="hidden" name="old_trigalight_title_image" value="{{$data->trigalight_title_image }}" >
												</div>
												<div class="col-sm-12 thumpnail-wrap">
													<img id="trigalight_title_image_demo" class="img-thumbnail" width="100" style="display:none"/>
													<img src="{{asset($data->trigalight_title_image ?: 'public/image_placeholder.png') }}" alt="trigalight" class="img-thumbnail" width="200">											 
												</div>
											</div>
										</div>

									</div>

									<div class="form-group row mb-3">
										
										<div class="col-sm-4" >
											<div class="form-group row">
												<div class="col-sm-12 mb-3">	
													<label for="trigalight_background_image" class="col-sm-12 col-form-label">Background Image </label>
													<input type="file" name="trigalight_background_image" id="trigalight_background_image" onchange="loadtrigalightbackimage()">
													<p class="image-dimesion-label">For best results, use 219 px by 88 px image</p>
													<input type="hidden" name="old_trigalight_background_image" value="{{$data->trigalight_background_image }}" >
												</div>
												<div class="col-sm-12 thumpnail-wrap">
													<img id="trigalight_background_image_demo" class="img-thumbnail" width="100" style="display:none"/>
													<img src="{{asset($data->trigalight_background_image ?: 'public/image_placeholder.png') }}" alt="Background Image" class="img-thumbnail" width="200">											 
												</div>
											</div>
										</div>

										<div class="col-sm-4" >
											<div class="form-group row">
												<div class="col-sm-12 mb-3">	
													<label for="trigalight_first_image" class="col-sm-12 col-form-label">Day View Image </label>
													<input type="file" name="trigalight_first_image" id="trigalight_first_image" onchange="loadTrigalightDayImage()">
													<p class="image-dimesion-label">For best results, use 219 px by 88 px image</p>
													<input type="hidden" name="old_trigalight_first_image" value="{{$data->trigalight_first_image }}" >
												</div>
												<div class="col-sm-12 thumpnail-wrap">
													<img id="trigalight_first_image_demo" class="img-thumbnail" width="100" style="display:none"/>
													<img src="{{asset($data->trigalight_first_image ?: 'public/image_placeholder.png') }}" alt="Day View Image" class="img-thumbnail" width="200">											 
												</div>
											</div>
										</div>
										<div class="col-sm-4" >
											<div class="form-group row">
												<div class="col-sm-12 mb-3">	
													<label for="trigalight_second_image" class="col-sm-12 col-form-label">Night View Image </label>
													<input type="file" name="trigalight_second_image" id="trigalight_second_image" onchange="loadTrigalightNightImage()">
													<p class="image-dimesion-label">For best results, use 219 px by 88 px image</p>
													<input type="hidden" name="old_trigalight_second_image" value="{{$data->trigalight_second_image }}" >
												</div>
												<div class="col-sm-12 thumpnail-wrap">
													<img id="trigalight_second_image_demo" class="img-thumbnail" width="100" style="display:none"/>
													<img src="{{asset($data->trigalight_second_image ?: 'public/image_placeholder.png') }}" alt="Night View Image" class="img-thumbnail" width="200">											 
												</div>
											</div>
										</div>	


									</div>
								</div>
							</div>
						</div>
					</div>
				</div> 

				<!-- Video section -->
				<div class="card custom_card mb-3">
					<div class="collapse-box">
						<a class="collapse-border-box" data-bs-toggle="collapse" href="#videosec" role="button" aria-expanded="false" aria-controls="pagecontactinfo">
							<span class="fs-6 title">Video section</span> 
							<span class="icon">
								<i class="lni lni-chevron-down"></i>
								<i class="lni lni-chevron-up"></i>
							</span>
						</a>
						<div class="collapse" id="videosec">
							<div class="collapse-content">
								<div class="card-body">


									<div class="form-group row"> 
										<div class="col-sm-7 ">          
											<label  class="form-label"> video</label>      


											<select class="form-select @error('home_video') is-invalid @enderror" name="home_video" id="position" aria-label=".form-select-lg example">
												@foreach($videos as $vlink)
												<option value="{{$vlink->path}}" @if($vlink->path==$data->home_video) selected @endif >{{$vlink->name}}</option>
												@endforeach   
											</select>

											@error('home_video')
											<span class="invalid-feedback" role="alert">
												<strong>{{ $message }}</strong>
											</span>
											@enderror 
										</div>

										<div class="col-sm-5">          
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

				<!-- Catalogue section -->
				<div class="card custom_card mb-3">
					<div class="collapse-box">
						<a class="collapse-border-box" data-bs-toggle="collapse" href="#cataloguesec" role="button" aria-expanded="false" aria-controls="pagecontactinfo">
							<span class="fs-6 title">Catalogue section</span> 
							<span class="icon">
								<i class="lni lni-chevron-down"></i>
								<i class="lni lni-chevron-up"></i>
							</span>
						</a>
						<div class="collapse" id="cataloguesec">
							<div class="collapse-content">
								<div class="card-body">
									<div class="form-group row mb-3">									 
										<div class="col-sm-6" >
											<div class="form-group row">
												<label for="copyright_text" class="col-sm-12 col-form-label">catalogue subtitle</label>
												<div class="col-sm-12">
													<input type="text" name="catalogue_subtitle"  class="form-control" placeholder="Enter subtitle" value="{{$data->catalogue_subtitle}}" >
												</div>
											</div>
										</div>
										<div class="col-sm-6" >
											<div class="form-group row">
												<label for="copyright_text" class="col-sm-12 col-form-label">Button label</label>
												<div class="col-sm-12">
													<input type="text" name="catalogue_btn_label"  class="form-control" placeholder="Enter button label" value="{{$data->catalogue_btn_label}}" >
												</div>
											</div>
										</div>
									</div>
									<div class="form-group row mb-3">
										<div class="col-sm-9" >
											<div class="form-group row">
												<label for="title" class="col-sm-12 col-form-label">Content</label>
												<div class="col-sm-12">
													<textarea name="catalogue_content" id="catalogue_content" class="form-control @error('catalogue_content') is-invalid @enderror" placeholder="Please enter content here">{{htmlspecialchars_decode(str_replace("&quot;", "\"",$data->catalogue_content))}}</textarea>
													<script>
														CKEDITOR.replace('catalogue_content');
													</script>
												</div>
											</div> 
										</div>	
										<div class="col-sm-3" >
											<div class="form-group row">
												<div class="col-sm-12 mb-3">	
													<label for="catalogue_logo" class="col-sm-12 col-form-label">Logo </label>
													<input type="file" name="catalogue_logo" id="catalogue_logo" onchange="loadcataloguelogo()">
													<p class="image-dimesion-label">For best results, use 219 px by 88 px image</p>
													<input type="hidden" name="old_catalogue_logo" value="{{$data->catalogue_logo }}" >
												</div>
												<div class="col-sm-12 thumpnail-wrap">
													<img id="catalogue_logo_demo" class="img-thumbnail" width="100" style="display:none"/>
													<img src="{{asset($data->catalogue_logo ?: 'public/image_placeholder.png') }}" alt="E-Commerce" class="img-thumbnail" width="200">											 
												</div>
											</div>
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

				<!-- Parallax section -->
				<div class="card custom_card mb-3">
					<div class="collapse-box">
						<a class="collapse-border-box" data-bs-toggle="collapse" href="#parallaxsec" role="button" aria-expanded="false" aria-controls="pagecontactinfo">
							<span class="fs-6 title">Parallax section</span> 
							<span class="icon">
								<i class="lni lni-chevron-down"></i>
								<i class="lni lni-chevron-up"></i>
							</span>
						</a>
						<div class="collapse" id="parallaxsec">
							<div class="collapse-content">
								<div class="card-body">

									<div class="form-group row mb-3">
										<div class="col-sm-12" >
											<div class="form-group row">
												<label for="title" class="col-sm-12 col-form-label">Content</label>
												<div class="col-sm-12">
													<textarea name="parallax_content" id="parallax_content" class="form-control @error('parallax_content') is-invalid @enderror" placeholder="Please enter content here">{{htmlspecialchars_decode(str_replace("&quot;", "\"",$data->parallax_content))}}</textarea>
													<script>
														CKEDITOR.replace('parallax_content');
													</script>
												</div>
											</div> 
										</div>									 
									</div>

									<div class="form-group row mb-3">
										<div class="col-sm-12" >
											<div class="form-group row">
												<div class="col-sm-12 mb-3">	
													<label for="parallax_back_image" class="col-sm-12 col-form-label">Background Image </label>
													<input type="file" name="parallax_back_image" id="parallax_back_image" onchange="load_parallax_back_image()">
													<!-- <p class="image-dimesion-label">For best results, use 219 px by 88 px image</p> -->
													<input type="hidden" name="old_parallax_back_image" value="{{$data->parallax_back_image}}" >
												</div>
												<div class="col-sm-12 thumpnail-wrap">
													<img id="parallax_back_image_demo" class="img-thumbnail" width="100" style="display:none"/>
													@if($data->parallax_back_image != null)
													<img src="{{asset($data->parallax_back_image ?: 'public/image_placeholder.png') }}" alt="E-Commerce" class="img-thumbnail" width="300">
													@endif											 
												</div>
											</div> 
										</div>									 
									</div>

									<div class="form-group row mb-3">

										<div class="col-sm-4" >
											<div class="form-group row">
												<div class="col-sm-12 mb-3">	
													<label for="parallax_first_img" class="col-sm-12 col-form-label">Image </label>
													<input type="file" name="parallax_first_img" id="parallax_first_img" onchange="load_parallax_first_img()">
													<!-- <p class="image-dimesion-label">For best results, use 219 px by 88 px image</p> -->
													<input type="hidden" name="old_parallax_first_img" value="{{$data->parallax_first_img}}" >
												</div>
												<div class="col-sm-12 thumpnail-wrap">
													<img id="parallax_first_img_demo" class="img-thumbnail" width="100" style="display:none"/>
													@if($data->parallax_first_img != null)
													<img src="{{asset($data->parallax_first_img ?: 'public/image_placeholder.png') }}" alt="E-Commerce" class="img-thumbnail" width="200">
													@endif											 
												</div>
											</div>
										</div>	

										<div class="col-sm-4" >
											<div class="form-group row">
												<div class="col-sm-12 mb-3">	
													<label for="parallax_sec_img" class="col-sm-12 col-form-label">Image </label>
													<input type="file" name="parallax_sec_img" id="parallax_sec_img" onchange="load_parallax_sec_img()">
													<!-- <p class="image-dimesion-label">For best results, use 219 px by 88 px image</p> -->
													<input type="hidden" name="old_parallax_sec_img" value="{{$data->parallax_sec_img }}" >
												</div>
												<div class="col-sm-12 thumpnail-wrap">
													<img id="parallax_sec_img_demo" class="img-thumbnail" width="100" style="display:none"/>
													@if($data->parallax_sec_img != null)
													<img src="{{asset($data->parallax_sec_img ?: 'public/image_placeholder.png') }}" alt="E-Commerce" class="img-thumbnail" width="200">	
													@endif												 
												</div>
											</div>
										</div>	

										<div class="col-sm-4" >
											<div class="form-group row">
												<div class="col-sm-12 mb-3">	
													<label for="parallax_third_img" class="col-sm-12 col-form-label">Image </label>
													<input type="file" name="parallax_third_img" id="parallax_third_img" onchange="load_parallax_third_img()">
													<!-- <p class="image-dimesion-label">For best results, use 219 px by 88 px image</p> -->
													<input type="hidden" name="old_parallax_third_img" value="{{$data->parallax_third_img }}" >
												</div>
												<div class="col-sm-12 thumpnail-wrap">
													<img id="parallax_third_img_demo" class="img-thumbnail" width="100" style="display:none"/>
													@if($data->parallax_third_img != null)
													<img src="{{asset($data->parallax_third_img ?: 'public/image_placeholder.png') }}" alt="E-Commerce" class="img-thumbnail" width="200">	
													@endif											 
												</div>
											</div>
										</div>	



									</div>

								</div>
							</div>
						</div>
					</div>
				</div>

				<!-- Strap section -->
				<div class="card custom_card mb-3">
					<div class="collapse-box">
						<a class="collapse-border-box" data-bs-toggle="collapse" href="#strapsec" role="button" aria-expanded="false" aria-controls="pagecontactinfo">
							<span class="fs-6 title">Strap section</span> 
							<span class="icon">
								<i class="lni lni-chevron-down"></i>
								<i class="lni lni-chevron-up"></i>
							</span>
						</a>
						<div class="collapse" id="strapsec">
							<div class="collapse-content">
								<div class="card-body">

									<div class="form-group row mb-3">
										<div class="col-sm-6" >
											<div class="form-group row">
												<label for="title" class="col-sm-12 col-form-label">Title </label>
												<div class="col-sm-12">
													<input name="strap_sec_title" type="text" class="form-control" id="title" placeholder="Enter title" value="{{$data->strap_sec_title}}" />
												</div>
											</div> 
										</div>
										<div class="col-sm-6" >
											<div class="form-group row">
												<label for="copyright_text" class="col-sm-12 col-form-label">Button Text</label>
												<div class="col-sm-12">
													<input type="text" name="strap_sec_btn_label"  class="form-control" placeholder="Enter button text" value="{{$data->strap_sec_btn_label}}" />
												</div>
											</div>
										</div>
									</div>
									<div class="form-group row mb-3">
										<div class="col-sm-12" >
											<div class="form-group row">
												<label for="title" class="col-sm-12 col-form-label">Button Link </label>
												<div class="col-sm-12">
													<input name="strap_sec_btn_link" type="text" class="form-control" id="title" placeholder="Enter button link" value="{{$data->strap_sec_btn_link}}" />
												</div>
											</div> 
										</div>

									</div>


									<div class="form-group row mb-3">
										<div class="col-sm-10" >
											<div class="form-group row">
												<label for="title" class="col-sm-12 col-form-label">Content</label>
												<div class="col-sm-12">
													<textarea name="strap_sec_content" id="parallax_content" class="form-control @error('strap_sec_content') is-invalid @enderror" placeholder="Please enter content here">{{htmlspecialchars_decode(str_replace("&quot;", "\"",$data->strap_sec_content))}}</textarea>
													<script>
														CKEDITOR.replace('strap_sec_content');
													</script>
												</div>
											</div> 
										</div>	
										<div class="col-sm-2" >
											<div class="form-group row">
												<div class="col-sm-12 mb-3">	
													<label for="strap_sec_image" class="col-sm-12 col-form-label">Image </label>
													<input type="file" name="strap_sec_image" id="strap_sec_image" onchange="load_strap_sec_image()">
													<!-- <p class="image-dimesion-label">For best results, use 219 px by 88 px image</p> -->
													<input type="hidden" name="old_strap_sec_image" value="{{$data->strap_sec_image}}" >
												</div>
												<div class="col-sm-12 thumpnail-wrap">
													<img id="strap_sec_image_demo" class="img-thumbnail" width="100" style="display:none"/>
													@if($data->strap_sec_image != null)
													<img src="{{asset($data->strap_sec_image ?: 'public/image_placeholder.png') }}" alt="E-Commerce" class="img-thumbnail" width="300">
													@endif											 
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
	}

	function load_strap_sec_image(){
		$('#strap_sec_image_demo').show();
		$('#strap_sec_image_demo').attr('src', URL.createObjectURL(event.target.files[0]));
	}

	$("#strap_sec_image").change(function () {    
		var fileExtension = ['jpeg', 'jpg', 'png','gif'];     
		$('#strap_sec_image_demo').show();
		$('#strap_sec_image_demo').attr('src', URL.createObjectURL(event.target.files[0]));       
	});


	function load_parallax_first_img(){
		$('#parallax_first_img_demo').show();
		$('#parallax_first_img_demo').attr('src', URL.createObjectURL(event.target.files[0]));
	}

	$("#parallax_first_img").change(function () {    
		var fileExtension = ['jpeg', 'jpg', 'png','gif'];     
		$('#parallax_first_img_demo').show();
		$('#parallax_first_img_demo').attr('src', URL.createObjectURL(event.target.files[0]));       
	});

	function load_parallax_back_image(){
		$('#parallax_back_image_demo').show();
		$('#parallax_back_image_demo').attr('src', URL.createObjectURL(event.target.files[0]));
	}

	$("#parallax_back_image").change(function () {    
		var fileExtension = ['jpeg', 'jpg', 'png','gif'];     
		$('#parallax_back_image_demo').show();
		$('#parallax_back_image_demo').attr('src', URL.createObjectURL(event.target.files[0]));       
	});


	function load_parallax_sec_img(){
		$('#parallax_sec_img_demo').show();
		$('#parallax_sec_img_demo').attr('src', URL.createObjectURL(event.target.files[0]));
	}

	$("#parallax_sec_img").change(function () {    
		var fileExtension = ['jpeg', 'jpg', 'png','gif'];     
		$('#parallax_sec_img_demo').show();
		$('#parallax_sec_img_demo').attr('src', URL.createObjectURL(event.target.files[0]));       
	});


	function load_parallax_third_img(){
		$('#parallax_third_img_demo').show();
		$('#parallax_third_img_demo').attr('src', URL.createObjectURL(event.target.files[0]));
	}

	$("#parallax_third_img").change(function () {    
		var fileExtension = ['jpeg', 'jpg', 'png','gif'];     
		$('#parallax_third_img_demo').show();
		$('#parallax_third_img_demo').attr('src', URL.createObjectURL(event.target.files[0]));       
	});


	function loadfeatfirstimg(){
		$('#feat_col_first_image_demo').show();
		$('#feat_col_first_image_demo').attr('src', URL.createObjectURL(event.target.files[0]));
	}

	$("#feat_col_first_image").change(function () {    
		var fileExtension = ['jpeg', 'jpg', 'png','gif'];     
		$('#feat_col_first_image_demo').show();
		$('#feat_col_first_image_demo').attr('src', URL.createObjectURL(event.target.files[0]));       
	});

	function loadfeatsecimg(){
		$('#feat_col_sec_image_demo').show();
		$('#feat_col_sec_image_demo').attr('src', URL.createObjectURL(event.target.files[0]));
	}

	$("#feat_col_sec_image").change(function () {    
		var fileExtension = ['jpeg', 'jpg', 'png','gif'];     
		$('#feat_col_sec_image_demo').show();
		$('#feat_col_sec_image_demo').attr('src', URL.createObjectURL(event.target.files[0]));       
	});

	function loadcataloguelogo(){
		$('#catalogue_logo_demo').show();
		$('#catalogue_logo_demo').attr('src', URL.createObjectURL(event.target.files[0]));
	}

	$("#catalogue_logo").change(function () {    
		var fileExtension = ['jpeg', 'jpg', 'png','gif'];     
		$('#catalogue_logo_demo').show();
		$('#catalogue_logo_demo').attr('src', URL.createObjectURL(event.target.files[0]));       
	});
	function loadaboutlogo(){
		$('#aboutlogodemo').show();
		$('#aboutlogodemo').attr('src', URL.createObjectURL(event.target.files[0]));
	}

	$("#about_logo").change(function () {    
		var fileExtension = ['jpeg', 'jpg', 'png','gif'];     
		$('#aboutlogodemo').show();
		$('#aboutlogodemo').attr('src', URL.createObjectURL(event.target.files[0]));       
	});
	function loadaboutlogo(){
		$('#aboutlogodemo').show();
		$('#aboutlogodemo').attr('src', URL.createObjectURL(event.target.files[0]));
	}

	$("#about_logo").change(function () {    
		var fileExtension = ['jpeg', 'jpg', 'png','gif'];     
		$('#aboutlogodemo').show();
		$('#aboutlogodemo').attr('src', URL.createObjectURL(event.target.files[0]));       
	}); 

	function loadtrigalightbackimage(){
		$('#trigalight_background_image_demo').show();
		$('#trigalight_background_image_demo').attr('src', URL.createObjectURL(event.target.files[0]));
	}

	$("#trigalight_background_image").change(function () {    
		var fileExtension = ['jpeg', 'jpg', 'png','gif'];     
		$('#trigalight_background_image_demo').show();
		$('#trigalight_background_image_demo').attr('src', URL.createObjectURL(event.target.files[0]));       
	}); 

	function loadTrigalightDayImage(){
		$('#trigalight_first_image_demo').show();
		$('#trigalight_first_image_demo').attr('src', URL.createObjectURL(event.target.files[0]));
	}

	$("#trigalight_first_image").change(function () {    
		var fileExtension = ['jpeg', 'jpg', 'png','gif'];     
		$('#trigalight_first_image_demo').show();
		$('#trigalight_first_image_demo').attr('src', URL.createObjectURL(event.target.files[0]));       
	}); 

	function loadTrigalightNightImage(){
		$('#trigalight_second_image_demo').show();
		$('#trigalight_second_image_demo').attr('src', URL.createObjectURL(event.target.files[0]));
	}

	$("#trigalight_second_image").change(function () {    
		var fileExtension = ['jpeg', 'jpg', 'png','gif'];     
		$('#trigalight_second_image_demo').show();
		$('#trigalight_second_image_demo').attr('src', URL.createObjectURL(event.target.files[0]));       
	}); 

	function loadtrigalighttitleimage(){
		$('#trigalight_title_image_demo').show();
		$('#trigalight_title_image_demo').attr('src', URL.createObjectURL(event.target.files[0]));
	}

	$("#trigalight_title_image").change(function () {    
		var fileExtension = ['jpeg', 'jpg', 'png','gif'];     
		$('#trigalight_title_image_demo').show();
		$('#trigalight_title_image_demo').attr('src', URL.createObjectURL(event.target.files[0]));       
	});
</script>
@endsection