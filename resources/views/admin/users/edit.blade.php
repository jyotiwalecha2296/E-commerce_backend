@extends('admin.layouts.app') 
@section('content')
  <div class="container-fluid pt-5">
    <span class="title-data" id="titleData" data-link="users/create" data-parent="users" data-title="Update user"></span>
    {!!Form::model($data,['method'=>'PATCH', 'route'=>['users.update',$data->id] ,'id'=>'form','files'=>'true' ,'data-parsley-validate' => '','name'=>'users_form']) !!}         
    {{ csrf_field() }}
    
      <div class="row">      
        <div class="col-lg-9 col-md-8 col-sm-7 order-2 order-sm-1">     
          <div class="card custom_card mb-3">
            <div class="row">
              <div class="col-sm-12">
                <span class="fs-6">User Information</span>
              </div>
            </div>
            <div class="card-body">   

              <div class="form-group row">
                 <div class="col-sm-6 mb-3">
                  <label for="name" class="form-label">First Name</label>            
                  <div class="input-group">
                          <div class="input-group-prepend col-sm-2">
                            <select name="status" class="form-control" id="">                               
                              <option value="Mr" @if($data->status=="Mr") selected @endif >Mr</option> 
                              <option value="Mrs" @if($data->status=="Mrs") selected @endif >Mrs</option> 
                              <option value="Ms" @if($data->status=="Ms") selected @endif >Ms</option>                                                      
                            </select>
                          </div>
                          <input type="text" name="first_name" class="form-control  @error('first_name') is-invalid @enderror" placeholder="Enter First Name" value="{{$data->first_name}}"> 
                        </div>
                  @error('first_name')
                    <span class="invalid-feedback" role="alert">
                      {{ $message }}
                    </span>
                  @enderror
                </div>
                <div class="col-sm-6 mb-3">
                  <label for="name" class="form-label">Last Name</label>              
                  <input type="text" name="last_name" class="form-control  @error('last_name') is-invalid @enderror" placeholder="Enter Last Name" value="{{$data->last_name}}">              
                  @error('last_name')
                    <span class="invalid-feedback" role="alert">
                      {{ $message }}
                    </span>
                  @enderror
                </div>       
              </div>


              <div class="form-group row">
                     <div class="col-sm-6 mb-3">
                      <label for="tagline" class="form-label">Email</label>              
                      <input type="email" name="email" class="form-control  @error('email') is-invalid @enderror" placeholder="Enter email" value="{{$data->email}}">              
                      @error('email')
                        <span class="invalid-feedback" role="alert">
                          {{ $message }}
                        </span>
                      @enderror
                    </div>
                    <div class="col-sm-6 mb-3">
                      <label for="tagline" class="form-label">Phone</label>              
                         <div class="input-group">
                          <div class="input-group-prepend col-sm-2">
                            <select name="country_code" class="form-control">
                              @foreach($country_codes as $country_code) 
                              <option value="{{$country_code->country_code}}" @if($data->country_code==$country_code->country_code) selected @endif >{{$country_code->country_code}}</option> 
                              @endforeach                             
                            </select>
                          </div>
                          <input type="tel" class="form-control" maxlength="10" name="phone" placeholder="Enter phone number" value="{{$data->contact_no}}">
                        </div>              
                      @error('phone')
                        <span class="invalid-feedback" role="alert">
                          {{ $message }}
                        </span>
                      @enderror
                    </div>               
              </div>

              <div class="form-group row">             
                <div class="col-sm-6 mb-3">
                  <label for="name" class="form-label">Birth Date</label>              
                  <input type="date" name="birth_date" class="form-control  @error('birth_date') is-invalid @enderror" placeholder="Enter  date of birth" value="{{$data->birth_date}}">              
                  @error('birth_date')
                    <span class="invalid-feedback" role="alert">
                      {{ $message }}
                    </span>
                  @enderror
                </div>
                <div class="col-sm-6 mb-3">
                  <label for="name" class="form-label">Old Password</label>              
                   <input type="password" name="old_password" class="form-control field-validate"  autocomplete="password" placeholder="Enter old password">  
                     @error('old_password')
                    <span class="invalid-feedback" role="alert">
                      {{ $message }}
                    </span>
                    @enderror
                </div>
            </div>

            <div class="form-group row">             
                <div class="col-sm-6 mb-3">
                  <label for="name" class="form-label">New Password</label>              
                  <input type="password" name="new_password" class="form-control  @error('new_password') is-invalid @enderror" placeholder="Enter  new password">
                  @error('new_password')
                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                  @enderror
                </div>
                <div class="col-sm-6 mb-3">
                  <label for="name" class="form-label">Confirm New  Password </label>              
                   <input type="password" name="new_confirm_password" class="form-control field-validate"    placeholder="Confirm new password">  
                     @error('new_confirm_password')
                    <span class="invalid-feedback" role="alert">
                      {{ $message }}
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
                  <span class="title">Create User </span> 
                  <span class="icon">
                    <i class="lni lni-chevron-down"></i>
                    <i class="lni lni-chevron-up"></i>
                  </span>
                </a>
              </div>
              <div class="card-body">
                <div class="collapse show" id="pageInfo">
                  <div class="col-sm-12 mb-3">
                    <label for="status" class="form-label">Status</label>
                    <select class="form-select" name="user_status" id="status" aria-label=".form-select-lg example">
                      <option value="" disabled selected>Select Status</option>
                      <option value="0" @if($data->user_status=="0") selected @endif >Disable</option>
                      <option value="1" @if($data->user_status=="1") selected @endif >Enable</option>
                    </select>
                    @error('user_status')
                      <span class="invalid-feedback" role="alert">
                        {{ $message }}
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
              <a class="collapse-border-box" data-bs-toggle="collapse" href="#banner-image" role="button" aria-expanded="true" aria-controls="pageSeoSettings">
                <span class="title">Profile Image</span> 
                <span class="icon">
                  <i class="lni lni-chevron-down"></i>
                  <i class="lni lni-chevron-up"></i>
                </span>
              </a>
            </div>              
            <div class="collapse show" id="banner-image">
              <div class="card-body border-top">                  
                <div class="row">
                <label for="logo" class="form-label">Profile Image</label> 
                <div class="mb-2">
                  <input type="file" class="form-control" name="profile_image" id="profile_image" placeholder="Please upload image " onchange="loadprofileimage()">
                   <p class="image-dimesion-label">For best results, use 250 px by 250 px image</p>
                  <input type="hidden" name="old_profile_image" value="{{$data->image}}" >
                  @error('image')
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                  @enderror
                </div>
                <div class="thumpnail-wrap">           
                  <img src="{{ asset($data->image ?: 'public/images/user.png') }}" alt="Profile Image" class="img-thumbnail" height="50" width="100">
                  <img id="profile_image_demo"  class="img-thumbnail" height="50" width="100" style="display:none"/>
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
    function loadprofileimage(){
      $('#profile_image_demo').show();
      $('#profile_image_demo').attr('src', URL.createObjectURL(event.target.files[0]));
    }

    $("#profile_image").change(function () {    
      var fileExtension = ['jpeg', 'jpg', 'png','gif'];

      $('#profile_image_demo').show();
      $('#profile_image_demo').attr('src', URL.createObjectURL(event.target.files[0]));

    });


    
  </script>
@endsection