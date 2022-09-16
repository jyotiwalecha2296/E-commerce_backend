@extends('admin.layouts.app') 
@section('content')
  <div class="container-fluid pt-5">
    <span class="title-data" id="titleData" data-link="users/create" data-parent="users" data-title="Create users"></span>
    {!! Form::open(['route'=>['users.store'], 'method' => 'POST','files'=>true,'autocomplete'=>'false', 'id'=>'form','data-parsley-validate' => '','class'=>'form-horizontal','name'=>'form']) !!} 
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
                              <option value="Mr">Mr</option> 
                              <option value="Mrs">Mrs</option> 
                              <option value="Ms">Ms</option>                                                      
                            </select>
                          </div>
                          <input type="text" name="first_name" class="form-control  @error('first_name') is-invalid @enderror" placeholder="Enter First Name" value="{{ old('first_name') }}"> 
                        </div>


                  @error('first_name')
                    <span class="invalid-feedback" role="alert">
                      {{ $message }}
                    </span>
                  @enderror
                </div>
                <div class="col-sm-6 mb-3">
                  <label for="name" class="form-label">Last Name</label>              
                  <input type="text" name="last_name" class="form-control  @error('last_name') is-invalid @enderror" placeholder="Enter Last Name" value="{{ old('last_name') }}">              
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
                      <input type="email" name="email" class="form-control  @error('email') is-invalid @enderror" placeholder="Enter email" value="{{ old('email') }}">              
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
                              <option value="{{$country_code->country_code}}">{{$country_code->country_code}}</option> 
                              @endforeach                             
                            </select>
                          </div>
                          <input type="tel" class="form-control" maxlength="10" name="phone" placeholder="Enter phone number" value="{{ old('phone') }}">
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
                  <label for="name" class="form-label">Password</label>              
                   <input type="password" name="password" class="form-control field-validate"  autocomplete="password" placeholder="Enter password">  
                    <p><small> Password must be more than 8 characters long,should contain at-least 1 Uppercase, 1 Lowercase, 1 Numeric and 1 special character.Example : 18tson7P@ </small></p>@error('password')
                    <span class="invalid-feedback" role="alert">
                      {{ $message }}
                    </span>
                    @enderror
                </div>
                <div class="col-sm-6 mb-3">
                  <label for="name" class="form-label">Birth Date</label>              
                  <input type="date" name="birth_date" class="form-control  @error('birth_date') is-invalid @enderror" placeholder="Enter birth date" value="{{ old('birth_date') }}">              
                  @error('birth_date')
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
                      <option value="0">Disable</option>
                      <option value="1">Enable</option>
                    </select>
                    @error('user_status')
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
                  <span class="title">Profile Image</span> 
                  <span class="icon">
                    <i class="lni lni-chevron-down"></i>
                    <i class="lni lni-chevron-up"></i>
                  </span>
                </a>
              </div>
              <div class="card-body">
                <div class="collapse show" id="featured-image">
                  <div class="col-sm-12">
                  <label for="logo" class="form-label">Profile Image</label>

                  <input type="file" class="form-control" name="profile_image" id="profile_image" placeholder="Please upload logo" onchange="loadprofileimage()"><br/>
                  <p class="image-dimesion-label">For best results, use 250  px by 250  px image</p>

                  <img id="profile_image_demo" class="img-thumbnail" height="100" width="200" style="display:none"/>
                  @error('profile_image')
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