@extends('admin.layouts.app')  
@section('content')
<div class="container">
    <span class="title-data" id="titleData" data-link="profile" data-parent="" data-title="profile"></span> 
    <div class="row pt-5">
        <div class="col-md-12"> 
            <div class="card custom_card">                               
                <!-- <p class="sub-p">Please update your information.</p> -->
                {!! Form::model($data, ['method' =>'POST','url' => ['/update-profile'],'files'=>'true', 'data-parsley-validate' => '','name'=>'profile']) !!}
                    @csrf
                    @if(Session::has('success')) 
                        <div class="alert alert-success">
                            {{ Session::get('success') }}
                            @php
                                Session::forget('success');
                            @endphp
                        </div>
                    @endif                             
                    @foreach ($errors->all() as $error)
                        <div class="alert alert-danger"> {{ $error }}</div><br/>
                    @endforeach 
                    <div class="card-body">
                        <div class="row">
                          <div class="col-sm-12 mb-3">
                            <span class="fs-6">Please update your information</span>
                          </div>
                        </div>                                      
                        <div class="form-group row mb-3">
                            <div class="col-sm-6">                                        
                                <label for="title" class="col-sm-12 col-form-label">Name </label>
                                <div class="col-sm-12">
                                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{$data->name}}" placeholder="Name" autocomplete="off" required autocomplete="name" autofocus>
                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                           <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror 
                                </div>    
                            </div>
                            <div class="col-sm-6">
                                <label for="title" class="col-sm-12 col-form-label">Email </label>
                                <div class="col-sm-12">
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $data->email  }}" placeholder="E-mail" autocomplete="off" required autocomplete="email">
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                           <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>  
                            </div>
                        </div>
                        <div class="form-group row mb-3">
                            <div class="col-sm-6">
                                <label for="title" class="col-sm-12 col-form-label">Password </label>
                                <div class="col-sm-12">
                                    <input type="password" name="password" class="form-control field-validate"  autocomplete="new-password" placeholder="Please enter new password">
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div> 
                            </div>
                            <div class="col-sm-6">
                            	<label for="title" class="col-sm-12 col-form-label">Confirm Password </label>
                                <div class="col-sm-12">
                                    <input type="password" name="password_confirmation" class="form-control field-validate" placeholder="Please re-enter new password">
                                </div>                           
                            </div>
                        </div>
                        <div class="row">        
                            <div class="col-sm-12 text-end">              
                              <button type="submit" class="btn btn-primary">Update Account</button>
                            </div>
                        </div>                                                                      
                    </div>
                {{ Form::close() }}
            </div>
        </div>         
    </div>
</div>
@endsection